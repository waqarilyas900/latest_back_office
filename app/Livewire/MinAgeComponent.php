<?php

namespace App\Livewire;

use App\Models\MinAge;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.main')]
class MinAgeComponent extends Component
{
    use WithPagination;
    public $name;
    public $active = '1';
    public $ageId = null; 
    public $showForm = false;
    public $search = '';
   public $perPage = 10; 

    public function displayForm()
    {
        $this->active = '1';
        $this->showForm = true;
    }

    public function hideForm()
    {
        $this->reset(['name', 'active']);
        $this->showForm = false;
    }
    public function edit($id)
    {
        $age = MinAge::findOrFail($id);
        $this->ageId = $age->id;
        $this->name = $age->name;
        $this->active = (string) $age->active;
        $this->showForm = true;
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'active' => 'required|in:0,1',
        ]);

        if ($this->ageId) {
            MinAge::findOrFail($this->ageId)->update([
                'name' => $this->name,
                'active' => (int) $this->active,
            ]);
            session()->flash('message', 'Min Age updated successfully.');
        } else {
            MinAge::create([
                'name' => $this->name,
                'active' => (int) $this->active,
            ]);
            session()->flash('message', 'Min Age created successfully.');
        }

        $this->hideForm();
    }
    public function delete($id)
    {
        $age = MinAge::findOrFail($id);
        $age->delete();

        session()->flash('message', 'Min Age deleted successfully.');
    }
    public function render()
    {
        $ages = MinAge::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);;

        return view('livewire.min-age-component', compact('ages'));
    }
   
}
