<?php

namespace App\Livewire;

use App\Models\SaleType;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.main')]
class SaleTypeComponent extends Component
{
    use WithPagination;
    public $name;
    public $active = '1';
    public $saleId = null; 
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
        $sale = SaleType::findOrFail($id);
        $this->saleId = $sale->id;
        $this->name = $sale->name;
        $this->active = (string) $sale->active;
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

        if ($this->saleId) {
            SaleType::findOrFail($this->saleId)->update([
                'name' => $this->name,
                'active' => (int) $this->active,
            ]);
            session()->flash('messsale', 'Sale Type updated successfully.');
        } else {
            SaleType::create([
                'name' => $this->name,
                'active' => (int) $this->active,
            ]);
            session()->flash('messsale', 'Sale Type created successfully.');
        }

        $this->hideForm();
    }
    public function delete($id)
    {
        $type = SaleType::findOrFail($id);
        $type->delete();

        session()->flash('message', 'Sale type deleted successfully.');
    }
    public function render()
    {
        $sales = SaleType::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.sale-type-component', compact('sales'));
    }

}
