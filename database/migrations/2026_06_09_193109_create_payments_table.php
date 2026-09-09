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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('order_id');   // link to orders
        $table->string('payment_method');         // e.g. credit_card, paypal, cash
        $table->decimal('amount', 10, 2);         // payment amount
        $table->string('status')->default('pending'); // pending, completed, failed
        $table->timestamps();

        // Foreign key to orders table
        $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::dropIfExists('payments');
}

};
