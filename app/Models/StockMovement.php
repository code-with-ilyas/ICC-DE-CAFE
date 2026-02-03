<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'type',      // add, deduct, restore
        'quantity',
        'unit',
        'reason',
    ];

    // Relationship to Stock
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
