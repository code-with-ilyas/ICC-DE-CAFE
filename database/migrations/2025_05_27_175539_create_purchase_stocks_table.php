<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('purchase_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name');
            $table->string('supplier_number')->nullable(); // Added supplier number
            $table->date('date');
            $table->string('product_name');
            $table->string('quantity'); // Changed from integer to string for values like "2 kg"
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2); // Added total price
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_stocks');
    }
};
