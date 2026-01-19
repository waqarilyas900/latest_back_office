<?php

namespace App\Livewire\Promotion;

use Livewire\Component;
use App\Models\Item;
use App\Models\Promotion;
use App\Models\Department;
use App\Models\ProductCategory;
use App\Models\Payee;
use App\Models\PriceGroup;
use Livewire\WithPagination;

class AddItemsComponent extends Component
{
    public $promotionId = null;
    public $searchBy = 'item_description'; // Default search field
    public $searchValue = '';
    public $selectedItems = [];
    public $searchResults = [];
    public $selectAllSearchResults = false;
    public $selectAllSelectedItems = false;

    // Search options
    public $searchOptions = [
        'code' => 'Scan Code',
        'item_description' => 'Description',
        'product_category_id' => 'Category',
        'payee_id' => 'Manufacturer',
        'department_id' => 'Department',
        'payee_id' => 'Payee',
        'price_group_id' => 'Price Group',
    ];

    public function mount($promotionId = null)
    {
        // Get promotion ID from parameter, session, or latest promotion
        $this->promotionId = $promotionId ?? session()->get('current_promotion_id');
        
        if (!$this->promotionId) {
            // Get the latest promotion if no ID is provided
            $latestPromotion = Promotion::latest()->first();
            if ($latestPromotion) {
                $this->promotionId = $latestPromotion->id;
                session()->put('current_promotion_id', $this->promotionId);
            }
        }

        if ($this->promotionId) {
            $promotion = Promotion::with('items')->find($this->promotionId);
            if ($promotion) {
                $this->selectedItems = $promotion->items->pluck('id')->toArray();
            }
        }
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
    }

    public function removeItem($itemId)
    {
        $this->selectedItems = array_values(array_diff($this->selectedItems, [$itemId]));
        $this->updateSelectAllStates();
    }

    public function removeAllItems()
    {
        $this->selectedItems = [];
        $this->selectAllSelectedItems = false;
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

    public function updatedSelectAllSelectedItems()
    {
        if (!$this->selectAllSelectedItems && count($this->selectedItems) > 0) {
            $this->removeAllItems();
        }
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

        // Update select all for selected items (checked when items exist)
        $this->selectAllSelectedItems = count($this->selectedItems) > 0;
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

    public function saveItems()
    {
        if (!$this->promotionId) {
            session()->flash('error', 'Please create a promotion first.');
            return;
        }

        $promotion = Promotion::findOrFail($this->promotionId);
        $promotion->items()->sync($this->selectedItems);

        session()->flash('message', 'Items saved successfully!');
    }

    public function backToSetup()
    {
        $this->dispatch('navigate-to-promotion-tab', tab: 'setup');
    }

    public function nextToLocation()
    {
        // Navigate to next step
        $this->dispatch('navigate-to-promotion-tab', tab: 'location');
    }

    public function resetSearch()
    {
        $this->searchValue = '';
        $this->searchBy = 'item_description';
        $this->searchResults = [];
    }

    public function render()
    {
        $selectedItemsData = Item::whereIn('id', $this->selectedItems)->get();

        return view('livewire.promotion.add-items-component', [
            'selectedItemsData' => $selectedItemsData,
            'departments' => Department::all(),
            'categories' => ProductCategory::all(),
            'payees' => Payee::where('active', 1)->get(),
            'priceGroups' => PriceGroup::all(),
        ]);
    }
}
