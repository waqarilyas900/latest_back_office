<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SaleTypeFactory extends Factory
{
    public function definition()
    {
        return [
            'name'   => $this->faker->randomElement(['Retail', 'Wholesale', 'Online']),
            'active' => $this->faker->boolean(90),
        ];
    }
}
