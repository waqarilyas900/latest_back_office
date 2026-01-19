<?php

namespace App\Livewire\Promotion;

use Livewire\Component;
use App\Models\Combo;
use App\Models\ComboGroup;
use App\Models\Item;
use App\Models\Department;
use App\Models\ProductCategory;
use App\Models\Payee;
use App\Models\PriceGroup;
use Livewire\WithPagination;

class AddGroupComponent extends Component
{
    use WithPagination;

    public $comboId = null;
    public $groups = [];
    public $editingGroupId = null;
    public $showItemModal = false;
    public $selectedGroupId = null;
    
    // Item search and selection
    public $searchBy = 'code';
    public $searchValue = '';
    public $searchResults = [];
    public $selectedItems = [];
    public $selectAllSearchResults = false;

    public function mount($comboId = null)
    {
        // Get combo ID from parameter, session, or latest combo
        $this->comboId = $comboId ?? session()->get('current_combo_id');
        
        if (!$this->comboId) {
            // Get the latest combo if no ID is provided
            $latestCombo = Combo::latest()->first();
            if ($latestCombo) {
                $this->comboId = $latestCombo->id;
                session()->put('current_combo_id', $this->comboId);
            }
        }

        $this->loadGroups();
    }

    public function loadGroups()
    {
        if ($this->comboId) {
            $this->groups = ComboGroup::where('combo_id', $this->comboId)
                ->orderBy('id')
                ->get()
                ->map(function ($group) {
                    return [
                        'id' => $group->id,
                        'description' => $group->description,
                        'quantity' => $group->quantity,
                        'combo_price' => $group->combo_price,
                        'items_count' => $group->items()->count(),
                    ];
                })
                ->toArray();
        }
    }

    public function addNewGroup()
    {
        if (!$this->comboId) {
            session()->flash('error', 'Please create a combo first.');
            return;
        }

        $group = ComboGroup::create([
            'combo_id' => $this->comboId,
            'description' => '',
            'quantity' => 0,
            'combo_price' => 0,
            'items_count' => 0,
        ]);

        $this->loadGroups();
    }

    public function updatedGroups($value, $key)
    {
        // Parse the key to get group index and field name
        $parts = explode('.', $key);
        if (count($parts) === 2) {
            $index = $parts[0];
            $field = $parts[1];
            
            if (isset($this->groups[$index]['id'])) {
                $groupId = $this->groups[$index]['id'];
                $this->updateGroup($groupId, $field, $value);
            }
        }
    }

    public function updateGroup($groupId, $field, $value)
    {
        $group = ComboGroup::find($groupId);
        if ($group) {
            if ($field === 'combo_price' || $field === 'quantity') {
                $value = is_numeric($value) ? $value : 0;
            }
            $group->update([$field => $value]);
            $this->loadGroups();
        }
    }

    public function deleteGroup($groupId)
    {
        $group = ComboGroup::find($groupId);
        if ($group) {
            $group->delete();
            $this->loadGroups();
        }
    }

    public function openItemModal($groupId)
    {
        $this->selectedGroupId = $groupId;
        $this->showItemModal = true;
        
        // Load selected items for this group
        $group = ComboGroup::with('items')->find($groupId);
        if ($group) {
            $this->selectedItems = $group->items->pluck('id')->toArray();
        }
        
        // Reset search
        $this->searchValue = '';
        $this->searchResults = [];
        $this->searchBy = 'code';
    }

    public function closeItemModal()
    {
        $this->showItemModal = false;
        $this->selectedGroupId = null;
        $this->selectedItems = [];
        $this->searchResults = [];
        $this->searchValue = '';
        $this->loadGroups(); // Reload to update items_count
    }

    public function searchItems()
    {
        // For dropdown searches, require a value to be selected
        if (in_array($this->searchBy, ['product_category_id', 'department_id', 'payee_id', 'price_group_id'])) {
            if (empty($this->searchValue)) {
                $this->searchResults = [];
                return;
            }
        } else {
            // For text searches, require non-empty value
            if (empty($this->searchValue)) {
                $this->searchResults = [];
                return;
            }
        }

        $this->searchResults = $this->getItemsQuery()->get()->toArray();
        $this->updateSelectAllStates();
    }

    public function updatedSearchValue()
    {
        $this->searchItems();
    }

