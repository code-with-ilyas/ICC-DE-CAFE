<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'ingredient_id', 
        'quantity', 
        'cost_price', 
        'purchase_date',
        'expiry_date',
        'supplier',
        'remaining_quantity',
        'batch_number'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}