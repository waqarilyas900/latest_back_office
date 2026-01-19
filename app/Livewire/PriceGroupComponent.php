<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\PriceGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
#[Layout('layouts.main')]
class PriceGroupComponent extends Component
{
    use WithPagination;
    public $group_name;
    public $price;
    public $active = '1';
    public $groupId = null; 
    public $showForm = false;
    public $attachItemsMode = false;
    public $search = '';
    public $perPage = 10;
    public $selectedGroupId = null;
    public $items = [];
    public $selectedItems = []; 
    protected $listeners = ['showParentForm' => 'showFormAgain'];

    public function showFormAgain()
    {
        $this->showForm = false;
        $this->attachItemsMode = false;
    }
    public function selectGroup($groupId)
    {
        $this->selectedGroupId = $groupId;
        $this->items = Item::all();
        $group = PriceGroup::find($groupId);
        if ($group) {
            $this->selectedItems = $group->items->pluck('id')->toArray();
        }
        $this->attachItemsMode = true;
        $this->showForm = false;
    }
    public function addItem($itemId)
    {
        if (!in_array($itemId, $this->selectedItems)) {
            $this->selectedItems[] = $itemId;
        }
    }

    public function removeItem($itemId)
    {
        $this->selectedItems = array_filter($this->selectedItems, fn($id) => $id != $itemId);
    }
     public function attachItems()
    {
        if ($this->selectedGroupId) {
            $group = PriceGroup::find($this->selectedGroupId);

            if ($group) {
                // Sync selected items to the pivot table
                $group->items()->sync($this->selectedItems);

                session()->flash('message', 'Items attached successfully!');
            }
        }
    }

    public function displayForm()
    {
        $this->active = '1';
        $this->showForm = true;
        $this->attachItemsMode = false;
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function hideForm()
    {
        $this->reset([
            'group_name','price','active','groupId',
            'selectedGroupId','items','selectedItems'
        ]);
        $this->showForm = false;
        $this->attachItemsMode = false;
    }
    // public function edit($id)
    // {
    //     $group = PriceGroup::findOrFail($id);
    //     $this->groupId = $group->id;
    //     $this->group_name = $group->group_name;
    //     $this->price = $group->price;
    //     $this->active = (string) $group->active;
    //     $this->showForm = true;
    //     $this->attachItemsMode = false;
    // }

    // public function save()
    // {
    //     $this->validate([
    //         'group_name' => 'required|string|max:255',
    //         'price' => 'required',
    //         'active' => 'required|in:0,1',
    //     ]);

    //     if ($this->groupId) {
    //         PriceGroup::findOrFail($this->groupId)->update([
    //             'group_name' => $this->group_name,
    //             'price' => $this->price,
    //             'active' => (int) $this->active,
    //         ]);
    //         session()->flash('message', 'Price Group updated successfully.');
    //     } else {
    //         PriceGroup::create([
    //             'group_name' => $this->group_name,
    //             'price' => $this->price,
    //             'active' => (int) $this->active,
    //         ]);
    //         session()->flash('message', 'Price Group created successfully.');
    //     }

    //     $this->hideForm();
    // }
   public function edit($id)
    {
        $user = Auth::user();
        $locationId = $user->locations()->first()?->id;

        $group = PriceGroup::with(['locationUpdates' => function ($q) use ($locationId) {
            if ($locationId) {
                $q->where('location_id', $locationId);
            }
        }])->findOrFail($id);

        $this->groupId    = $group->id;
        $this->group_name = $group->group_name;
        $this->active     = (string) $group->active;

        // ✅ Prefer location-specific price if exists
        if ($locationId && $group->locationUpdates->isNotEmpty()) {
            $this->price = $group->locationUpdates->first()->price;
        } else {
            $this->price = $group->price; // fallback to global price
        }

        $this->showForm        = true;
        $this->attachItemsMode = false;
    }
    public function save()
    {
        $this->validate([
            'group_name' => 'required|string|max:255',
            'price'      => 'required|numeric',
            'active'     => 'required|in:0,1',
        ]);

        $user       = Auth::user();
        $locationId = $user->locations()->first()?->id;

        if ($this->groupId) {
            $group = PriceGroup::findOrFail($this->groupId);

            // ✅ Always update base fields
            $group->update([
                'group_name' => $this->group_name,
                'active'     => (int) $this->active,
            ]);

            if (!$locationId) {
                // ✅ Non-location user updates global price
                $group->update(['price' => $this->price]);
            }

            session()->flash('message', 'Price Group updated successfully.');
        } else {
            // ✅ Create base group
            $group = PriceGroup::create([
                'group_name' => $this->group_name,
                'price'      => $locationId ? 0 : $this->price, // 👈 Force 0 for location users
                'active'     => (int) $this->active,
            ]);

            $this->groupId = $group->id;
            session()->flash('message', 'Price Group created successfully.');
        }

        // ✅ Location user → update/create location-specific price in pivot
        if ($locationId) {
            DB::table('location_price_group_updates')->updateOrInsert(
                [
                    'price_group_id' => $group->id,
                    'location_id'    => $locationId,
                ],
                [
                    'user_id'    => $user->id,
                    'price'      => $this->price,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $this->hideForm();
    }
    public function render()
    {
        $user       = Auth::user();
        $locationId = $user->locations()->first()?->id;

        $groups = PriceGroup::with(['locationUpdates' => function ($q) use ($locationId) {
                if ($locationId) {
                    $q->where('location_id', $locationId);
                }
            }])
            ->where('group_name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        // ✅ Override price with location-specific one if exists
        if ($locationId) {
            $groups->getCollection()->transform(function ($group) {
                if ($group->locationUpdates->isNotEmpty()) {
                    $group->price = $group->locationUpdates->first()->price;
                }
                return $group;
            });
        }

        return view('livewire.price-group-component', compact('groups'));
    }


}
