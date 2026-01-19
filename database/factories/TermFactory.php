<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TermFactory extends Factory
{
    public function definition()
    {
        return [
            'name'   => $this->faker->randomElement(['Net 30', 'Net 60', 'COD']),
            'active' => $this->faker->boolean(90),
        ];
    }
}
