<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $fillable = ['product_id','stock_id','quantity'];

    public function product() {
        return $this->belongsTo(Product::class,'product_id','product_id');
    }

    public function stock() {
        return $this->belongsTo(Stock::class,'stock_id','id'); // make sure FK matches DB
    }


    public function quantityInBase(): float
{
    return $this->quantity;
}

}
