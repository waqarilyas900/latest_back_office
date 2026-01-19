<?php

namespace App\Livewire\Product;

use App\Models\ItemPriceHistory;
use Livewire\Component;
use Livewire\WithPagination;

class PriceHistoryComponent extends Component
{
    use WithPagination;

    public $selectedItemId;
    protected $paginationTheme = 'bootstrap'; // or 'tailwind'


    public function render()
    {
        $histories = ItemPriceHistory::with(['item', 'user'])
            ->when($this->selectedItemId, fn ($q) => $q->where('item_id', $this->selectedItemId))
            ->latest()
            ->paginate(10);

        return view('livewire.product.price-history-component', [
            'histories' => $histories,
        ]);
    }
}
