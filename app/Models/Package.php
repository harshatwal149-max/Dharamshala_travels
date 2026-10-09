<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
    'title',
    'duration',
    'starting_price',
    'short_desc',
    'itinerary',
    'inclusions',
    'thumbnail',
    'image_2',
    'image_3',
    'image_4',
    'image_5',
    'slug',
    'rating',
    'reviews_count',
    'is_featured',
];

    protected $casts = [
        'itinerary' => 'array',
        'inclusions' => 'array',
        'is_featured' => 'boolean',
        'starting_price' => 'decimal:2',
        'rating' => 'decimal:1',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}