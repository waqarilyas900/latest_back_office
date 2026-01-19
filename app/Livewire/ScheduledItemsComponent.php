<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

class ScheduledItemsComponent extends Component
{
    #[Layout('layouts.main')]
    public function render()
    {
        // Dummy data for scheduled items
        $scheduledData = [
            [
                'id' => 1,
                'item_code' => 'SCH001',
                'description' => 'Scheduled Product A',
                'schedule_date' => '2024-01-15',
                'price_change' => 5.00,
                'new_price' => 25.99,
                'status' => 'Pending'
            ],
            [
                'id' => 2,
                'item_code' => 'SCH002',
                'description' => 'Scheduled Product B',
                'schedule_date' => '2024-01-20',
                'price_change' => -2.50,
                'new_price' => 18.50,
                'status' => 'Approved'
            ],
            [
                'id' => 3,
                'item_code' => 'SCH003',
                'description' => 'Scheduled Product C',
                'schedule_date' => '2024-01-25',
                'price_change' => 10.00,
                'new_price' => 35.00,
                'status' => 'Pending'
            ],
            [
                'id' => 4,
                'item_code' => 'SCH004',
                'description' => 'Scheduled Product D',
                'schedule_date' => '2024-01-30',
                'price_change' => -1.00,
                'new_price' => 12.99,
                'status' => 'Rejected'
            ],
        ];

        return view('livewire.scheduled-items-component', compact('scheduledData'));
    }
}
