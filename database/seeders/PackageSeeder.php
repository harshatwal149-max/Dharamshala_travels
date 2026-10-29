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
            [
                'title'          => 'Chandigarh to Pathankot Himachal Tour: Shimla, Manali, Dharamshala & Dalhousie',
                'slug'           => 'chandigarh-to-pathankot-himachal-tour',
                'duration'       => '8 Days / 7 Nights',
                'short_desc'     => 'Tour route: Chandigarh - Shimla - Manali - Dharamshala - Dalhousie - Pathankot. Rock Garden and Sukhna Lake, The Ridge and Kufri, Hadimba Temple and Solang Valley, McLeodganj, and the meadows of Khajjiar, ending at Pathankot.',
                'images'         => ['manali-mall-road', 'khajjiar', 'mcleodganj-view', 'dalhousie', 'dhauladhar-peaks'],
                'itinerary'      => [
                    'Day 1' => 'Chandigarh - Shimla (115 km / 4 hrs). Pickup from Chandigarh airport, railway station or hotel. Visit Nek Chand\'s Rock Garden, Sukhna Lake and the Zakir Hussain Rose Garden, then drive up to Shimla via Pinjore Gardens. Check in and overnight in Shimla.',
                    'Day 2' => 'Shimla. Morning excursion to Kufri for views of the snow ranges, then Jakhu Hanuman Temple. Afternoon visit to the Viceregal Lodge (Indian Institute of Advanced Study), followed by an evening walk on The Ridge, Christ Church, The Mall and Lakkar Bazaar. Overnight in Shimla.',
                    'Day 3' => 'Shimla - Manali (250 km / 8 hrs). Scenic drive via Bilaspur, Sundernagar and Pandoh Dam, then along the Beas river through Kullu with stops at the Kullu shawl factories and river rafting points. Check in and overnight in Manali.',
                    'Day 4' => 'Manali. Morning visit to Solang Valley for snow points, ropeway and adventure activities, with an optional drive through the Atal Tunnel to Sissu (season and permit permitting). Afternoon: Hadimba Devi Temple, Manu Temple, Vashisht hot springs and the Tibetan Monastery, ending on Mall Road. Overnight in Manali.',
                    'Day 5' => 'Manali - Dharamshala (235 km / 7-8 hrs). Drive via Kullu and Mandi with en-route sightseeing at the 13th-century Baijnath Shiva Temple and the Palampur tea gardens, and a stop at Chamunda Devi Temple near Dharamshala. Check in and overnight in Dharamshala.',
                    'Day 6' => 'Dharamshala - Dalhousie (120 km / 4 hrs). Morning sightseeing in McLeodganj: Tsuglagkhang (Dalai Lama Temple), Bhagsunag Temple and waterfall, and St. John in the Wilderness church. After lunch drive to Dalhousie. Evening walk on Mall Road, Gandhi Chowk and Subhash Chowk. Overnight in Dalhousie.',
                    'Day 7' => 'Dalhousie - Khajjiar - Dalhousie. Excursion to Khajjiar, the Mini Switzerland of India, with its meadow, lake and Khajji Nag Temple, via the Kalatop Wildlife Sanctuary. Back in Dalhousie, visit Panchpula, Satdhara Falls and St. John\'s Church. Overnight in Dalhousie.',
                    'Day 8' => 'Dalhousie - Pathankot (80 km / 3 hrs). After breakfast drive down to Pathankot for drop at the railway station, Pathankot airport or onward bus. End of trip.',
                ],
                'inclusions'     => ['Dedicated cab for 8 days', 'Chandigarh pickup & Pathankot drop', 'All sightseeing as per itinerary', 'Fuel, tolls, parking, state taxes & driver allowance'],
            ],
            [
                'title'          => 'Kangra Valley, Dalhousie & Chamba Tour from Gaggal Airport',
                'slug'           => 'kangra-valley-dalhousie-chamba-tour-from-gaggal',
                'duration'       => '7 Days / 6 Nights',
                'short_desc'     => 'Tour route: Gaggal Airport - Dharamshala - Kangra - Dalhousie - Chamba. McLeodganj, Norbulingka, Gyuto Tantric Monastery and Baijnath, the Shaktipeeth temples of Chintpurni, Jawalaji, Brajeshwari Devi and Baglamukhi, Kangra Fort, Masroor, Pong Dam and Tatta Pani, then Dalhousie, Khajjiar, Bhalei Mata and Chamera Lake.',
                'images'         => ['baijnath-temple', 'jawalamukhi-temple', 'baglamukhi-temple', 'khajjiar', 'chamera-lake'],
                'itinerary'      => [
                    'Day 1' => 'Gaggal Airport - Dharamshala - McLeodganj (15 km / 30 min). Pickup from Gaggal Airport and transfer to your hotel. Dharamshala and McLeodganj sightseeing: Tsuglagkhang (Dalai Lama Temple) and Namgyal Monastery, Bhagsunag Temple and waterfall, St. John in the Wilderness, Dal Lake and the War Memorial. Evening in McLeodganj market. Overnight in Dharamshala.',
                    'Day 2' => 'Dharamshala - Baijnath - Dharamshala. Morning at the Norbulingka Institute, known for its Tibetan arts and crafts, and the Gyuto Tantric Monastery in Sidhbari with the Dhauladhar range behind it. Continue to the 13th-century Baijnath Shiva Temple, one of the oldest stone temples in Himachal. Return to Dharamshala in the evening. Overnight in Dharamshala.',
                    'Day 3' => 'Shaktipeeth temple circuit (approx. 250 km). Full day visiting the Devi temples of the region: Chintpurni Mata Temple, Jawalaji (Jawalamukhi) Temple with its eternal flames, Brajeshwari Devi Temple in Kangra town, and the Baglamukhi Temple at Bankhandi. Return to Dharamshala in the evening. Overnight in Dharamshala.',
                    'Day 4' => 'Kangra sightseeing. Visit Kangra Fort, one of the oldest forts in India, and the 8th-century Masroor rock-cut temples carved from a single sandstone ridge. Afternoon at the Pong Dam (Maharana Pratap Sagar) reservoir and bird sanctuary, ending with a dip at the Tatta Pani (Tatwani) hot springs near Shahpur. Overnight in Dharamshala.',
                    'Day 5' => 'Dharamshala - Dalhousie (120 km / 4 hrs). After breakfast drive to Dalhousie and check in. Evening walk on Mall Road, Gandhi Chowk, Subhash Chowk and St. John\'s Church. Overnight in Dalhousie.',
                    'Day 6' => 'Dalhousie - Khajjiar - Dalhousie. Local sightseeing with an excursion to the Khajjiar meadow and lake, the Mini Switzerland of India, and the Khajji Nag Temple via Kalatop Wildlife Sanctuary. Back in Dalhousie, visit Panchpula and Satdhara Falls. Overnight in Dalhousie.',
                    'Day 7' => 'Dalhousie - Chamba - departure. Drive to the Bhalei Mata Temple, then on to Chamba to see Chamera Lake and the rock garden in Chamba, along with the Laxmi Narayan Temple complex and the Chaugan ground. In the afternoon, drop at Pathankot or Gaggal Airport. End of trip.',
                ],
                'inclusions'     => ['Dedicated cab for 7 days', 'Gaggal Airport pickup', 'Drop at Pathankot or Gaggal Airport', 'All sightseeing as per itinerary', 'Fuel, tolls, parking, state taxes & driver allowance'],
            ],
            [
                'title'          => 'Chandigarh, Shimla, Manali, Dharamshala & Dalhousie Tour to Pathankot',
                'slug'           => 'chandigarh-shimla-manali-dharamshala-dalhousie-pathankot-tour',
                'duration'       => '9 Days / 8 Nights',
                'short_desc'     => 'Tour route: Chandigarh - Shimla - Manali - Dharamshala - Dalhousie - Khajjiar - Pathankot. Chandigarh local sightseeing, Shimla and Kufri, Manali and Solang Valley, 2 nights / 3 days in Dharamshala and McLeodganj, then Dalhousie and Khajjiar, ending at Pathankot.',
                'images'         => ['shimla-ridge', 'chandigarh-rock-garden', 'solang-valley', 'mcleodganj-view', 'khajjiar'],
                'itinerary'      => [
                    'Day 1' => 'Chandigarh local sightseeing - Shimla (115 km / 4 hrs). Pickup from Chandigarh airport, railway station or hotel. Visit Nek Chand\'s Rock Garden, Sukhna Lake and the Zakir Hussain Rose Garden, then drive up to Shimla via Pinjore Gardens. Check in and overnight in Shimla.',
                    'Day 2' => 'Shimla local sightseeing. Morning excursion to Kufri for views of the snow ranges, then Jakhu Hanuman Temple. Afternoon visit to the Viceregal Lodge (Indian Institute of Advanced Study), followed by an evening walk on The Ridge, Christ Church, The Mall and Lakkar Bazaar. Overnight in Shimla.',
                    'Day 3' => 'Shimla - Manali (250 km / 8 hrs). Scenic drive via Bilaspur, Sundernagar and Pandoh Dam, then along the Beas river through Kullu with stops at the Kullu shawl factories and river rafting points. Check in and overnight in Manali.',
                    'Day 4' => 'Manali sightseeing. Morning visit to Solang Valley for snow points, ropeway and adventure activities, with an optional drive through the Atal Tunnel to Sissu (season and permit permitting). Afternoon: Hadimba Devi Temple, Manu Temple, Vashisht hot springs and the Tibetan Monastery, ending on Mall Road. Overnight in Manali.',
                    'Day 5' => 'Manali - Dharamshala (235 km / 7-8 hrs). Drive via Kullu and Mandi with en-route sightseeing at the 13th-century Baijnath Shiva Temple and the Palampur tea gardens. Check in and overnight in Dharamshala.',
                    'Day 6' => 'Dharamshala & McLeodganj sightseeing. Tsuglagkhang (Dalai Lama Temple) and Namgyal Monastery, Bhagsunag Temple and waterfall, St. John in the Wilderness, Dal Lake, Naddi viewpoint, the War Memorial and the HPCA Cricket Stadium. Evening in McLeodganj market. Overnight in Dharamshala.',
                    'Day 7' => 'Dharamshala - Dalhousie (120 km / 4 hrs). Morning visit to the Norbulingka Institute and Chamunda Devi Temple, then drive to Dalhousie. Evening walk on Mall Road, Gandhi Chowk and Subhash Chowk. Overnight in Dalhousie.',
                    'Day 8' => 'Dalhousie - Khajjiar - Dalhousie. Excursion to Khajjiar, the Mini Switzerland of India, with its meadow, lake and Khajji Nag Temple, via the Kalatop Wildlife Sanctuary. Back in Dalhousie, visit Panchpula, Satdhara Falls and St. John\'s Church. Overnight in Dalhousie.',
                    'Day 9' => 'Dalhousie - Pathankot (80 km / 3 hrs). After breakfast drive down to Pathankot for drop at the railway station, Pathankot airport or onward bus. End of trip.',
                ],
                'inclusions'     => ['Dedicated cab for 9 days', 'Chandigarh pickup & Pathankot drop', 'All sightseeing as per itinerary', 'Fuel, tolls, parking, state taxes & driver allowance'],
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
