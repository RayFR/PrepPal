<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'image',
    ];

    // Ensures comparisons + formatting behave as numbers
    protected $casts = [
        'price' => 'decimal:2',
    ];
}
