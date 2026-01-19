<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Payee;
use App\Models\Term;
use App\Models\Department;
use App\Models\BankAccount;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.main')]
class PayeeForm extends Component
{
    use WithPagination;
    public $vendor_name, $contact_name, $phone, $email, $fax;
    public $state, $city, $zip_code, $account_number, $payment_method;
    public $address_1, $address_2, $term_id, $pos_id, $department_id;
    public $default_margin, $default_bank_account_id, $fintech_vendor_code;
    public $types = [];

    public $termOptions = [], $departmentOptions = [], $bankOptions = [];
    public $showForm = false;
    public $search = '';
    public $active = '1';
    public $payeeId = null;
    public $perPage = 10; 
    

    public function mount()
    {
        $this->termOptions = Term::all();
        $this->departmentOptions = Department::all();
        $this->bankOptions = BankAccount::all();
        
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function edit($id)
    {
        $payee = Payee::findOrFail($id);

        $this->payeeId = $payee->id;
        $this->vendor_name = $payee->vendor_name;
        $this->contact_name = $payee->contact_name;
        $this->phone = $payee->phone;
        $this->email = $payee->email;
        $this->fax = $payee->fax;
        $this->state = $payee->state;
        $this->city = $payee->city;
        $this->zip_code = $payee->zip_code;
        $this->account_number = $payee->account_number;
        $this->payment_method = $payee->payment_method;
        $this->address_1 = $payee->address_1;
        $this->address_2 = $payee->address_2;
        $this->term_id = $payee->term_id;
        $this->pos_id = $payee->pos_id;
        $this->department_id = $payee->department_id;
        $this->default_margin = $payee->default_margin;
        $this->default_bank_account_id = $payee->default_bank_account_id;
        $this->fintech_vendor_code = $payee->fintech_vendor_code;
        $this->types = is_array($payee->types) ? $payee->types : json_decode($payee->types ?? '[]', true);
        $this->active = (string) $payee->active;
        $this->showForm = true;
    }


    public function save()
    {
        $this->validate([
            'vendor_name' => 'required|string',
            'types' => 'array|nullable'
        ]);

        $data = [
            'vendor_name' => $this->vendor_name,
            'contact_name' => $this->contact_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'fax' => $this->fax,
            'state' => $this->state,
            'city' => $this->city,
            'zip_code' => $this->zip_code,
            'account_number' => $this->account_number,
            'payment_method' => $this->payment_method,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'term_id' => $this->term_id,
            'pos_id' => $this->pos_id,
            'department_id' => $this->department_id,
            'default_margin' => $this->default_margin,
            'default_bank_account_id' => $this->default_bank_account_id,
            'fintech_vendor_code' => $this->fintech_vendor_code,
            'types' => $this->types,
            'active' => (int) $this->active,
            
        ];

        if ($this->payeeId) {
            Payee::findOrFail($this->payeeId)->update($data);
            session()->flash('message', 'Payee updated successfully.');
            $this->showForm = false;
        } else {
            Payee::create($data);
            session()->flash('message', 'Payee created successfully.');
            $this->resetForm();
            $this->showForm = false;
        }
    }


    public function displayForm()
    {
        $this->showForm = true;
    }

    public function hideForm()
    {
        $this->resetForm();
        $this->showForm = false;
    }
    public function delete($id)
    {
        $payee = Payee::findOrFail($id);
        $payee->delete();

        session()->flash('message', 'Payee deleted successfully.');
    }

    public function render()
    {
        $payees = Payee::where('vendor_name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.payee-form', [
        'payees' => $payees,
        'termOptions' => Term::all(),
        'departmentOptions' => Department::all(),
        'bankOptions' => BankAccount::all(),
    ]);
    }
    protected function resetForm()
    {
        $this->vendor_name = null;
        $this->contact_name = null;
        $this->phone = null;
        $this->email = null;
        $this->fax = null;
        $this->state = null;
        $this->city = null;
        $this->zip_code = null;
        $this->account_number = null;
        $this->payment_method = null;
        $this->address_1 = null;
        $this->address_2 = null;
        $this->term_id = null;
        $this->pos_id = null;
        $this->department_id = null;
        $this->default_margin = null;
        $this->default_bank_account_id = null;
        $this->fintech_vendor_code = null;
        $this->types = [];
        $this->payeeId = null;
        $this->active = null;
    }
}
