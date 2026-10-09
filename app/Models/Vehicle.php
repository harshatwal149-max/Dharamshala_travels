<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'badge',
        'rate_per_km',
        'base_fare',
        'seating_capacity',
        'luggage_capacity',
        'image',
        'gallery',
        'features',
        'is_active',
    ];

    protected $casts = [
        'gallery'          => 'array',
        'features'         => 'array',
        'is_active'        => 'boolean',
        'rate_per_km'      => 'decimal:2',
        'base_fare'        => 'decimal:2',
        'seating_capacity' => 'integer',
        'luggage_capacity' => 'integer',
    ];

    /**
     * Automate append all_images to array/json conversions
     */
    protected $appends = ['all_images'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Main image + Gallery images ko single sanitized list mein return karega
     */
    public function getAllImagesAttribute(): array
    {
        $images = [];

        if (!empty($this->image)) {
            $images[] = $this->image;
        }

        if (is_array($this->gallery)) {
            foreach ($this->gallery as $item) {
                if (!empty($item) && !in_array($item, $images)) {
                    $images[] = $item;
                }
            }
        }

        return array_values($images);
    }
}