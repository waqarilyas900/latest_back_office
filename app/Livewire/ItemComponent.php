<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Item;
use App\Models\Department;
use App\Models\ProductCategory;
use App\Models\SaleType;
use App\Models\UnitOfMeasure;
use App\Models\Size;
use App\Models\MinAge;
use App\Models\NacsCategory;
use App\Models\Payee;
use App\Models\PriceGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\Attributes\On;

#[Layout('layouts.main')]
class ItemComponent extends Component
{
    use WithPagination;

    public $itemId = null;
    public $showForm = false;
    public $active = '1';
    public $search = '';
    public $perPage = 10;
    public $isLoading = false;
    
    // Form fields
    public $code, $item_description, $department_id, $product_category_id, $price_group_id, $payee_id, $sale_type_id, $current_qty, $tag_description;
    public $units_per_case, $unit_retail, $case_cost, $case_discount, $case_rebate, $online_retail, $cost_after_discount, $unit_of_measure_id, $size_id, $margin, $margin_after_rebate, $default_margin;
    public $max_inv, $min_inv, $min_age, $tax_rate, $nacs_code, $blue_law = false, $nacs_category_id, $nacs_sub_category_id, $kitchen_option, $linked_item, $allow_ebt = false, $track_inventory = false, $discounted_item_taxable = false, $ingredient_for_label;

    // For dropdowns
    public $departments = [];
    public $productCategories = [];
    public $priceGroups = [];
    public $saleTypes = [];
    public $unitOfMeasures = [];
    public $sizes = [];
    public $minAges = [];
    public $nacsCategories = [];
    public $payees = [];
    public $selectedItemId;
    
    // Modal properties for Item Codes
    public $showItemCodeModal = false;
    public $selectedItemForCodes = null;
    public $selectedItemCode = '';


    #[On('item-selected')]
    public function loadItem($id)
    {
        $this->selectedItemId = $id;
        $this->itemId = $id;

        $item = Item::with('priceGroups')->find($id);
        if ($item) {
            $this->fill($item->toArray());
        }
    }

    #[On('prepare-new-item')]
    public function prepareNewItem($code)
    {
        $this->selectedItemId = null;
        $this->itemId = null;
        $this->code = $code;
        $this->item_description = '';
        $this->showForm = true;
        session()->flash('info', 'New item code prepared. Fill in the details and save to create the item.');
    }

    protected $rules = [
        'code'                   => 'required|string|max:255',
        'item_description'       => 'required|string|max:255',
        'department_id'          => 'nullable|integer|exists:departments,id',
        'product_category_id'    => 'nullable|integer|exists:product_categories,id',
        'price_group_id'         => 'nullable|integer|exists:price_groups,id',
        'payee_id'               => 'nullable|integer|exists:payees,id',
        'sale_type_id'           => 'nullable|integer|exists:sale_types,id',
        'current_qty'            => 'nullable|numeric|min:0',
        'tag_description'        => 'nullable|string|max:255',
        'units_per_case'         => 'nullable|numeric|min:0',
        'unit_retail'            => 'nullable|numeric|min:0',
        'case_cost'              => 'nullable|numeric|min:0',
        'case_discount'          => 'nullable|numeric|min:0',
        'case_rebate'            => 'nullable|numeric|min:0',
        'online_retail'          => 'nullable|numeric|min:0',
        'cost_after_discount'    => 'nullable|numeric|min:0',
        'unit_of_measure_id'     => 'nullable|integer|exists:unit_of_measures,id',
        'size_id'                => 'nullable|integer|exists:sizes,id',
        'margin'                 => 'nullable|numeric|min:0',
        'margin_after_rebate'    => 'nullable|numeric|min:0',
        'default_margin'         => 'nullable|numeric|min:0',
        'max_inv'                => 'nullable|numeric|min:0',
        'min_inv'                => 'nullable|numeric|min:0',
        'min_age'                => 'nullable|string|max:255',
        'tax_rate'               => 'nullable|string|max:255',
        'nacs_code'              => 'nullable|string|max:255',
        'blue_law'               => 'boolean',
        'nacs_category_id'       => 'nullable|integer|exists:nacs_categories,id',
        'nacs_sub_category_id'   => 'nullable|integer',
        'kitchen_option'         => 'nullable|string|max:255',
        'linked_item'            => 'nullable|string|max:255',
        'allow_ebt'              => 'boolean',
        'track_inventory'        => 'boolean',
        'discounted_item_taxable'=> 'boolean',
        'ingredient_for_label'   => 'nullable|string|max:1000',
    ];


    // public function mount($selectedItemId = null)
    // {
    //     $this->selectedItemId = $selectedItemId;

