<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMovementsTable extends Migration
{
    public function up()
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_id')->constrained();
            $table->foreignId('purchase_stock_id')->nullable()->constrained();
            $table->foreignId('order_id')->nullable()->constrained();
            $table->string('type'); // purchase, order, adjustment, wastage
            $table->decimal('quantity', 10, 2);
            $table->decimal('remaining_balance', 10, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_movements');
    }
}