<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_ingredients', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('products', 'product_id')
                ->onDelete('cascade');

            $table->foreignId('stock_id')
                ->constrained('stocks')
                ->onDelete('cascade');

            $table->decimal('quantity', 10, 2); // how much ingredient used
            $table->string('unit', 20); // g, kg, pcs

            $table->timestamps();

            $table->unique(['product_id', 'stock_id']); // prevent duplicate ingredient
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_ingredients');
    }
};
