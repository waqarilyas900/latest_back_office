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
        Schema::table('item_location_updates', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_of_measure_id')->nullable()->change();
            $table->unsignedBigInteger('size_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_location_updates', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_of_measure_id')->change();
            $table->unsignedBigInteger('size_id')->change();
        });
    }
};
