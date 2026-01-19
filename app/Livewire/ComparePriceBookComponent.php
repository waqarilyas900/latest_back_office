<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

class ComparePriceBookComponent extends Component
{
    #[Layout('layouts.main')]
    public function render()
    {
        // Dummy data for compare price book
        $compareData = [
            [
                'id' => 1,
                'item_code' => 'CP001',
                'description' => 'Sample Product A',
                'current_price' => 15.99,
                'competitor_price' => 14.50,
                'difference' => 1.49,
                'status' => 'Higher'
            ],
            [
                'id' => 2,
                'item_code' => 'CP002',
                'description' => 'Sample Product B',
                'current_price' => 25.00,
                'competitor_price' => 28.00,
                'difference' => -3.00,
                'status' => 'Lower'
            ],
            [
                'id' => 3,
                'item_code' => 'CP003',
                'description' => 'Sample Product C',
                'current_price' => 12.75,
                'competitor_price' => 12.75,
                'difference' => 0.00,
                'status' => 'Equal'
            ],
        ];

        return view('livewire.compare-price-book-component', compact('compareData'));
    }
}
