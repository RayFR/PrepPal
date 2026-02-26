<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
   protected $fillable = [
    'title', 'slug', 'section', 'category', 'excerpt', 'content',
    'cover_image', 'is_featured', 'views',
    'published', 'published_at',
];


    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
    ];

}
 