    //     if ($selectedItemId) {
    //         $this->itemId = $selectedItemId; // Set itemId for validation
    //         $item = Item::find($selectedItemId);
    //         if ($item) {
    //             $this->fill($item->toArray());
    //             $this->showForm = true; // Show form when editing existing item
    //         }
    //     }
    //     $this->departments = Department::where('active', 1)->orderBy('name')->get();
    //     $this->productCategories = ProductCategory::where('active', 1)->orderBy('name')->get();
    //     $this->priceGroups = PriceGroup::where('active', 1)->orderBy('group_name')->get();
    //     $this->saleTypes = SaleType::where('active', 1)->orderBy('name')->get();
    //     $this->unitOfMeasures = UnitOfMeasure::where('active', 1)->orderBy('name')->get();
    //     $this->sizes = Size::where('active', 1)->orderBy('name')->get();
    //     $this->minAges = MinAge::where('active', 1)->orderBy('name')->get();
    //     $this->nacsCategories = NacsCategory::where('active', 1)->orderBy('name')->get();
    //     $this->payees = Payee::orderBy('vendor_name')->get();
    // }
    public function mount($selectedItemId = null)
    {
        $this->selectedItemId = $selectedItemId;

        if ($selectedItemId) {
            $this->itemId = $selectedItemId; // Set itemId for validation
            $item = Item::find($selectedItemId);

            if ($item) {
                $user = Auth::user();

                // ✅ Always start with global item fields
                $data = $item->toArray();

                if ($user->locations()->exists()) {
                    $locationId = $user->locations()->first()->id;

                    $locationData = DB::table('item_location_updates')
                        ->where('item_id', $item->id)
                        ->where('location_id', $locationId)
                        ->first();

                    if ($locationData) {
                        // ✅ Override only non-null location fields
                        foreach ((array) $locationData as $key => $value) {
                            if (!is_null($value)) {
                                $data[$key] = $value;
                            }
                        }
                    }
                }

                $this->fill($data);
                $this->showForm = true; // Show form when editing existing item
            }
        }

        // ✅ Load dropdowns
        $this->departments       = Department::where('active', 1)->orderBy('name')->get();
        $this->productCategories = ProductCategory::where('active', 1)->orderBy('name')->get();
        $this->priceGroups       = PriceGroup::where('active', 1)->orderBy('group_name')->get();
        $this->saleTypes         = SaleType::where('active', 1)->orderBy('name')->get();
        $this->unitOfMeasures    = UnitOfMeasure::where('active', 1)->orderBy('name')->get();
        $this->sizes             = Size::where('active', 1)->orderBy('name')->get();
        $this->minAges           = MinAge::where('active', 1)->orderBy('name')->get();
        $this->nacsCategories    = NacsCategory::where('active', 1)->orderBy('name')->get();
        $this->payees            = Payee::orderBy('vendor_name')->get();
    }

    public function displayForm()
    {
        $this->resetForm();
        $this->showForm = true;
        
        // If no item is selected, show message to search first
        if (!$this->selectedItemId) {
            session()->flash('error', 'Please search and select an item first before adding new details.');
        }
    }

