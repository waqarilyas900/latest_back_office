<?php

namespace App\Livewire;

use App\Models\NacsCategory;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.main')]
class NacsCategoryComponent extends Component
{
    use WithPagination;
    public $name;
    public $active = '1';
    public $categoryId = null; 
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
        $category = NacsCategory::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->active = (string) $category->active;
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

        if ($this->categoryId) {
            NacsCategory::findOrFail($this->categoryId)->update([
                'name' => $this->name,
                'active' => (int) $this->active,
            ]);
            session()->flash('messcategory', 'Nacs category updated successfully.');
        } else {
            NacsCategory::create([
                'name' => $this->name,
                'active' => (int) $this->active,
            ]);
            session()->flash('messcategory', 'Nacs category created successfully.');
        }

        $this->hideForm();
    }
    public function delete($id)
    {
        $category = NacsCategory::findOrFail($id);
        $category->delete();

        session()->flash('message', 'Nacs category deleted successfully.');
    }
    public function render()
    {
        $categories = NacsCategory::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.nacs-category-component', compact('categories'));
    }
}
