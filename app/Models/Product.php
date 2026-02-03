<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products'; // ✅ explicit (safe)
    protected $primaryKey = 'product_id';
    public $incrementing = true;    // ✅ important
    protected $keyType = 'int';     // ✅ important

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'is_available',
        'quantity'
    ];

    // ✅ Category relation
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // ✅ Product → ProductStock (pivot)
    public function productStocks(): HasMany
    {
        return $this->hasMany(ProductStock::class, 'product_id', 'product_id');
    }
}
