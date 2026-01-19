<?php

namespace App\Livewire\Promotion;

use Livewire\Component;

class ComboComponent extends Component
{
    public $comboTab = 'setup';

    public function setComboTab($tab)
    {
        $this->comboTab = $tab;
    }

    public function render()
    {
        return view('livewire.promotion.combo-component');
    }
}
