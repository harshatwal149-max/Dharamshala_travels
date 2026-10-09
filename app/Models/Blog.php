<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'image',
        'description',
        'blog_date',
        'multiple_images',
    ];

    protected $casts = [
        'blog_date' => 'date',
        'multiple_images' => 'array',
    ];
}