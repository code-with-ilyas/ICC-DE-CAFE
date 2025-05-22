<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id'; // Set primary key
    protected $fillable = ['name', 'description']; // Fields that can be mass-assigned

    // Define relationship with Products
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
