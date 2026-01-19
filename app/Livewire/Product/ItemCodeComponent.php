<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\ItemCode; // your model for codes
use App\Models\Payee;    // for dropdown if needed

class ItemCodeComponent extends Component
{
    public $itemCodes = [];
    public $newCode = '';
    public $newPayeeId = '';
    public $itemId = null;
    public $itemCode = '';
    public $allowAddNew = true; // Control whether to show "Add New" button

    public function mount($itemId = null, $itemCode = '', $allowAddNew = true)
    {
        $this->itemId = $itemId;
        $this->itemCode = $itemCode;
        $this->allowAddNew = $allowAddNew;
        $this->loadCodes();
    }

    public function loadCodes()
    {
        if ($this->itemId) {
            $this->itemCodes = ItemCode::with('payee')
                ->where('item_id', $this->itemId)
                ->get()
                ->toArray();
        } else {
            $this->itemCodes = ItemCode::with('payee')->get()->toArray();
        }
    }

    public function addNewRow()
    {
        // append empty row at end
        $this->itemCodes[] = [
            'id' => null,
            'item_code' => '',
            'payee_id' => '',
            'item_id' => $this->itemId,
        ];
    }

    public function saveRow($index)
    {
        $row = $this->itemCodes[$index];

        if ($row['id']) {
            // update existing
            $code = ItemCode::find($row['id']);
            $code->item_code = $row['item_code'];
            $code->payee_id = $row['payee_id'];
            $code->item_id = $this->itemId;
            $code->save();
        } else {
            // create new
            ItemCode::create([
                'item_code' => $row['item_code'],
                'payee_id' => $row['payee_id'],
                'item_id' => $this->itemId,
            ]);
        }

        $this->loadCodes();
        session()->flash('message', 'Saved successfully.');
        
        // Close modal after successful save
        $this->dispatch('closeItemCodeModal');
        
        // Refresh the ItemTable
        $this->dispatch('refreshItemTable');
    }

    public function deleteRow($id)
    {
        if ($id) {
            ItemCode::where('id', $id)->delete();
            $this->loadCodes();
        }
    }

    public function render()
    {
        $payees = Payee::all(); // populate dropdown
        return view('livewire.product.item-code-component', [
            'payees' => $payees,
        ]);
    }
}
