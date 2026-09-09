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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');   // customer placing the order
        $table->decimal('total_price', 10, 2);   // total order amount
        $table->string('status')->default('pending'); // pending, paid, shipped, completed
        $table->timestamps();

        // Foreign key to users table
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::dropIfExists('orders');
}


    /**
     * Reverse the migrations.
     */
};
