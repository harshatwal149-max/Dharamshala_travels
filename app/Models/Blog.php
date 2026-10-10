<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image',
        'description',
        'blog_date',
        'multiple_images',
    ];

    protected $casts = [
        'blog_date' => 'date',
        'multiple_images' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Blog $blog) {
            if (empty($blog->slug) && !empty($blog->title)) {
                $slug = Str::slug($blog->title);
                $blog->slug = static::where('slug', $slug)->exists()
                    ? $slug . '-' . Str::lower(Str::random(4))
                    : $slug;
            }
        });
    }
}