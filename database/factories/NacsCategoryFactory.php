<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NacsCategoryFactory extends Factory
{
    public function definition()
    {
        return [
            'name'   => $this->faker->word . ' Category',
            'active' => $this->faker->boolean(90),
        ];
    }
}
