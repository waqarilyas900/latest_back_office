<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UnitOfMeasureFactory extends Factory
{
    public function definition()
    {
        return [
            'name'   => $this->faker->randomElement(['Each', 'Case', 'Dozen', 'Pack']),
            'active' => $this->faker->boolean(90),
        ];
    }
}
