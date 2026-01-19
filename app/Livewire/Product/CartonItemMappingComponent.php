<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Item;
use App\Models\CartonItemMapping;

class CartonItemMappingComponent extends Component
{
    public $selectedItemId; // main item id (carton)
    public $scanCode;       // the code scanned for pack/single unit
    public $mappedItemId;   // id if found
    public $packQty;

    public $description;
    public $cost;
    public $retail;
    public $department_id;

    public $existingMappings = [];

    public function mount($selectedItemId)
    {
        $this->selectedItemId = $selectedItemId;
        $this->loadMappings();
    }

    public function updatedScanCode()
    {
        // whenever scan code changes, check if item exists
        $item = Item::where('code', $this->scanCode)->first();

        if ($item) {
            $this->mappedItemId = $item->id;
            $this->description = $item->description;
            $this->cost = $item->cost;
            $this->retail = $item->retail;
            $this->department_id = $item->department_id;
        } else {
            // new item, reset fields so user can fill
            $this->mappedItemId = null;
            $this->description = '';
            $this->cost = '';
            $this->retail = '';
            $this->department_id = '';
        }
    }

    public function saveMapping()
    {
        $this->validate([
            'scanCode' => 'required',
            'packQty'  => 'required|numeric|min:1',
        ]);

        if (!$this->mappedItemId) {
            // create a new item first
            $item = Item::create([
                'code' => $this->scanCode,
                'item_description' => $this->description,
                'case_cost' => $this->cost,
                'retail' => $this->retail,
                'department_id' => $this->department_id,
            ]);
            $this->mappedItemId = $item->id;
        }

        // create mapping
        CartonItemMapping::create([
            'main_item_id'   => $this->selectedItemId,
            'mapped_item_id' => $this->mappedItemId,
            'pack_qty'       => $this->packQty,
        ]);

        $this->reset(['scanCode','mappedItemId','packQty','description','cost','retail','department_id']);
        $this->loadMappings();
    }

    public function loadMappings()
    {
        $this->existingMappings = CartonItemMapping::with('mappedItem')
            ->where('main_item_id', $this->selectedItemId)
            ->get();
    }

    public function render()
    {
        return view('livewire.product.carton-item-mapping-component');
    }
}
