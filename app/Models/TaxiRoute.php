<?php

namespace App\Models;

use App\Support\Media;
use Illuminate\Database\Eloquent\Model;

class TaxiRoute extends Model
{
    protected $fillable = [
        'from_city',
        'to_city',
        'slug',
        'distance_km',
        'duration',
        'sedan_fare',
        'suv_fare',
        'traveller_fare',
        'short_desc',
        'description',
        'highlights',
        'image',
        'meta_title',
        'meta_description',
        'is_popular',
        'sort_order',
    ];

    protected $casts = [
        'highlights'     => 'array',
        'is_popular'     => 'boolean',
        'distance_km'    => 'integer',
        'sedan_fare'     => 'decimal:2',
        'suv_fare'       => 'decimal:2',
        'traveller_fare' => 'decimal:2',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getTitleAttribute(): string
    {
        return "{$this->from_city} to {$this->to_city} Taxi";
    }

    public function getImageUrlAttribute(): ?string
    {
        return Media::url($this->image);
    }

    /**
     * Fare rows keyed by cab class, skipping classes without a fare.
     */
    public function getFaresAttribute(): array
    {
        return collect([
            ['label' => 'Sedan',           'models' => 'Swift Dzire / Etios',  'seats' => 4,  'fare' => $this->sedan_fare],
            ['label' => 'SUV',             'models' => 'Innova Crysta',        'seats' => 6,  'fare' => $this->suv_fare],
            ['label' => 'Tempo Traveller', 'models' => 'Force 12-Seater',      'seats' => 12, 'fare' => $this->traveller_fare],
        ])->filter(fn ($row) => $row['fare'] > 0)->values()->all();
    }
}
