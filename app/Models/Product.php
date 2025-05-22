<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id'; // Set primary key
    protected $fillable = ['category_id', 'name', 'description', 'price', 'is_available']; // Fields that can be mass-assigned

    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
   
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'product_ingredients')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    // Check if product can be made with current stock
    public function canBeMade($quantity = 1)
    {
        foreach ($this->ingredients as $ingredient) {
            $requiredAmount = $ingredient->pivot->quantity * $quantity;
            $availableAmount = $ingredient->getCurrentStock();
            
            if ($availableAmount < $requiredAmount) {
                return false;
            }
        }
        return true;
    }
    
}