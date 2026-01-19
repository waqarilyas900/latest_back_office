<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $tables = [
            'bank_accounts',
            'payees',
            'terms',
            'sizes',
            'unit_of_measures',
            'min_ages',
            'nacs_categories',
            'price_groups',
            'items',
            'departments',
            'product_categories',
            'sale_types',
            'users'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (!Schema::hasColumn($table->getTable(), 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'bank_accounts',
            'payees',
            'terms',
            'sizes',
            'unit_of_measures',
            'min_ages',
            'nacs_categories',
            'price_groups',
            'items',
            'departments',
            'categories',
            'sale_types',
            'users'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (Schema::hasColumn($table->getTable(), 'deleted_at')) {
                    $table->dropSoftDeletes();
                }
            });
        }
    }
};
