<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\Package;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Vehicles Fleet
        // 1. Seed Vehicles Fleet (Exact Models)
        $vehicles = [
            [
                'name' => 'Maruti Suzuki Dzire',
                'category' => 'Sedan',
                'badge' => 'Most Popular',
                'rate_per_km' => 13.00,
                'base_fare' => 1600.00,
                'seating_capacity' => 4,
                'luggage_capacity' => 2,
                'image' => 'https://imgd.aeplcdn.com/1056x594/n/cw/ec/45691/dzire-exterior-right-front-three-quarter-3.jpeg?q=80',
                'features' => ['Air Conditioning', 'Experienced Hill Driver', 'Clean Interior', 'Music System'],
                'is_active' => true,
            ],
            [
                'name' => 'Toyota Innova Crysta',
                'category' => 'Premium SUV',
                'badge' => 'Luxury Hill Ride',
                'rate_per_km' => 20.00,
                'base_fare' => 2800.00,
                'seating_capacity' => 7,
                'luggage_capacity' => 4,
                'image' => 'https://imgd.aeplcdn.com/1056x594/n/cw/ec/140809/innova-crysta-exterior-right-front-three-quarter-2.jpeg?isig=0&q=80',
                'features' => ['Dual AC', 'Captain Recliner Seats', 'High Ground Clearance', 'Ample Luggage Boot'],
                'is_active' => true,
            ],
            [
                'name' => 'Force Tempo Traveller',
                'category' => 'Group Van',
                'badge' => 'Best For Large Groups',
                'rate_per_km' => 28.00,
                'base_fare' => 4500.00,
                'seating_capacity' => 12,
                'luggage_capacity' => 8,
                'image' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=1000&q=80',
                'features' => ['Pushback Seats', 'Separate Luggage Carrier', 'Music & Mic', 'First Aid Onboard'],
                'is_active' => true,
            ]
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }

        // 2. Seed Himachal Packages
        $packages = [
            [
                'title' => 'McLeodganj & Dharamshala Spiritual Escape',
                'slug' => 'mcleodganj-dharamshala-spiritual-escape',
                'duration' => '3 Days / 2 Nights',
                'starting_price' => 5499.00,
                'thumbnail' => 'https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?auto=format&fit=crop&w=800&q=80',
                'short_desc' => 'Visit Dalai Lama Temple, Bhagsu Waterfall, HPCA Cricket Stadium, and explore Tibetan market cafes.',
                'itinerary' => [
                    'Day 1' => 'Gaggal Airport pickup, hotel check-in, visit Dalai Lama Temple and Tsuglagkhang Complex.',
                    'Day 2' => 'Scenic excursion to Bhagsu Nag waterfall, Bhagsunath Temple, and sunset at Naddi Viewpoint.',
                    'Day 3' => 'Visit the iconic HPCA Stadium, War Memorial, and departure transfer.'
                ],
                'inclusions' => ['Dedicated Cab for 3 Days', 'All Hill Tolls & Parking', 'Fuel & Driver Allowance', 'Sightseeing Transfers'],
                'rating' => 4.9,
                'reviews_count' => 86,
                'is_featured' => true,
            ],
            [
                'title' => 'Triund Guided Trek & Alpine Camping',
                'slug' => 'triund-guided-trek-camping',
                'duration' => '2 Days / 1 Night',
                'starting_price' => 2999.00,
                'thumbnail' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80',
                'short_desc' => 'Trek through rhododendron forests to witness panoramic Dhauladhar snow peaks and starry night camping.',
                'itinerary' => [
                    'Day 1' => 'Cab drop at Dharamkot starting point. 9 km guided trek to Triund Ridge. Bonfire & Alpine camp stay.',
                    'Day 2' => 'Catch sunrise over Kangra Valley. Breakfast and scenic downhill trek back with return cab transfer.'
                ],
                'inclusions' => ['Round-trip Cab Transfer', 'Certified Trek Leader', 'Dome Tents & Sleeping Bags', 'Dinner & Campfire'],
                'rating' => 5.0,
                'reviews_count' => 142,
                'is_featured' => true,
            ],
            [
                'title' => 'Kangra Valley Heritage & Tea Gardens',
                'slug' => 'kangra-valley-heritage-tea-gardens',
                'duration' => 'Full Day (8 Hours)',
                'starting_price' => 2199.00,
                'thumbnail' => 'https://images.unsplash.com/photo-1589182373726-e4f658ab50f0?auto=format&fit=crop&w=800&q=80',
                'short_desc' => 'Discover the 1000-year-old Kangra Fort, sacred Brajeshwari Devi Temple, and lush Palampur tea estates.',
                'itinerary' => [
                    'Day 1' => 'Morning pickup from hotel. Visit historical Kangra Fort, Chamunda Devi Temple, and Dharamshala Tea Company tour.'
                ],
                'inclusions' => ['Private Sedan/SUV for full day', 'Toll Taxes & Driver Allowance', 'Flexible pickup timings'],
                'rating' => 4.8,
                'reviews_count' => 49,
                'is_featured' => true,
            ],
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}