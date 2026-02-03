<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    // Table is automatically 'inventories', so no need to specify

    protected $fillable = [
        'name',
        'quantity',
        'unit',
        'price',
    ];
}
