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
        Schema::create('carton_item_mappings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_item_id');
            $table->unsignedBigInteger('mapped_item_id');
            $table->integer('pack_qty');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carton_item_mappings');
    }
};
