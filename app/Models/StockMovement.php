<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'ingredient_id',
        'purchase_stock_id',
        'order_id',
        'type',
        'quantity',
        'remaining_balance',
        'notes'
    ];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function purchaseStock()
    {
        return $this->belongsTo(PurchaseStock::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}