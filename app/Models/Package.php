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

    /**
     * Inclusions as a clean array — admin saves them either as an array
     * or as a JSON-encoded string inside the cast column.
     */
    public function getInclusionListAttribute(): array
    {
        $value = $this->inclusions;

        while (is_string($value) && ($decoded = json_decode($value, true)) !== null) {
            $value = $decoded;
        }

        if (is_string($value)) {
            $value = preg_split('/\r?\n|,/', $value);
        }

        return collect((array) $value)->map(fn ($item) => trim((string) $item))->filter()->values()->all();
    }

    /**
     * Rough trip type used for filtering on the tours page.
     */
    public function getTripTypeAttribute(): string
    {
        $text = strtolower($this->title . ' ' . $this->duration);

        if (str_contains($text, 'trek')) {
            return 'Treks';
        }

        return preg_match('/\bnights?\b|\b[2-9]\s*days?\b/', $text) ? 'Multi-day Tours' : 'Day Trips';
    }
}