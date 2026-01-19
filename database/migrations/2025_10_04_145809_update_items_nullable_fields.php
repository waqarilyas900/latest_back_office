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
        Schema::table('items', function (Blueprint $table) {
            $table->integer('current_qty')->nullable()->default(0)->change();
            $table->boolean('blue_law')->nullable()->default(false)->change();
            $table->boolean('allow_ebt')->nullable()->default(false)->change();
            $table->boolean('track_inventory')->nullable()->default(false)->change();
            $table->boolean('discounted_item_taxable')->nullable()->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->integer('current_qty')->default(0)->change();
            $table->boolean('blue_law')->default(false)->change();
            $table->boolean('allow_ebt')->default(false)->change();
            $table->boolean('track_inventory')->default(false)->change();
            $table->boolean('discounted_item_taxable')->default(false)->change();
        });
    }
};
