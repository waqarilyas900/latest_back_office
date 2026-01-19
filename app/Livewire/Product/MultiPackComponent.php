<?php

namespace App\Livewire\Product;

use App\Models\Item;
use App\Models\ItemPriceHistory;
use App\Models\MultiPack;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MultiPackComponent extends Component
{
    use WithPagination;

    // Selected item from the main ProductComponent
    public ?int $current_item_id = null;

    // Form fields
    public $modifier_qty = '';
    public $item_cost = '0.00';
    public $enter_retail = '';
    public $margin = '';

    // Table data
    public $multi_pack_items = [];

    protected $listeners = [
        'item-selected' => 'onItemSelected',
    ];

    // Test method to manually load item data
    public function testLoadItem($itemId = null)
    {
        $itemId = $itemId ?: $this->current_item_id;
        if ($itemId) {
            $item = Item::find($itemId);
            if ($item) {
                $this->dispatch('show-success', 'Item loaded: ' . $item->item_description . ' - Cost: ' . $item->case_cost . ' - Margin: ' . $item->margin . ' - Retail: ' . $item->unit_retail);
            } else {
                $this->dispatch('show-error', 'Item not found');
            }
        } else {
            $this->dispatch('show-error', 'No item ID provided');
        }
    }

    protected $rules = [
        'current_item_id' => 'required|integer|exists:items,id',
        'modifier_qty' => 'required|integer|min:1',
        'item_cost' => 'required|numeric|min:0',
        'enter_retail' => 'required|numeric|min:0',
        'margin' => 'required|numeric',
    ];

    public function mount(?int $selectedItemId = null): void
    {
        if ($selectedItemId) {
            $this->onItemSelected($selectedItemId);
        }
    }


    public function onItemSelected(int $itemId): void
    {
        $this->current_item_id = $itemId;
        $item = Item::find($itemId);
        
        if ($item) {
            // Use the same approach as ItemComponent - fill the form fields directly
            $this->item_cost = $item->case_cost ?? 0;
            $this->margin = $item->margin ?? 0;
            $this->enter_retail = $item->unit_retail ?? 0;
        } else {
        }
        
        $this->loadMultiPackItems();
    }

    public function save(): void
    {
        $this->validate();
    
        if (!$this->current_item_id) {
            $this->dispatch('show-error', 'Please select an item first.');
            return;
        }
    
        try {
            // get the item first
            $item = Item::findOrFail($this->current_item_id);
    
            $oldPrice = $item->unit_retail; // previous retail
            $newPrice = $this->enter_retail; // new price from form
    
            // if retail changed, log it before update
            if ($oldPrice != $newPrice) {
                ItemPriceHistory::create([
                    'user_id'     => Auth::id(),
                    'item_id'     => $item->id,
                    'old_price'   => $oldPrice,
                    'new_price'   => $newPrice,
                    'app_type'    => config('app.name'), // or any app type you want
                    'page_source' => url()->current(),  // current page URL
                ]);
            }
    
            // now update the item
            $item->update([
                'case_cost'   => $this->item_cost,
                'margin'      => $this->margin ?: 0,
                'unit_retail' => $newPrice,
            ]);
    
            // create multi pack
            MultiPack::create([
                'item_id'           => $this->current_item_id,
                'modifier_qty'      => $this->modifier_qty,
                'item_cost'         => $this->item_cost,
                'enter_retail'      => $newPrice,
                'margin'            => $this->margin ?: 0,
                'scan_code_modifier'=> $this->generateScanCodeModifier(),
            ]);
    
            $this->dispatch('show-success', 'Multi Pack saved successfully!');
            $this->clearForm(keepItem: true);
            $this->loadMultiPackItems();
        } catch (\Exception $e) {
            $this->dispatch('show-error', 'Error saving Multi Pack: ' . $e->getMessage());
        }
    }

    public function clearForm(bool $keepItem = false): void
    {
        $this->modifier_qty = '';
        if (!$keepItem) {
            $this->item_cost = 0;
            $this->enter_retail = 0;
            $this->margin = 0;
        }
    }

    public function loadMultiPackItems(): void
    {
        if (!$this->current_item_id) {
            $this->multi_pack_items = [];
            return;
        }

        $this->multi_pack_items = MultiPack::with('item')
            ->where('item_id', $this->current_item_id)
            ->orderByDesc('created_at')
            ->get()
            ->toArray();
    }

    private function generateScanCodeModifier(): string
    {
        return 'MP' . str_pad(MultiPack::withTrashed()->count() + 1, 4, '0', STR_PAD_LEFT);
    }

    public function render()
    {
        return view('livewire.product.multi-pack-component');
    }
}
