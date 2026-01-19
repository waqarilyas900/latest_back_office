<?php

namespace App\Livewire\Product\PriceGroup;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

class IndexComponent extends Component
{
    public $activeTab = 'price-book';
    
    // Modal properties
    public $showItemCodeModal = false;
    public $showItemModal = false;
    public $selectedItemId = null;
    public $selectedItemCode = '';
    

    #[Layout('layouts.main')]
    public function render()
    {
        return view('livewire.product.price-group.index-component');
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    #[\Livewire\Attributes\On('openItemCodeModal')]
    public function handleOpenItemCodeModal($itemId, $itemCode): void
    {
        $this->openItemCodeModal($itemId, $itemCode);
    }

    public function openItemCodeModal($itemId, $itemCode): void
    {
        $this->selectedItemId = $itemId;
        $this->selectedItemCode = $itemCode;
        $this->showItemCodeModal = true;
    }

    public function closeItemCodeModal(): void
    {
        $this->showItemCodeModal = false;
        $this->selectedItemId = null;
        $this->selectedItemCode = '';
    }

    #[\Livewire\Attributes\On('openItemModal')]
    public function handleOpenItemModal($itemId, $itemCode): void
    {
        $this->openItemModal($itemId, $itemCode);
    }

    public function openItemModal($itemId, $itemCode): void
    {
        $this->selectedItemId = $itemId;
        $this->selectedItemCode = $itemCode;
        $this->showItemModal = true;
    }

    public function closeItemModal(): void
    {
        $this->showItemModal = false;
        $this->selectedItemId = null;
        $this->selectedItemCode = '';
    }

    #[\Livewire\Attributes\On('closeItemModal')]
    public function handleCloseItemModal(): void
    {
        $this->closeItemModal();
    }

    #[\Livewire\Attributes\On('closeItemCodeModal')]
    public function handleCloseItemCodeModal(): void
    {
        $this->closeItemCodeModal();
    }


}
