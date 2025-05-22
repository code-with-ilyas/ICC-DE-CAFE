<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseStocksTable extends Migration
{
    public function up()
    {
        Schema::create('purchase_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade');
            $table->decimal('quantity', 10, 2);
            $table->decimal('cost_price', 10, 2);
            $table->date('purchase_date');
            $table->date('expiry_date')->nullable();
            $table->string('supplier')->nullable();
            $table->decimal('remaining_quantity', 10, 2); // Track remaining stock
            $table->string('batch_number')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_stocks');
    }
}