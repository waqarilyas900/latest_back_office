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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('promotion_name')->nullable();
            $table->text('pos_description')->nullable();
            $table->string('funded_by')->nullable(); // By Retailer dropdown
            $table->enum('mix_n_match', ['new_price', 'price_reduction', 'quantity'])->nullable();
            $table->decimal('new_price', 10, 2)->nullable();
            $table->decimal('price_reduction', 10, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('offer_image')->nullable(); // Path to uploaded image
            $table->boolean('add_to_deal')->default(false); // Add deal to Cartzie checkbox
            $table->text('offer_description')->nullable(); // Cartzie Offer Description (max 60 chars)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
