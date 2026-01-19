<?php

namespace App\Livewire;

use App\Models\Term;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.main')]
class TermForm extends Component
{
    use WithPagination;
    public $name;
    public $active = '1';
    public $termId = null; 
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
        $term = Term::findOrFail($id);
        $this->termId = $term->id;
        $this->name = $term->name;
        $this->active = (string) $term->active;
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

        if ($this->termId) {
            Term::findOrFail($this->termId)->update([
                'name' => $this->name,
                'active' => (int) $this->active,
            ]);
            session()->flash('message', 'Term updated successfully.');
        } else {
            Term::create([
                'name' => $this->name,
                'active' => (int) $this->active,
            ]);
            session()->flash('message', 'Term created successfully.');
        }

        $this->hideForm();
    }
    public function delete($id)
    {
        $term = Term::findOrFail($id);
        $term->delete();

        session()->flash('message', 'Term deleted successfully.');
    }
    public function render()
    {
        $terms = Term::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.term-form', compact('terms'));
    }
}
