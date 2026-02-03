<?php

// app/Models/StockLog.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id', 'type', 'quantity', 'unit', 'user_id', 'note'
    ];

    public function stock() {
        return $this->belongsTo(Stock::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
