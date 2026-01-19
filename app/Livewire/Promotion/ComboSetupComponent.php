<?php

namespace App\Livewire\Promotion;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Combo;
use Illuminate\Support\Facades\Storage;

class ComboSetupComponent extends Component
{
    use WithFileUploads;

    public $comboId = null;
    public $description = '';
    public $start_date = '';
    public $end_date = '';
    public $image = null;
    public $image_path = null;
    public $deal_description = '';
    public $add_to_deal = false;

    protected $rules = [
        'description' => 'nullable|string|max:255',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'image' => 'nullable|image|max:2048',
        'deal_description' => 'nullable|string',
        'add_to_deal' => 'boolean',
    ];

    public function mount($comboId = null)
    {
        if ($comboId) {
            $combo = Combo::find($comboId);
            if ($combo) {
                $this->comboId = $combo->id;
                $this->description = $combo->description ?? '';
                $this->start_date = $combo->start_date ? $combo->start_date->format('Y-m-d\TH:i') : '';
                $this->end_date = $combo->end_date ? $combo->end_date->format('Y-m-d\TH:i') : '';
                $this->image_path = $combo->image;
                $this->deal_description = $combo->deal_description ?? '';
                $this->add_to_deal = $combo->add_to_deal ?? false;
            }
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'description' => $this->description,
            'start_date' => $this->start_date ?: null,
            'end_date' => $this->end_date ?: null,
            'deal_description' => $this->deal_description,
            'add_to_deal' => $this->add_to_deal,
        ];

        // Handle image upload
        if ($this->image) {
            $imagePath = $this->image->store('combos', 'public');
            $data['image'] = $imagePath;
        } elseif ($this->image_path) {
            $data['image'] = $this->image_path;
        }

        if ($this->comboId) {
            $combo = Combo::find($this->comboId);
            $combo->update($data);
            session()->put('current_combo_id', $combo->id);
            session()->flash('message', 'Combo updated successfully!');
        } else {
            $combo = Combo::create($data);
            $this->comboId = $combo->id;
            session()->put('current_combo_id', $combo->id);
            session()->flash('message', 'Combo created successfully!');
        }

        $this->dispatch('combo-saved');
    }

    public function saveAndNext()
    {
        $this->save();
        // Navigate to next step
        $this->dispatch('navigate-to-tab', tab: 'group');
    }

    public function close()
    {
        return redirect()->route('promotion.index');
    }

    public function delete()
    {
        if ($this->comboId) {
            $combo = Combo::find($this->comboId);
            if ($combo) {
                $combo->delete();
                session()->flash('message', 'Combo deleted successfully!');
                return redirect()->route('promotion.index');
            }
        }
    }

    public function render()
    {
        return view('livewire.promotion.combo-setup-component');
    }
}