    public function updatedSearchBy()
    {
        $this->searchValue = '';
        $this->searchResults = [];
    }

    public function addItem($itemId)
    {
        if (!in_array($itemId, $this->selectedItems)) {
            $this->selectedItems[] = $itemId;
        }
        $this->updateSelectAllStates();
    }

    public function addAllItems()
    {
        foreach ($this->searchResults as $item) {
            if (!in_array($item['id'], $this->selectedItems)) {
                $this->selectedItems[] = $item['id'];
            }
        }
        $this->selectAllSearchResults = false;
        $this->updateSelectAllStates();
    }

    public function removeItem($itemId)
    {
        $this->selectedItems = array_values(array_diff($this->selectedItems, [$itemId]));
        $this->updateSelectAllStates();
    }

    public function removeAllItems()
    {
        $this->selectedItems = [];
        $this->updateSelectAllStates();
    }

    public function updatedSelectAllSearchResults()
    {
        if ($this->selectAllSearchResults) {
            $this->addAllItems();
        } else {
            // Remove all search results from selected items
            $searchResultIds = array_column($this->searchResults, 'id');
            $this->selectedItems = array_values(array_diff($this->selectedItems, $searchResultIds));
        }
        $this->updateSelectAllStates();
    }

    protected function updateSelectAllStates()
    {
        // Update select all for search results
        if (count($this->searchResults) > 0) {
            $searchResultIds = array_column($this->searchResults, 'id');
            $this->selectAllSearchResults = count(array_intersect($searchResultIds, $this->selectedItems)) === count($searchResultIds);
        } else {
            $this->selectAllSearchResults = false;
        }
    }

    protected function getItemsQuery()
    {
        $query = Item::query();

        if ($this->searchValue && $this->searchBy) {
            if ($this->searchBy === 'product_category_id') {
                $query->where('product_category_id', $this->searchValue);
            } elseif ($this->searchBy === 'department_id') {
                $query->where('department_id', $this->searchValue);
            } elseif ($this->searchBy === 'payee_id') {
                $query->where('payee_id', $this->searchValue);
            } elseif ($this->searchBy === 'price_group_id') {
                $query->where('price_group_id', $this->searchValue);
            } else {
                $query->where($this->searchBy, 'like', '%' . $this->searchValue . '%');
            }
        }

        return $query->orderBy('item_description');
    }

    public function saveGroupItems()
    {
        if (!$this->selectedGroupId) {
            return;
        }

        $group = ComboGroup::find($this->selectedGroupId);
        if ($group) {
            $group->items()->sync($this->selectedItems);
            
            // Update items_count
            $group->update(['items_count' => count($this->selectedItems)]);
            
            $this->loadGroups();
            session()->flash('message', 'Items saved successfully!');
        }
    }

    public function resetSearch()
    {
        $this->searchValue = '';
        $this->searchBy = 'code';
        $this->searchResults = [];
    }

    public function saveGroups()
    {
        if (!$this->comboId) {
            session()->flash('error', 'Please create a combo first.');
            return;
        }

        session()->flash('message', 'Groups saved successfully!');
    }

    public function backToSetup()
    {
        $this->dispatch('navigate-to-tab', tab: 'setup');
    }

    public function nextToLocation()
    {
        // Validate that at least one group exists
        if (count($this->groups) === 0) {
            session()->flash('error', 'Please add at least one group before proceeding.');
            return;
        }

        // Navigate to next step
        $this->dispatch('navigate-to-tab', tab: 'location');
    }

    public function getTotalComboPrice()
    {
        return array_sum(array_column($this->groups, 'combo_price'));
    }

    public function getTotalItemsCount()
    {
        return array_sum(array_column($this->groups, 'items_count'));
    }

    public function render()
    {
        $selectedItemsData = Item::whereIn('id', $this->selectedItems)->get();

        return view('livewire.promotion.add-group-component', [
            'totalComboPrice' => $this->getTotalComboPrice(),
            'totalItemsCount' => $this->getTotalItemsCount(),
            'selectedItemsData' => $selectedItemsData,
            'departments' => Department::all(),
            'categories' => ProductCategory::all(),
            'payees' => Payee::where('active', 1)->get(),
            'priceGroups' => PriceGroup::all(),
        ]);
    }
}
