<?php

namespace Database\Factories;

use App\Models\BankAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class BankAccountFactory extends Factory
{
    protected $model = BankAccount::class;

    public function definition()
    {
        return [
            'account_name' => $this->faker->company,
            'account_number' => $this->faker->bankAccountNumber,
            'active' => $this->faker->boolean,
        ];
    }
}
