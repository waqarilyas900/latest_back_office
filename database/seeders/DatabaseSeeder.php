<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    User,
    BankAccount,
    Department,
    MinAge,
    NacsCategory,
    ProductCategory,
    SaleType,
    Size,
    Term,
    UnitOfMeasure
};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user
        // User::factory()->create([
        //     'name'  => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Seed model data
        BankAccount::factory(10)->create();
        Department::factory(10)->create();
        MinAge::factory(5)->create();
        NacsCategory::factory(10)->create();
        ProductCategory::factory(10)->create();
        SaleType::factory(5)->create();
        Size::factory(5)->create();
        Term::factory(5)->create();
        UnitOfMeasure::factory(5)->create();
    }
}
