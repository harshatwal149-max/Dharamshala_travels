<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $img = fn (string $name) => "/images/dharamshala/{$name}.jpg";

        $vehicles = [
            [
                'name'             => 'Maruti Suzuki Dzire',
                'category'         => 'Sedan',
                'badge'            => 'Most Booked',
                'rate_per_km'      => 12.00,
                'base_fare'        => 1500.00,
                'seating_capacity' => 4,
                'luggage_capacity' => 2,
                'image'            => $img('car-dzire'),
                'gallery'          => [$img('car-dzire'), $img('mcleodganj-view')],
                'features'         => ['Air Conditioning', 'Experienced Hill Driver', 'Ideal for Couples & Small Families', 'Airport Pickup with Name Board'],
                'is_active'        => true,
            ],
            [
                'name'             => 'Toyota Etios',
                'category'         => 'Sedan',
                'badge'            => 'Comfort Sedan',
                'rate_per_km'      => 13.00,
                'base_fare'        => 1600.00,
                'seating_capacity' => 4,
                'luggage_capacity' => 3,
                'image'            => $img('car-etios'),
                'gallery'          => [$img('car-etios'), $img('dharamshala-town')],
                'features'         => ['Air Conditioning', 'Spacious Boot', 'Comfortable Rear Legroom', 'Music System'],
                'is_active'        => true,
            ],
            [
                'name'             => 'Toyota Innova Crysta',
                'category'         => 'Premium SUV',
                'badge'            => 'Best for Hill Roads',
                'rate_per_km'      => 18.00,
                'base_fare'        => 2800.00,
                'seating_capacity' => 6,
                'luggage_capacity' => 4,
                'image'            => $img('car-innova-crysta'),
                'gallery'          => [$img('car-innova-crysta'), $img('dhauladhar-peaks')],
                'features'         => ['Dual AC', 'Captain Seats', 'High Ground Clearance', 'Large Luggage Space', 'Ideal for Outstation Trips'],
                'is_active'        => true,
            ],
            [
                'name'             => 'Force Tempo Traveller',
                'category'         => 'Group Van',
                'badge'            => 'Best for Groups',
                'rate_per_km'      => 26.00,
                'base_fare'        => 4500.00,
                'seating_capacity' => 12,
                'luggage_capacity' => 8,
                'image'            => $img('car-tempo-traveller'),
                'gallery'          => [$img('car-tempo-traveller'), $img('kangra-tea-garden')],
                'features'         => ['Pushback Seats', 'Roof Luggage Carrier', 'AC Cabin', 'Music System', 'First Aid Kit'],
                'is_active'        => true,
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($vehicle['name'])],
                $vehicle
            );
        }
    }
}
