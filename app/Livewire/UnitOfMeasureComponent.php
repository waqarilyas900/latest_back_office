<?php

namespace App\Livewire;

use App\Models\UnitOfMeasure;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.main')]
class UnitOfMeasureComponent extends Component
{
    use WithPagination;
    public $name;
    public $active = '1';
    public $measureId = null; 
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
        $measure =UnitOfMeasure::findOrFail($id);
        $this->measureId = $measure->id;
        $this->name = $measure->name;
        $this->active = (string) $measure->active;
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

        if ($this->measureId) {
           UnitOfMeasure::findOrFail($this->measureId)->update([
                'name' => $this->name,
                'active' => (int) $this->active,
            ]);
            session()->flash('message', 'Unit of measure updated successfully.');
        } else {
           UnitOfMeasure::create([
                'name' => $this->name,
                'active' => (int) $this->active,
            ]);
            session()->flash('message', 'Unit of measure created successfully.');
        }

        $this->hideForm();
    }
    public function delete($id)
    {
        $unit = UnitOfMeasure::findOrFail($id);
        $unit->delete();

        session()->flash('message', 'Unit of Measure deleted successfully.');
    }
    public function render()
    {
        $measures =UnitOfMeasure::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.unit-of-measure-component', compact('measures'));
    }
}
