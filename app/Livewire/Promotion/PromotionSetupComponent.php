<?php

namespace App\Livewire\Promotion;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Promotion;
use App\Models\Payee;
use Illuminate\Support\Facades\Storage;

class PromotionSetupComponent extends Component
{
    use WithFileUploads;

    public $promotionId = null;
    public $promotion_name = '';
    public $pos_description = '';
    public $funded_by = '';
    public $mix_n_match = 'new_price';
    public $new_price = '';
    public $price_reduction = '';
    public $quantity = '';
    public $start_date = '';
    public $end_date = '';
    public $start_time = '';
    public $end_time = '';
    public $offer_image = null;
    public $offer_image_path = null;
    public $add_to_deal = false;
    public $offer_description = '';

    protected $rules = [
        'promotion_name' => 'nullable|string|max:255',
        'pos_description' => 'nullable|string',
        'funded_by' => 'nullable|string|max:255',
        'mix_n_match' => 'nullable|in:new_price,price_reduction,quantity',
        'new_price' => 'nullable|numeric|min:0',
        'price_reduction' => 'nullable|numeric|min:0',
        'quantity' => 'nullable|integer|min:0',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'start_time' => 'nullable',
        'end_time' => 'nullable',
        'offer_image' => 'nullable|image|max:2048',
        'add_to_deal' => 'boolean',
        'offer_description' => 'nullable|string|max:60',
    ];

    public function mount($promotionId = null)
    {
        if ($promotionId) {
            $promotion = Promotion::find($promotionId);
            if ($promotion) {
                $this->promotionId = $promotion->id;
                $this->promotion_name = $promotion->promotion_name ?? '';
                $this->pos_description = $promotion->pos_description ?? '';
                $this->funded_by = $promotion->funded_by ?? '';
                $this->mix_n_match = $promotion->mix_n_match ?? 'new_price';
                $this->new_price = $promotion->new_price ?? '';
                $this->price_reduction = $promotion->price_reduction ?? '';
                $this->quantity = $promotion->quantity ?? '';
                $this->start_date = $promotion->start_date ? $promotion->start_date->format('Y-m-d') : '';
                $this->end_date = $promotion->end_date ? $promotion->end_date->format('Y-m-d') : '';
                $this->start_time = $promotion->start_time ? date('H:i', strtotime($promotion->start_time)) : '';
                $this->end_time = $promotion->end_time ? date('H:i', strtotime($promotion->end_time)) : '';
                $this->offer_image_path = $promotion->offer_image;
                $this->add_to_deal = $promotion->add_to_deal ?? false;
                $this->offer_description = $promotion->offer_description ?? '';
            }
        }
    }

    public function updatedOfferDescription()
    {
        if (strlen($this->offer_description) > 60) {
            $this->offer_description = substr($this->offer_description, 0, 60);
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'promotion_name' => $this->promotion_name,
            'pos_description' => $this->pos_description,
            'funded_by' => $this->funded_by,
            'mix_n_match' => $this->mix_n_match,
            'new_price' => $this->mix_n_match === 'new_price' ? $this->new_price : null,
            'price_reduction' => $this->mix_n_match === 'price_reduction' ? $this->price_reduction : null,
            'quantity' => $this->mix_n_match === 'quantity' ? $this->quantity : null,
            'start_date' => $this->start_date ?: null,
            'end_date' => $this->end_date ?: null,
            'start_time' => $this->start_time ?: null,
            'end_time' => $this->end_time ?: null,
            'add_to_deal' => $this->add_to_deal,
            'offer_description' => $this->offer_description,
        ];

        // Handle image upload
        if ($this->offer_image) {
            $imagePath = $this->offer_image->store('promotions', 'public');
            $data['offer_image'] = $imagePath;
        } elseif ($this->offer_image_path) {
            $data['offer_image'] = $this->offer_image_path;
        }

        if ($this->promotionId) {
            $promotion = Promotion::find($this->promotionId);
            $promotion->update($data);
            session()->put('current_promotion_id', $promotion->id);
            session()->flash('message', 'Promotion updated successfully!');
        } else {
            $promotion = Promotion::create($data);
            session()->put('current_promotion_id', $promotion->id);
            session()->flash('message', 'Promotion created successfully!');
        }

        $this->promotionId = $promotion->id;
        $this->dispatch('promotion-saved');
    }

    public function saveAndNext()
    {
        $this->save();
        // Navigate to next step
        $this->dispatch('navigate-to-promotion-tab', tab: 'items');
    }

    public function close()
    {
        return redirect()->route('promotion.index');
    }

    public function render()
    {
        $characterCount = strlen($this->offer_description);
        $payees = Payee::where('active', 1)->orderBy('vendor_name')->get();
        
        return view('livewire.promotion.promotion-setup-component', [
            'characterCount' => $characterCount,
            'payees' => $payees,
        ]);
    }
}
