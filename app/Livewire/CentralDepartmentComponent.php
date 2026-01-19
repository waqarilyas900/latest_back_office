<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

class CentralDepartmentComponent extends Component
{
    #[Layout('layouts.main')]
    public function render()
    {
        // Dummy data for central department
        $departmentData = [
            [
                'id' => 1,
                'department_name' => 'Electronics',
                'total_items' => 150,
                'avg_price' => 89.99,
                'revenue' => 12500.00,
                'status' => 'Active'
            ],
            [
                'id' => 2,
                'department_name' => 'Clothing',
                'total_items' => 200,
                'avg_price' => 45.50,
                'revenue' => 9100.00,
                'status' => 'Active'
            ],
            [
                'id' => 3,
                'department_name' => 'Home & Garden',
                'total_items' => 75,
                'avg_price' => 125.00,
                'revenue' => 9375.00,
                'status' => 'Active'
            ],
            [
                'id' => 4,
                'department_name' => 'Sports',
                'total_items' => 120,
                'avg_price' => 65.25,
                'revenue' => 7830.00,
                'status' => 'Inactive'
            ],
        ];

        return view('livewire.central-department-component', compact('departmentData'));
    }
}
