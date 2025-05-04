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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('guest_donor_id')->nullable();

            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('USD');
            $table->enum('payment_method', ['paypal', 'credit_card', 'bank_transfer', 'apple_pay', 'google_pay']);
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');

            $table->string('payment_reference')->nullable();
            $table->string('paypal_transaction_id')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->foreign('guest_donor_id')->references('id')->on('guest_donors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
