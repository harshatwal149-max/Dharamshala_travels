<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $img = fn (string $name) => "/images/dharamshala/{$name}.jpg";

        $packages = [
            [
                'title'          => 'Dharamshala & McLeodganj Local Sightseeing',
                'slug'           => 'dharamshala-mcleodganj-local-sightseeing',
                'duration'       => 'Full Day (8 Hours)',
                'starting_price' => 2500.00,
                'short_desc'     => 'A relaxed private day covering the Dalai Lama Temple, Bhagsu Waterfall, St. John in the Wilderness, Dal Lake, the War Memorial and the HPCA Cricket Stadium.',
                'images'         => ['tsuglagkhang', 'bhagsu-falls', 'st-john-church', 'hpca-stadium', 'dal-lake'],
                'itinerary'      => [
                    'Morning'   => 'Pickup from your hotel in Dharamshala or McLeodganj. Visit the Tsuglagkhang Complex (Dalai Lama Temple), Namgyal Monastery and the Tibet Museum, then walk through the McLeodganj market.',
                    'Midday'    => 'Drive to Bhagsunag Temple and walk up to Bhagsu Waterfall. Lunch break at a café in Bhagsu or Dharamkot.',
                    'Afternoon' => 'Stop at the 1852 St. John in the Wilderness church and the deodar-fringed Dal Lake near Naddi, with views of the Dhauladhar range.',
                    'Evening'   => 'Visit the War Memorial and the HPCA Cricket Stadium before drop-off at your hotel.',
                ],
                'inclusions'     => ['Private AC cab for 8 hours / 80 km', 'Experienced local driver', 'Fuel, tolls & parking', 'Hotel pickup & drop in Dharamshala / McLeodganj'],
            ],
            [
                'title'          => 'McLeodganj & Dharamshala Spiritual Escape',
                'slug'           => 'mcleodganj-dharamshala-spiritual-escape',
                'duration'       => '3 Days / 2 Nights',
                'starting_price' => 7499.00,
                'short_desc'     => 'Three unhurried days of monasteries, Tibetan culture and mountain views — Tsuglagkhang, Norbulingka, Gyuto Monastery, Bhagsu and sunset at Naddi.',
                'images'         => ['namgyal-temple', 'norbulingka', 'gyuto-monastery', 'prayer-flags', 'mcleodganj-view'],
                'itinerary'      => [
                    'Day 1' => 'Pickup from Gaggal Airport (DHM) or Pathankot. Check in at your hotel, then visit the Tsuglagkhang Complex and the evening market in McLeodganj.',
                    'Day 2' => 'Morning at the Norbulingka Institute and Gyuto Monastery in Sidhbari. Afternoon visit to Chamunda Devi Temple on the banks of the Baner river.',
                    'Day 3' => 'Bhagsunag Temple & waterfall, a stroll through Dharamkot, and sunset at Naddi viewpoint before your departure transfer.',
                ],
                'inclusions'     => ['Dedicated cab for 3 days', 'Airport / railway station transfers', 'All sightseeing as per itinerary', 'Fuel, tolls, parking & driver allowance'],
            ],
            [
                'title'          => 'Triund Guided Trek & Camping',
                'slug'           => 'triund-guided-trek-camping',
                'duration'       => '2 Days / 1 Night',
                'starting_price' => 2999.00,
                'short_desc'     => 'Trek through oak and rhododendron forest to the Triund ridge (approx. 2,850 m), camp under the stars and wake up to the Dhauladhar range glowing at sunrise.',
                'images'         => ['triund-ridge', 'triund-hilltop', 'triund-campsite', 'five-towns-triund', 'dhauladhar-peaks'],
                'itinerary'      => [
                    'Day 1' => 'Cab drop at the Gallu Devi trailhead above Dharamkot. Guided trek of around 7 km (4–5 hours) to the Triund ridge. Evening tea, dinner and bonfire at the campsite.',
                    'Day 2' => 'Sunrise over the Dhauladhars and the Kangra Valley, breakfast, then trek down to Gallu Devi with a return cab to your hotel.',
                ],
                'inclusions'     => ['Round-trip cab to the trailhead', 'Certified trek leader', 'Tent, sleeping bag & mat', 'Dinner, breakfast & evening tea', 'Forest entry permissions'],
            ],
            [
                'title'          => 'Kangra Valley Heritage & Tea Gardens',
                'slug'           => 'kangra-valley-heritage-tea-gardens',
                'duration'       => 'Full Day (9 Hours)',
                'starting_price' => 3200.00,
                'short_desc'     => 'Discover the ancient Kangra Fort, the 8th-century Masroor rock-cut temples, the sacred Chamunda Devi temple and the Kangra tea gardens around Dharamshala.',
                'images'         => ['kangra-fort', 'masroor-temple', 'chamunda-temple', 'dharamshala-tea-garden', 'kangra-fort-ruins'],
                'itinerary'      => [
                    'Morning'   => 'Pickup from your hotel and drive to Kangra Fort, seat of the Katoch dynasty, with its museum and sweeping views over the Banganga and Manjhi rivers.',
                    'Midday'    => 'Continue to the monolithic Masroor rock-cut temples, carved out of a single sandstone ridge in the 8th century.',
                    'Afternoon' => 'Return via Chamunda Devi Temple and a walk through the Dharamshala tea gardens with a stop for fresh Kangra tea.',
                ],
                'inclusions'     => ['Private AC cab for the full day', 'Experienced local driver', 'Fuel, tolls & parking', 'Flexible pickup timings'],
            ],
            [
                'title'          => 'Bir Billing Paragliding Day Trip',
                'slug'           => 'bir-billing-paragliding-day-trip',
                'duration'       => 'Full Day (10 Hours)',
                'starting_price' => 3800.00,
                'short_desc'     => 'A private day trip from Dharamshala to Bir Billing, one of the world’s top paragliding sites, with stops at Palampur tea estates and Bir’s Tibetan monasteries.',
                'images'         => ['bir-paragliding', 'palampur-tea', 'kangra-tea-garden', 'gyuto-monastery', 'dhauladhar-alpenglow'],
                'itinerary'      => [
                    'Morning'   => 'Early pickup from Dharamshala and scenic drive (around 65 km, 2 hours) along the Dhauladhar foothills via Palampur.',
                    'Midday'    => 'Tandem paragliding from the Billing take-off (approx. 2,400 m) to the Bir landing site — flight booked separately with a certified operator.',
                    'Afternoon' => 'Visit the Tibetan colony and monasteries of Bir, then stop at the Palampur tea gardens on the drive back to Dharamshala.',
                ],
                'inclusions'     => ['Private AC cab for the full day', 'Fuel, tolls & parking', 'Driver allowance', 'Help booking a certified paragliding pilot'],
            ],
            [
                'title'          => 'Dharamshala, Dalhousie & Khajjiar Tour',
                'slug'           => 'dharamshala-dalhousie-khajjiar-tour',
                'duration'       => '5 Days / 4 Nights',
                'starting_price' => 16500.00,
                'short_desc'     => 'Combine the Tibetan charm of McLeodganj with the colonial hill station of Dalhousie and the meadows of Khajjiar, often called the Mini Switzerland of India.',
                'images'         => ['khajjiar', 'dalhousie', 'mcleodganj-market', 'namgyal-temple', 'dal-lake'],
                'itinerary'      => [
                    'Day 1' => 'Arrival at Gaggal Airport or Pathankot and transfer to Dharamshala. Evening in McLeodganj.',
                    'Day 2' => 'Dharamshala & McLeodganj sightseeing — Dalai Lama Temple, Bhagsu, St. John’s Church and Dal Lake.',
                    'Day 3' => 'Drive to Dalhousie (approx. 120 km). Evening walk on the Mall Road, Gandhi Chowk and Subhash Chowk.',
                    'Day 4' => 'Day excursion to Khajjiar meadow and lake, Kalatop forest and Panchpula.',
                    'Day 5' => 'Drive back for departure from Pathankot, Gaggal Airport or Dharamshala.',
                ],
                'inclusions'     => ['Dedicated cab for 5 days', 'Airport / railway station transfers', 'All sightseeing as per itinerary', 'Fuel, tolls, parking, state taxes & driver allowance'],
            ],
            [
                'title'          => 'Himachal Grand Circuit: Dharamshala to Manali',
                'slug'           => 'himachal-grand-circuit-dharamshala-manali',
                'duration'       => '7 Days / 6 Nights',
                'starting_price' => 26500.00,
                'short_desc'     => 'The classic Himachal road trip — Dharamshala, Bir Billing, Manali and the Kangra Valley — in a private cab with the same experienced driver throughout.',
                'images'         => ['manali-mall-road', 'bir-paragliding', 'dhauladhar-alpenglow', 'kangra-fort', 'mcleodganj-view'],
                'itinerary'      => [
                    'Day 1' => 'Pickup from Gaggal Airport or Pathankot, transfer to Dharamshala and evening at leisure in McLeodganj.',
                    'Day 2' => 'Dharamshala & McLeodganj sightseeing.',
                    'Day 3' => 'Drive to Bir Billing for paragliding and the Tibetan colony, then overnight in Bir or Palampur.',
                    'Day 4' => 'Drive to Manali via Mandi and the Beas valley. Evening on the Mall Road.',
                    'Day 5' => 'Manali sightseeing — Hadimba Temple, Vashisht, Old Manali, and Solang Valley (season permitting).',
                    'Day 6' => 'Return towards the Kangra Valley with a stop at Kangra Fort.',
                    'Day 7' => 'Departure transfer to Gaggal Airport, Pathankot or onward.',
                ],
                'inclusions'     => ['Dedicated cab for 7 days', 'Airport / railway station transfers', 'All sightseeing as per itinerary', 'Fuel, tolls, parking, state taxes & driver allowance'],
            ],
            [
                'title'          => 'Kareri Lake Trek',
                'slug'           => 'kareri-lake-trek',
                'duration'       => '3 Days / 2 Nights',
                'starting_price' => 6499.00,
                'short_desc'     => 'A quieter alternative to Triund — trek along the Nyund stream to the glacial Kareri Lake (approx. 2,934 m) in the Dhauladhar range.',
                'images'         => ['kareri-lake', 'dhauladhar-peaks', 'triund-hilltop', 'dhauladhar-alpenglow', 'prayer-flags'],
                'itinerary'      => [
                    'Day 1' => 'Cab from Dharamshala to Kareri village (approx. 30 km). Trek to the Reoti campsite along the Nyund stream.',
                    'Day 2' => 'Trek to Kareri Lake and the Shiva temple on its shore. Camp by the lake.',
                    'Day 3' => 'Descend to Kareri village and cab back to Dharamshala.',
                ],
                'inclusions'     => ['Round-trip cab to Kareri village', 'Certified trek leader', 'Tents, sleeping bags & mats', 'All meals on the trek'],
            ],
            [
                'title'          => 'Shimla & Manali Tour Package',
                'slug'           => 'shimla-manali-tour-package',
                'duration'       => '6 Days / 5 Nights',
                'starting_price' => 22500.00,
                'short_desc'     => 'Tour route: Delhi - Shimla - Manali - Delhi. Jakhu Temple, The Mall & The Ridge in Shimla, then Hadimba Devi Temple, Vashisht hot springs, Naggar Castle and an excursion to Rohtang Pass from Manali.',
                'images'         => ['manali-mall-road', 'dhauladhar-peaks', 'dhauladhar-alpenglow', 'prayer-flags', 'dharamshala-town'],
                'itinerary'      => [
                    'Day 1' => 'Arrival Delhi / Kalka - Shimla. Meet our representative and drive to Shimla. On arrival check in at the hotel. Dinner and overnight at the hotel.',
                    'Day 2' => 'Shimla. Morning visit Jakhu Hanuman Temple, Green Valley and the Indian Institute of Advanced Studies. Evening free to stroll in the famous shopping places of Shimla town - The Mall and The Ridge. Dinner and overnight at the hotel.',
                    'Day 3' => 'Shimla - Manali (320 km / 8 hrs). After an early breakfast proceed to Manali, a hill station surrounded by snow mountains and beautiful waterfalls. On arrival check in at the hotel. Dinner and overnight at Manali.',
                    'Day 4' => 'Manali. After breakfast, city tour visiting Naggar Castle, Jagatsukh Temples, Hadimba Devi Temple, Manu Temple, the Tibetan Monastery and Vashisht hot springs. Afternoon at leisure. Dinner and overnight at the hotel.',
                    'Day 5' => 'Manali. Full day excursion visiting Kothi Gorge, Gulaba, Marhi and Rohtang Pass, the most visited tourist spot in the Himalaya (permit and season permitting). Afternoon free for shopping. Dinner and overnight at the hotel.',
                    'Day 6' => 'Manali - Delhi (Departure). After breakfast depart to Kalka and board the train to Delhi (ETD 1800 hrs, ETA 2200 hrs). On arrival our representative meets you and transfers you to your destination (within Delhi only).',
                ],
                'inclusions'     => ['Hotel stay with breakfast & dinner', 'Private cab for all transfers & sightseeing', 'Kalka - Delhi train ticket', 'Delhi drop on arrival (within Delhi only)', 'Fuel, tolls, parking, state taxes & driver allowance'],
            ],
            [
                'title'          => 'Dharamshala & Amritsar Tour Package',
                'slug'           => 'dharamshala-amritsar-tour-package',
                'duration'       => '6 Days / 5 Nights',
                'starting_price' => 18500.00,
                'short_desc'     => 'Tour route: Amritsar - Dharamshala - Delhi. The Golden Temple, Jallianwala Bagh and the Wagah Border flag ceremony, followed by the Dalai Lama Temple, Bhagsu Nag, Norbulingka Institute, Naddi and Dharamkot.',
                'images'         => ['tsuglagkhang', 'bhagsu-falls', 'norbulingka', 'dharamkot', 'mcleodganj-market'],
                'itinerary'      => [
                    'Day 1' => 'Arrival Amritsar. Arrive at Amritsar Railway Station, where our representative meets and greets you and takes you to the hotel. Check in, rest of the day at leisure. Overnight at Amritsar.',
                    'Day 2' => 'Amritsar. After breakfast, full day city tour starting with the Golden Temple, the most important Sikh shrine and a living symbol of Sikh spiritual and historical traditions. Then visit Jallianwala Bagh, where on 13 April 1919 British soldiers opened fire on an unarmed gathering, killing hundreds of civilians. After lunch visit the Maharaja Ranjit Singh Summer Palace Museum in the heart of Ram Bagh. In the evening visit the Indo-Pak Wagah Border (30 km from Amritsar) to watch the "Beating the Retreat" flag ceremony, as soldiers from both countries march in perfect drill and lower their national flags at sunset amid thunderous applause. Return to the hotel for the night.',
                    'Day 3' => 'Amritsar - Dharamshala (215 km / 5 hrs). After breakfast drive to Dharamshala, the Himalayan hill resort that is home to the Dalai Lama. Check in at the hotel; the rest of the day is free. We suggest a walk along the Mall Road, where Tibetan refugees display and sell their crafts. Overnight in Dharamshala.',
                    'Day 4' => 'Dharamshala. After breakfast visit Tsuglagkhang, Dharamshala\'s main Buddhist temple, commonly known as the Dalai Lama Temple. The complex houses the Namgyal Monastery, which trains monks for the temple\'s rituals. Later visit Bhagsu Nag Temple and waterfall. Evening at leisure. Overnight in Dharamshala.',
                    'Day 5' => 'Dharamshala - McLeodganj. After breakfast visit the Norbulingka Institute, with its own temple, museum and meditation hall, where 1,173 images of the Buddha decorate the 44-foot-high temple hall. Later visit Naddi and Dharamkot village. Overnight at McLeodganj.',
                    'Day 6' => 'McLeodganj - Delhi / Chandigarh. After breakfast the rest of the day is free to spend at leisure, followed by the overnight bus to Delhi.',
                ],
                'inclusions'     => ['Hotel stay with breakfast', 'Amritsar railway station pickup', 'Private cab for all transfers & sightseeing', 'Wagah Border excursion', 'Overnight bus ticket to Delhi', 'Fuel, tolls, parking, state taxes & driver allowance'],
            ],
        ];

        foreach ($packages as $package) {
            $images = array_map($img, $package['images']);
            unset($package['images']);

            Package::updateOrCreate(
                ['slug' => $package['slug']],
                $package + [
                    'thumbnail'   => $images[0],
                    'image_2'     => $images[1] ?? null,
                    'image_3'     => $images[2] ?? null,
                    'image_4'     => $images[3] ?? null,
                    'image_5'     => $images[4] ?? null,
                    'is_featured' => true,
                ]
            );
        }
    }
}
