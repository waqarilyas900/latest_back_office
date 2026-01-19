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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_description')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->unsignedBigInteger('price_group_id')->nullable();
            $table->unsignedBigInteger('payee_id')->nullable();
            $table->unsignedBigInteger('sale_type_id')->nullable();
            $table->integer('current_qty')->default(0);
            $table->string('tag_description')->nullable();

            $table->integer('units_per_case')->nullable();
            $table->decimal('unit_retail', 10, 2)->nullable();
            $table->decimal('case_cost', 10, 2)->nullable();
            $table->decimal('case_discount', 10, 2)->nullable();
            $table->decimal('case_rebate', 10, 2)->nullable();
            $table->decimal('online_retail', 10, 2)->nullable();
            $table->decimal('cost_after_discount', 10, 2)->nullable();
            $table->unsignedBigInteger('unit_of_measure_id')->nullable();
            $table->unsignedBigInteger('size_id')->nullable();
            $table->decimal('margin', 10, 2)->nullable();
            $table->decimal('margin_after_rebate', 10, 2)->nullable();
            $table->decimal('default_margin', 10, 2)->nullable();

            $table->integer('max_inv')->nullable();
            $table->integer('min_inv')->nullable();
            $table->string('min_age')->nullable();
            $table->string('tax_rate')->nullable();
            $table->string('nacs_code')->nullable();
            $table->boolean('blue_law')->default(false);
            $table->unsignedBigInteger('nacs_category_id')->nullable();
            $table->unsignedBigInteger('nacs_sub_category_id')->nullable();
            $table->string('kitchen_option')->nullable();
            $table->string('linked_item')->nullable();
            $table->boolean('allow_ebt')->default(false);
            $table->boolean('track_inventory')->default(false);
            $table->boolean('discounted_item_taxable')->default(false);
            $table->text('ingredient_for_label')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
