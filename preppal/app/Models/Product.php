<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
        'category',
        'stock',
        'low_stock_threshold',
    ];

    public function stockStatus(): string
    {
        if ($this->stock <= 0) {
            return 'out';
        }

        if ($this->stock <= $this->low_stock_threshold) {
            return 'low';
        }

        return 'in';
    }
}