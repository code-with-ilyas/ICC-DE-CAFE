<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductIngredientsTable extends Migration
{
    public function up()
    {
        Schema::create('product_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade');
            $table->decimal('quantity', 10, 2); // How much of this ingredient is needed for one product
            $table->timestamps();
            
            // Ensure a product can't have the same ingredient twice
            $table->unique(['product_id', 'ingredient_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_ingredients');
    }
}