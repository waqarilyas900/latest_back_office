<?php

namespace App\Livewire\Promotion;

use Livewire\Component;
use App\Models\Location;
use App\Models\Promotion;

class SelectLocationComponent extends Component
{
    public $promotionId = null;
    public $selectedLocations = [];
    public $selectAllLocations = false;

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
            $promotion = Promotion::with('locations')->find($this->promotionId);
            if ($promotion) {
                $this->selectedLocations = $promotion->locations->pluck('id')->toArray();
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
        if (!$this->promotionId) {
            session()->flash('error', 'Please create a promotion first.');
            return;
        }

        $promotion = Promotion::findOrFail($this->promotionId);
        $promotion->locations()->sync($this->selectedLocations);

        session()->flash('message', 'Locations saved successfully!');
    }

    public function backToItems()
    {
        $this->dispatch('navigate-to-promotion-tab', tab: 'items');
    }

    public function render()
    {
        $locations = Location::where('active', 1)->orderBy('name')->get();
        $selectedLocationsData = Location::whereIn('id', $this->selectedLocations)->get();

        return view('livewire.promotion.select-location-component', [
            'locations' => $locations,
            'selectedLocationsData' => $selectedLocationsData,
        ]);
    }
}
