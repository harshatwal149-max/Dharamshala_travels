<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'booking_type',
        'customer_name',
        'customer_phone',
        'customer_email',
        'pickup_location',
        'drop_location',
        'travel_date',
        'travel_time',
        'vehicle_id',
        'package_id',
        'estimated_fare',
        'status',
        'notes',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'estimated_fare' => 'decimal:2',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}