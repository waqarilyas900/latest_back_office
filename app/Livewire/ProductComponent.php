<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Item;

#[Layout('layouts.main')]
class ProductComponent extends Component
{
    public $tab = 'items';
    public $search = '';
    public $searchResults = [];
    public $selectedItemId = null;
    public $errorMessage = null;

    public function updatedSearch()
    {
        if (empty($this->search)) {
            $this->searchResults = [];
            $this->selectedItemId = null;
            return;
        }

        // Check if exact code exists
        $exactMatch = Item::where('code', $this->search)->first();
        
        if ($exactMatch) {
            // Load existing product
            $this->selectedItemId = $exactMatch->id;
            $this->searchResults = [];
            $this->dispatch('item-selected', $exactMatch->id);
        } else {
            // Show suggestions for similar codes
            $this->searchResults = Item::query()
                ->where('code', 'like', '%'.$this->search.'%')
                ->limit(10)
                ->get()
                ->toArray();
            
            // If no suggestions found, prepare for new item creation
            if (empty($this->searchResults)) {
                $this->selectedItemId = null;
                $this->dispatch('prepare-new-item', $this->search);
            } else {
                $this->selectedItemId = null;
            }
        }
    }


    public function selectItem($itemId)
    {
        $this->selectedItemId = $itemId;
        $item = Item::find($itemId);
        $this->search = $item?->code;
        $this->searchResults = [];
        $this->dispatch('item-selected', $itemId);
    }

    public function prepareNewProduct()
    {
        if (empty($this->search)) {
            $this->errorMessage = 'Please enter a product code first.';
            return;
        }

        // Check if code already exists
        $existingItem = Item::where('code', $this->search)->first();
        if ($existingItem) {
            $this->selectedItemId = $existingItem->id;
            $this->dispatch('item-selected', $existingItem->id);
            return;
        }

        // Prepare for new item creation - don't create yet
        $this->selectedItemId = null;
        $this->dispatch('prepare-new-item', $this->search);
    }

    public function setTab($tab)
    {
        if ($tab !== 'items' && empty($this->selectedItemId)) {
            $this->dispatch('tab-error', message: 'Please first scan or select an item.');
            return;
        }

        $this->tab = $tab;
    }

    public function render()
    {
        return view('livewire.product-component');
    }
}
