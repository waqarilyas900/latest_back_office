<?php

namespace App\Livewire;

use App\Models\Location;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.main')]
class LocationComponent extends Component
{
    use WithPagination;
    public $name;
    public $address;
    public $active = '1';
    public $locationId = null; 
    public $showForm = false;
    public $search = '';
    public $perPage = 10; 


    public function displayForm()
    {
        if (!auth()->user()->can('add location')) {
            session()->flash('error', 'You do not have permission to add locations.');
            return;
        }
        $this->active = '1';
        $this->showForm = true;
    }

    public function hideForm()
    {
        $this->reset(['name','address', 'active']);
        $this->showForm = false;
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);
        $this->locationId = $location->id;
        $this->name = $location->name;
        $this->name = $location->address;
        $this->active = (string) $location->active;
        $this->showForm = true;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    // ✅ Reset page when perPage changes
    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function save()
    {
        if (!$this->locationId && !auth()->user()->can('add location')) {
            session()->flash('error', 'You do not have permission to add locations.');
            return;
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'active' => 'required|in:0,1',
        ]);

        if ($this->locationId) {
            Location::findOrFail($this->locationId)->update([
                'name' => $this->name,
                'address' => $this->address,
                'active' => (int) $this->active,
            ]);
            session()->flash('message', 'Location updated successfully.');
        } else {
            Location::create([
                'name' => $this->name,
                'address' => $this->address,
                'active' => (int) $this->active,
            ]);
            session()->flash('message', 'Location created successfully.');
        }

        $this->hideForm();
    }
    public function delete($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        session()->flash('message', 'Location deleted successfully.');
    }

    public function render()
    {
        $locations = Location::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);
        return view('livewire.location-component', compact('locations'));
    }
}
