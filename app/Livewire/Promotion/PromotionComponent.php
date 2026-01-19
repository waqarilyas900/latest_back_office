<?php

namespace App\Livewire\Promotion;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Combo;
use App\Models\ComboGroup;
use App\Models\Promotion;

#[Layout('layouts.main')]
class PromotionComponent extends Component
{
    public $mainTab = 'promotion';
    public $promotionTab = 'setup';
    public $comboTab = 'setup';

    public function setMainTab($tab)
    {
        $this->mainTab = $tab;
    }

    public function setPromotionTab($tab)
    {
        $this->validatePromotionTabAccess($tab);
        $this->promotionTab = $tab;
    }

    protected function validatePromotionTabAccess($tab)
    {
        if ($tab === 'items') {
            $promotionId = session()->get('current_promotion_id');
            if (!$promotionId || !Promotion::find($promotionId)) {
                session()->flash('error', 'Please complete Step 1 - Promotion Setup first.');
                return false;
            }
        } elseif ($tab === 'location') {
            $promotionId = session()->get('current_promotion_id');
            if (!$promotionId || !Promotion::find($promotionId)) {
                session()->flash('error', 'Please complete Step 1 - Promotion Setup first.');
                return false;
            }
        }
        return true;
    }

    public function setComboTab($tab)
    {
        $this->validateTabAccess($tab);
        $this->comboTab = $tab;
    }

    protected function validateTabAccess($tab)
    {
        if ($tab === 'group') {
            $comboId = session()->get('current_combo_id');
            if (!$comboId || !Combo::find($comboId)) {
                session()->flash('error', 'Please complete Step 1 - Combo Setup first.');
                return false;
            }
        } elseif ($tab === 'location') {
            $comboId = session()->get('current_combo_id');
            if (!$comboId || !Combo::find($comboId)) {
                session()->flash('error', 'Please complete Step 1 - Combo Setup first.');
                return false;
            }
            if (!ComboGroup::where('combo_id', $comboId)->exists()) {
                session()->flash('error', 'Please complete Step 2 - Add Group first.');
                return false;
            }
        }
        return true;
    }

    protected $listeners = [
        'navigate-to-tab' => 'handleTabNavigation',
        'navigate-to-promotion-tab' => 'handlePromotionTabNavigation'
    ];

    public function handleTabNavigation($tab)
    {
        if ($this->validateTabAccess($tab)) {
            $this->comboTab = $tab;
        }
    }

    public function handlePromotionTabNavigation($tab)
    {
        if ($this->validatePromotionTabAccess($tab)) {
            $this->promotionTab = $tab;
        }
    }

    public function render()
    {
        return view('livewire.promotion.promotion-component');
    }
}
