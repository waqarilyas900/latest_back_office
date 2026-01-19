<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SizeFactory extends Factory
{
    public function definition()
    {
        return [
            'name'   => $this->faker->randomElement(['Small', 'Medium', 'Large']),
            'active' => $this->faker->boolean(90),
        ];
    }
}