    public function hideForm()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    public function edit($id)
    {
        $item = Item::with('priceGroups')->findOrFail($id);
        $this->itemId = $item->id;

        $user = Auth::user();
        $data = $item->toArray(); // ✅ start with global fields

        if ($user->locations()->exists()) {
            $locationId = $user->locations()->first()->id;

            $locationData = DB::table('item_location_updates')
                ->where('item_id', $item->id)
                ->where('location_id', $locationId)
                ->first();

            if ($locationData) {
                // ✅ override only non-null location values
                foreach ((array) $locationData as $key => $value) {
                    if (!is_null($value)) {
                        $data[$key] = $value;
                    }
                }
            }
        }

        $this->fill($data);

        if ($item->priceGroups->isNotEmpty()) {
            $this->price_group_id = $item->priceGroups->first()->id;
        }

        $this->showForm = true;
    }
    public function save()
    {
        try {
            $this->isLoading = true;

            // Dynamic validation rules
            $rules = $this->rules;

            // Code validation
            if ($this->itemId) {
                $rules['code'] = [
                    'required',
                    'string',
                    'max:255',
                    'unique:items,code,' . $this->itemId
                ];
            } else {
                $rules['code'] = 'required|string|max:255|unique:items,code';
            }

            $validated = $this->validate($rules);

            $user = Auth::user();
            $locationId = $user->locations()->first()?->id;

            if ($this->itemId) {
                // ✅ Only update NON-location specific fields in items
                $item = Item::findOrFail($this->itemId);
                $item->update(collect($validated)->except([
                    'units_per_case',
                    'unit_retail',
                    'case_cost',
                    'case_discount',
                    'case_rebate',
                    'online_retail',
                    'cost_after_discount',
                    'unit_of_measure_id',
                    'size_id',
                    'margin',
                    'margin_after_rebate',
                    'default_margin',
                ])->toArray());

                session()->flash('success', 'Item updated successfully!');
            } else {
                // Create base item
                $item = Item::create(collect($validated)->except([
                    'units_per_case',
                    'unit_retail',
                    'case_cost',
                    'case_discount',
                    'case_rebate',
                    'online_retail',
                    'cost_after_discount',
                    'unit_of_measure_id',
                    'size_id',
                    'margin',
                    'margin_after_rebate',
                    'default_margin',
                ])->toArray());

                session()->flash('success', 'Item created successfully!');
            }

            // ✅ Save location-specific fields in item_location_updates
            if ($locationId) {
                DB::table('item_location_updates')->updateOrInsert(
                    [
                        'item_id'     => $item->id,
                        'location_id' => $locationId,
                    ],
                    [
                        'user_id'             => $user->id, // ✅ Fix for your error
                        'units_per_case'      => $validated['units_per_case'] ?? null,
                        'unit_retail'         => $validated['unit_retail'] ?? null,
                        'case_cost'           => $validated['case_cost'] ?? null,
                        'case_discount'       => $validated['case_discount'] ?? null,
                        'case_rebate'         => $validated['case_rebate'] ?? null,
                        'online_retail'       => $validated['online_retail'] ?? null,
                        'cost_after_discount' => $validated['cost_after_discount'] ?? null,
                        'unit_of_measure_id'  => $validated['unit_of_measure_id'] ?? null,
                        'size_id'             => $validated['size_id'] ?? null,
                        'margin'              => $validated['margin'] ?? null,
                        'margin_after_rebate' => $validated['margin_after_rebate'] ?? null,
                        'default_margin'      => $validated['default_margin'] ?? null,
                        'updated_at'          => now(),
                        'created_at'          => now(),
                    ]
                );
            }

            // Reset form & refresh
            $this->resetForm();
            $this->showForm = false;

            $this->dispatch('closeItemModal');
            $this->dispatch('refreshItemTable');

        } catch (\Exception $e) {
            session()->flash('error', 'Error saving item: ' . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }
    // public function save()
    // {
    //     try {
    //         $this->isLoading = true;
            
    //         // Dynamic validation rules
    //         $rules = $this->rules;
            
    //         // Code validation
    //         if ($this->itemId) {
    //             $rules['code'] = [
    //                 'required',
    //                 'string',
    //                 'max:255',
    //                 'unique:items,code,' . $this->itemId
    //             ];
    //         } else {
    //             $rules['code'] = 'required|string|max:255|unique:items,code';
    //         }
            
    //         $validated = $this->validate($rules);
            
    //         if ($this->itemId) {
    //             // Update existing item
    //             $item = Item::findOrFail($this->itemId);
    //             $item->update($validated);
    //             session()->flash('success', 'Item updated successfully!');
    //         } else {
    //             // Create new item
    //             $item = Item::create($validated);
    //             session()->flash('success', 'Item created successfully!');
    //         }

    //         // Save into pivot table
    //         if ($this->price_group_id) {
    //             $item->priceGroups()->syncWithoutDetaching([$this->price_group_id]);
    //         }

    //         $this->resetForm();
    //         $this->showForm = false;
            
    //         // Close modal after successful save
    //         $this->dispatch('closeItemModal');
            
    //         // Refresh the ItemTable
    //         $this->dispatch('refreshItemTable');
            
    //     } catch (\Exception $e) {
    //         session()->flash('error', 'Error saving item: ' . $e->getMessage());
    //     } finally {
    //         $this->isLoading = false;
    //     }
    // }
   

    public function updatedSearch()
    {
        $this->resetPage();
    }
    private function resetForm()
    {
        $this->reset([
            'itemId', 'code', 'item_description', 'department_id', 'product_category_id', 'price_group_id', 'payee_id', 'sale_type_id',
            'current_qty', 'tag_description', 'units_per_case', 'unit_retail', 'case_cost', 'case_discount', 'case_rebate',
            'online_retail', 'cost_after_discount', 'unit_of_measure_id', 'size_id', 'margin', 'margin_after_rebate', 'default_margin',
            'max_inv', 'min_inv', 'min_age', 'tax_rate', 'nacs_code', 'blue_law', 'nacs_category_id', 'nacs_sub_category_id',
            'kitchen_option', 'linked_item', 'allow_ebt', 'track_inventory', 'discounted_item_taxable', 'ingredient_for_label'
        ]);
    }
    public function delete($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        session()->flash('message', 'Item deleted successfully.');
    }

    public function openItemCodeModal($itemId, $itemCode)
    {
        $this->selectedItemForCodes = $itemId;
        $this->selectedItemCode = $itemCode;
        $this->showItemCodeModal = true;
    }

    public function closeItemCodeModal()
    {
        $this->showItemCodeModal = false;
        $this->selectedItemForCodes = null;
        $this->selectedItemCode = '';
    }

    public function render()
    {
        $items = Item::where('item_description', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.item-component', [
            'items' => $items,
            'departments' => Department::all(),
            'categories' => ProductCategory::all(),
            'measures' => UnitOfMeasure::all(),
            'sizes' => Size::all(),
            'priceGroups' => PriceGroup::all(),
            // 'saleTypes' => SaleType::all(),
        ]);
    }
}
