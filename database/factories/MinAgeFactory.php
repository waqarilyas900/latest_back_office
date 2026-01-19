<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MinAgeFactory extends Factory
{
    public function definition()
    {
        return [
            'name'   => $this->faker->numberBetween(18, 25) . '+',
            'active' => $this->faker->boolean(90),
        ];
    }
}
