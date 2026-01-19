<?php

namespace App\Livewire\PriceGroup;

use App\Models\Item;
use App\Models\PriceGroup;
use Livewire\Component;

class AttachItemsComponent extends Component
{
    public $groupId;
    public $items = [];
    public $selectedItems = [];
    public $showForm = true;
    public $attachItemsMode = true;
    public $searchTerm = '';
    public $searchField = ''; // default filter field

    public function mount($groupId)
    {
        $this->groupId = $groupId;
        $this->loadData();
    }

   protected function loadData()
{
    $group = PriceGroup::with('items')->find($this->groupId);
    $attachedIds = $group ? $group->items->pluck('id')->toArray() : [];

    // Available items (exclude attached)
    $itemsQuery = Item::orderBy('item_description')
        ->whereNotIn('id', $attachedIds);

    if ($this->searchTerm && $this->searchField) {
        $itemsQuery->where($this->searchField, 'like', "%{$this->searchTerm}%");
    }

    $this->items = $itemsQuery->get(); // available items
    $this->selectedItems = $attachedIds; // attached items always selected
}


    public function updatedSearchTerm()
    {
        $this->loadData();
    }

    public function updatedSearchField()
    {
        $this->loadData();
    }

    public function toggleItem($id)
    {
        if (in_array($id, $this->selectedItems)) {
            $this->selectedItems = array_diff($this->selectedItems, [$id]);
        } else {
            $this->selectedItems[] = $id;
        }
    }

    public function removeItem($id)
    {
        $this->selectedItems = array_diff($this->selectedItems, [$id]);
    }

    public function attachItems()
    {
        $group = PriceGroup::findOrFail($this->groupId);
        $group->items()->sync($this->selectedItems);
        session()->flash('message', 'Items attached successfully!');
        $this->dispatch('showParentForm');
    }

    public function hideForm()
    {
        $this->showForm = false;
        $this->attachItemsMode = false;
        $this->dispatch('showParentForm');
    }

    public function render()
    {
        return view('livewire.price-group.attach-items-component');
    }
}
