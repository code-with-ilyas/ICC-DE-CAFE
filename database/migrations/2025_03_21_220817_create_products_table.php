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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id'); // Primary Key
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Foreign Key
            $table->string('name', 100); // Product name
            $table->text('description')->nullable(); // Optional description
            $table->decimal('price', 10, 2); // Product price
            $table->boolean('is_available')->default(true); // Availability status
            $table->integer('quantity')->default(0);
            $table->timestamps(); // Created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};