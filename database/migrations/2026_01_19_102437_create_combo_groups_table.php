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
        Schema::create('combo_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('combo_id');
            $table->string('description')->nullable();
            $table->integer('quantity')->default(0);
            $table->decimal('combo_price', 10, 2)->default(0);
            $table->integer('items_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combo_groups');
    }
};
