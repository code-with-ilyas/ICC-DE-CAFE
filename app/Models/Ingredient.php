<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'unit', 'description'];

    public function purchaseStocks()
    {
        return $this->hasMany(PurchaseStock::class);
    }

    public function productIngredients()
    {
        return $this->hasMany(ProductIngredient::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_ingredients')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    // Get current stock level for this ingredient
    public function getCurrentStock()
    {
        return $this->purchaseStocks()->sum('remaining_quantity');
    }
}