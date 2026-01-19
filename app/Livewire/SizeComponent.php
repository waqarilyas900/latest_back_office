<?php

namespace App\Livewire;

use App\Models\Size;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.main')]
class SizeComponent extends Component
{
    use WithPagination;
    public $name;
    public $active = '1';
    public $sizeId = null; 
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
        $size = Size::findOrFail($id);
        $this->sizeId = $size->id;
        $this->name = $size->name;
        $this->active = (string) $size->active;
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

        if ($this->sizeId) {
            Size::findOrFail($this->sizeId)->update([
                'name' => $this->name,
                'active' => (int) $this->active,
            ]);
            session()->flash('messsize', 'Size updated successfully.');
        } else {
            Size::create([
                'name' => $this->name,
                'active' => (int) $this->active,
            ]);
            session()->flash('messsize', 'Size created successfully.');
        }

        $this->hideForm();
    }
    public function delete($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        session()->flash('message', 'Size deleted successfully.');
    }
    public function render()
    {
        $sizes = Size::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.size-component', compact('sizes'));
    }
}
