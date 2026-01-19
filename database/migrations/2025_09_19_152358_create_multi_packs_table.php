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
        Schema::create('multi_packs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->integer('modifier_qty');
            $table->decimal('item_cost', 10, 2)->nullable();
            $table->decimal('enter_retail', 10, 2)->nullable();
            $table->decimal('margin', 10, 2)->nullable();
            $table->unsignedBigInteger('linked_item_id')->nullable();
            $table->string('scan_code_modifier')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multi_packs');
    }
};
