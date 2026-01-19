<?php

namespace App\Livewire;

use App\Models\BankAccount;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.main')]
class BankAccountForm extends Component
{
    use WithPagination;
    public $account_name;
    public $active = '1';
    public $accountId = null; 
    public $showForm = false;
    public $search = '';
    public $perPage = 10; 

    public function displayForm()
    {
        $this->active = '1';
        $this->showForm = true;
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function hideForm()
    {
        $this->reset(['account_name', 'active']);
        $this->showForm = false;
    }
    public function edit($id)
    {
        $account = BankAccount::findOrFail($id);
        $this->accountId = $account->id;
        $this->account_name = $account->account_name;
        $this->active = (string) $account->active;
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate([
            'account_name' => 'required|string|max:255',
            'active' => 'required|in:0,1',
        ]);

        if ($this->accountId) {
            BankAccount::findOrFail($this->accountId)->update([
                'account_name' => $this->account_name,
                'active' => (int) $this->active,
            ]);
            session()->flash('message', 'Bank Account updated successfully.');
        } else {
            BankAccount::create([
                'account_name' => $this->account_name,
                'active' => (int) $this->active,
            ]);
            session()->flash('message', 'Bank Account created successfully.');
        }

        $this->hideForm();
    }
    public function delete($id)
    {
        $account = BankAccount::findOrFail($id);
        $account->delete();

        session()->flash('message', 'Account deleted successfully.');
    }

    public function render()
    {
        $accounts = BankAccount::where('account_name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.bank-account-form', compact('accounts'));
    }
}
