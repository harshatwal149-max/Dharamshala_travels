<?php

namespace Database\Seeders;

use App\Models\HeroBanner;
use Illuminate\Database\Seeder;

class HeroBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'image'    => '/images/dharamshala/dhauladhar-alpenglow.jpg',
                'title'    => 'Explore Dharamshala with Trusted Local Drivers',
                'subtitle' => 'Airport pickups, McLeodganj sightseeing and outstation cabs across Himachal with experienced local drivers.',
            ],
            [
                'image'    => '/images/dharamshala/kangra-tea-garden.jpg',
                'title'    => 'Kangra Valley Tours, Tea Gardens & Temples',
                'subtitle' => 'Private day trips to Kangra Fort, Chamunda Devi, Norbulingka and the tea estates of Palampur.',
            ],
            [
                'image'    => '/images/dharamshala/triund-ridge.jpg',
                'title'    => 'Triund, Bir Billing & Beyond',
                'subtitle' => 'Trek drop-offs, paragliding day trips and multi-day Himachal circuits with experienced hill drivers.',
            ],
        ];

        foreach ($banners as $index => $banner) {
            HeroBanner::updateOrCreate(
                ['image' => $banner['image']],
                $banner + ['is_active' => true, 'sort_order' => $index]
            );
        }
    }
}
