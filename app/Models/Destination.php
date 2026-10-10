<?php

namespace App\Models;

use App\Support\Media;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category',
        'tagline',
        'short_desc',
        'description',
        'image',
        'gallery',
        'highlights',
        'distance',
        'altitude',
        'best_time',
        'timings',
        'entry_fee',
        'how_to_reach',
        'latitude',
        'longitude',
        'meta_title',
        'meta_description',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'gallery'     => 'array',
        'highlights'  => 'array',
        'is_featured' => 'boolean',
        'latitude'    => 'float',
        'longitude'   => 'float',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getImageUrlAttribute(): ?string
    {
        return Media::url($this->image);
    }

    public function getGalleryUrlsAttribute(): array
    {
        return collect($this->gallery ?? [])
            ->map(fn ($path) => Media::url($path))
            ->filter()
            ->values()
            ->all();
    }
}
