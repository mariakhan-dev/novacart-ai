<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->string('brand')->nullable()->after('category_id');

            $table->string('sku')->nullable()->unique()->after('brand');

            $table->enum('stock_status', [
                'In Stock',
                'Low Stock',
                'Out of Stock'
            ])->default('In Stock')->after('stock');

            $table->integer('discount')->default(0)->after('stock_status');

            $table->boolean('featured')->default(false)->after('discount');

            $table->boolean('trending')->default(false)->after('featured');

            $table->boolean('best_seller')->default(false)->after('trending');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->dropColumn([
                'brand',
                'sku',
                'stock_status',
                'discount',
                'featured',
                'trending',
                'best_seller'
            ]);

        });
    }
};