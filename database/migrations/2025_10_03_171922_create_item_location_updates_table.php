<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_location_updates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('location_id');
            $table->integer('units_per_case')->nullable();
            $table->decimal('unit_retail', 10, 2)->nullable();
            $table->decimal('case_cost', 10, 2)->nullable();
            $table->decimal('case_discount', 10, 2)->nullable();
            $table->decimal('case_rebate', 10, 2)->nullable();
            $table->decimal('online_retail', 10, 2)->nullable();
            $table->decimal('cost_after_discount', 10, 2)->nullable();
            $table->unsignedBigInteger('unit_of_measure_id');
            $table->unsignedBigInteger('size_id');
            $table->decimal('margin', 10, 2)->nullable();
            $table->decimal('margin_after_rebate', 10, 2)->nullable();
            $table->decimal('default_margin', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_location_updates');
    }
};
