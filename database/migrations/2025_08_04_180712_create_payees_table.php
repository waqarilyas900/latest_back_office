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
        Schema::create('payees', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_name')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('account_number')->nullable();
            $table->string('payment_method')->nullable();
            $table->text('address_1')->nullable();
            $table->text('address_2')->nullable();
            $table->unsignedBigInteger('term_id')->nullable();
            $table->string('pos_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('default_margin')->nullable();
            $table->unsignedBigInteger('default_bank_account_id')->nullable();
            $table->string('fintech_vendor_code')->nullable();
            $table->json('types')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payees');
    }
};
