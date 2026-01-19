<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Item;
use App\Models\ProductCategory;
use App\Models\PriceGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportItemsFromExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:items {file=public/GNG-OK-2_INVITEMS-01-01-2016.xlsx}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import items from Excel file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');
        
        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        $this->info("Reading Excel file: {$filePath}");

        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            if (empty($rows)) {
                $this->error("Excel file is empty");
                return 1;
            }

            // Get header row (first row)
            $headers = array_map('strtolower', array_map('trim', $rows[0]));
            $this->info("Found columns: " . implode(', ', $headers));

            // Find column indices
            $barcodeIndex = $this->findColumnIndex($headers, ['barcode', 'code']);
            $descriptionIndex = $this->findColumnIndex($headers, ['description', 'desc', 'item_description']);
            $catIndex = $this->findColumnIndex($headers, ['cat', 'category', 'product_category']);
            $caseCostIndex = $this->findColumnIndex($headers, ['case_cost', 'casecost', 'cost']);
            $priceGroupIndex = $this->findColumnIndex($headers, ['price group', 'pricegroup', 'price_group', 'pricegroupname']);

            if ($barcodeIndex === false) {
                $this->error("Barcode/Code column not found in Excel");
                return 1;
            }

            if ($descriptionIndex === false) {
                $this->error("Description column not found in Excel");
                return 1;
            }

            $this->info("Column mapping:");
            $this->info("  Barcode: Column " . ($barcodeIndex + 1));
            $this->info("  Description: Column " . ($descriptionIndex + 1));
            $this->info("  Category: Column " . ($catIndex !== false ? ($catIndex + 1) : 'Not found'));
            $this->info("  Case Cost: Column " . ($caseCostIndex !== false ? ($caseCostIndex + 1) : 'Not found'));
            $this->info("  Price Group: Column " . ($priceGroupIndex !== false ? ($priceGroupIndex + 1) : 'Not found'));

            // Cache for categories and price groups
            $categoryCache = [];
            $priceGroupCache = [];

            $successCount = 0;
            $errorCount = 0;
            $skipCount = 0;

            DB::beginTransaction();

            try {
                // Process data rows (skip header row)
                for ($i = 1; $i < count($rows); $i++) {
                    $row = $rows[$i];

                    // Skip empty rows
                    if (empty(array_filter($row))) {
                        continue;
                    }

                    $barcode = $this->getCellValue($row, $barcodeIndex);
                    $description = $this->getCellValue($row, $descriptionIndex);
                    $cat = $catIndex !== false ? $this->getCellValue($row, $catIndex) : null;
                    $caseCost = $caseCostIndex !== false ? $this->getCellValue($row, $caseCostIndex) : null;
                    $priceGroupName = $priceGroupIndex !== false ? $this->getCellValue($row, $priceGroupIndex) : null;

                    // Skip if barcode is empty
                    if (empty($barcode)) {
                        $skipCount++;
                        continue;
                    }

                    // Get or create ProductCategory
                    $productCategoryId = null;
                    if (!empty($cat)) {
                        $cat = trim($cat);
                        if (!isset($categoryCache[$cat])) {
                            $category = ProductCategory::firstOrCreate(
                                ['name' => $cat],
                                ['active' => true]
                            );
                            $categoryCache[$cat] = $category->id;
                        }
                        $productCategoryId = $categoryCache[$cat];
                    }

                    // Get or create PriceGroup from price group column
                    $priceGroupId = null;
                    if (!empty($priceGroupName)) {
                        $priceGroupName = trim($priceGroupName);
                        if (!isset($priceGroupCache[$priceGroupName])) {
                            $priceGroup = PriceGroup::firstOrCreate(
                                ['group_name' => $priceGroupName],
                                [
                                    'price' => 0, // Default price, can be updated later
                                    'active' => true
                                ]
                            );
                            $priceGroupCache[$priceGroupName] = $priceGroup->id;
                        }
                        $priceGroupId = $priceGroupCache[$priceGroupName];
                    }

                    // Parse case_cost
                    $caseCostValue = null;
                    if (!empty($caseCost)) {
                        $caseCostValue = $this->parseDecimal($caseCost);
                    }

                    // Check if item with this code already exists
                    $existingItem = Item::where('code', $barcode)->first();
                    
                    if ($existingItem) {
                        // Update existing item
                        $existingItem->update([
                            'item_description' => $description ?: $existingItem->item_description,
                            'product_category_id' => $productCategoryId ?: $existingItem->product_category_id,
                            'price_group_id' => $priceGroupId ?: $existingItem->price_group_id,
                            'case_cost' => $caseCostValue !== null ? $caseCostValue : $existingItem->case_cost,
                        ]);
                        $this->line("Updated item: {$barcode}");
                    } else {
                        // Create new item
                        Item::create([
                            'code' => $barcode,
                            'item_description' => $description,
                            'product_category_id' => $productCategoryId,
                            'price_group_id' => $priceGroupId,
                            'case_cost' => $caseCostValue,
                        ]);
                        $this->line("Created item: {$barcode}");
                    }

                    $successCount++;
                }

                DB::commit();

                $this->info("\nImport completed!");
                $this->info("Successfully processed: {$successCount} items");
                $this->info("Skipped: {$skipCount} rows");
                $this->info("Errors: {$errorCount}");

            } catch (\Exception $e) {
                DB::rollBack();
                $this->error("Error during import: " . $e->getMessage());
                Log::error("Excel import error", [
                    'file' => $filePath,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return 1;
            }

        } catch (\Exception $e) {
            $this->error("Error reading Excel file: " . $e->getMessage());
            Log::error("Excel file read error", [
                'file' => $filePath,
                'error' => $e->getMessage()
            ]);
            return 1;
        }

        return 0;
    }

    /**
     * Find column index by possible column names
     */
    private function findColumnIndex($headers, $possibleNames)
    {
        foreach ($possibleNames as $name) {
            $index = array_search(strtolower(trim($name)), $headers);
            if ($index !== false) {
                return $index;
            }
        }
        return false;
    }

    /**
     * Get cell value safely
     */
    private function getCellValue($row, $index)
    {
        if ($index === false || !isset($row[$index])) {
            return null;
        }
        $value = $row[$index];
        return is_null($value) ? null : trim((string)$value);
    }

    /**
     * Parse decimal value from cell
     */
    private function parseDecimal($value)
    {
        if (empty($value)) {
            return null;
        }
        
        // Remove any non-numeric characters except decimal point and minus sign
        $cleaned = preg_replace('/[^\d.-]/', '', (string)$value);
        
        if ($cleaned === '' || $cleaned === '-') {
            return null;
        }
        
        $parsed = (float)$cleaned;
        return is_nan($parsed) ? null : $parsed;
    }
}
