<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Department;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.main')]
class DepartmentForm extends Component
{
    use WithPagination;

    public $name;
    public $active = '1';
    public $departmentId = null; 
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
        $department = Department::findOrFail($id);
        $this->departmentId = $department->id;
        $this->name = $department->name;
        $this->active = (string) $department->active;
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
        $this->validate([
            'name' => 'required|string|max:255',
            'active' => 'required|in:0,1',
        ]);

        if ($this->departmentId) {
            Department::findOrFail($this->departmentId)->update([
                'name' => $this->name,
                'active' => (int) $this->active,
            ]);
            session()->flash('message', 'Department updated successfully.');
        } else {
            Department::create([
                'name' => $this->name,
                'active' => (int) $this->active,
            ]);
            session()->flash('message', 'Department created successfully.');
        }

        $this->hideForm();
    }
    public function delete($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        session()->flash('message', 'Department deleted successfully.');
    }

    public function render()
    {
        $departments = Department::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.department-form', compact('departments'));
    }
}
