<?php

namespace App\Livewire\Promotion;

use Livewire\Component;
use App\Models\Location;
use App\Models\Combo;

class ComboSelectLocationComponent extends Component
{
    public $comboId = null;
    public $selectedLocations = [];
    public $selectAllLocations = false;

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

        if ($this->comboId) {
            $combo = Combo::with('locations')->find($this->comboId);
            if ($combo) {
                $this->selectedLocations = $combo->locations->pluck('id')->toArray();
                $this->updateSelectAllState();
            }
        }
    }

    public function toggleLocation($locationId)
    {
        if (in_array($locationId, $this->selectedLocations)) {
            $this->selectedLocations = array_values(array_diff($this->selectedLocations, [$locationId]));
        } else {
            $this->selectedLocations[] = $locationId;
        }
        $this->updateSelectAllState();
    }

    public function updatedSelectAllLocations()
    {
        if ($this->selectAllLocations) {
            // Select all locations
            $allLocations = Location::where('active', 1)->pluck('id')->toArray();
            $this->selectedLocations = $allLocations;
        } else {
            // Deselect all locations
            $this->selectedLocations = [];
        }
    }

    protected function updateSelectAllState()
    {
        $allActiveLocations = Location::where('active', 1)->pluck('id')->toArray();
        $this->selectAllLocations = count($allActiveLocations) > 0 && 
                                    count(array_intersect($allActiveLocations, $this->selectedLocations)) === count($allActiveLocations);
    }

    public function saveLocations()
    {
        if (!$this->comboId) {
            session()->flash('error', 'Please create a combo first.');
            return;
        }

        $combo = Combo::findOrFail($this->comboId);
        $combo->locations()->sync($this->selectedLocations);

        session()->flash('message', 'Locations saved successfully!');
    }

    public function backToGroups()
    {
        $this->dispatch('navigate-to-tab', tab: 'group');
    }

    public function render()
    {
        $locations = Location::where('active', 1)->orderBy('name')->get();
        $selectedLocationsData = Location::whereIn('id', $this->selectedLocations)->get();

        return view('livewire.promotion.combo-select-location-component', [
            'locations' => $locations,
            'selectedLocationsData' => $selectedLocationsData,
        ]);
    }
}
