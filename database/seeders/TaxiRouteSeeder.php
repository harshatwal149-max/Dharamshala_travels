<?php

namespace Database\Seeders;

use App\Models\TaxiRoute;
use Illuminate\Database\Seeder;

class TaxiRouteSeeder extends Seeder
{
    public function run(): void
    {
        $img = fn (string $name) => "/images/dharamshala/{$name}.jpg";

        /*
         * Internal reference fares (₹) for Sedan / SUV / Tempo Traveller — not shown on the website.
         * Final fares are confirmed by the travel desk at booking.
         */
        $routes = [
            [
                'from_city'   => 'Gaggal Airport',
                'to_city'     => 'Dharamshala',
                'distance_km' => 13,
                'duration'    => '30–40 minutes',
                'fares'       => [800, 1300, 2500],
                'image'       => $img('kangra-airport'),
                'short_desc'  => 'Quick, reliable pickups from Kangra (Gaggal) Airport (DHM) to any hotel in Dharamshala, timed to your flight.',
                'description' => "Gaggal Airport, officially Kangra Airport (DHM), is the nearest airport to Dharamshala, with daily flights from Delhi. The drive to lower Dharamshala takes around 30–40 minutes on the Kangra–Dharamshala road.\n\nYour driver tracks the flight and waits at arrivals with a name board, so there is no haggling at the taxi counter after landing. Waiting time for flight delays is included.",
                'highlights'  => ['Flight tracking & name-board pickup', 'Free waiting for delays', 'Drop to any hotel in Dharamshala'],
            ],
            [
                'from_city'   => 'Gaggal Airport',
                'to_city'     => 'McLeodganj',
                'distance_km' => 22,
                'duration'    => '45–60 minutes',
                'fares'       => [1000, 1600, 3000],
                'image'       => $img('gaggal-terminal'),
                'short_desc'  => 'Direct airport transfer to McLeodganj, Bhagsu or Dharamkot with drivers who know the narrow upper-town lanes.',
                'description' => "The road from Gaggal Airport climbs through Dharamshala and Forsyth Ganj to McLeodganj, around 22 km and 45–60 minutes depending on traffic in the upper bazaar.\n\nMany hotels in McLeodganj, Bhagsu and Dharamkot are on narrow one-way lanes — our drivers know the access roads and will get you as close to your door as the road allows.",
                'highlights'  => ['Drop in McLeodganj, Bhagsu, Dharamkot or Naddi', 'Via St. John in the Wilderness', 'Night arrivals welcome'],
            ],
            [
                'from_city'   => 'Dharamshala',
                'to_city'     => 'Pathankot',
                'distance_km' => 90,
                'duration'    => '2.5–3 hours',
                'fares'       => [2500, 3500, 5500],
                'image'       => $img('dharamshala-town'),
                'short_desc'  => 'Taxi between Dharamshala and Pathankot Junction / Chakki Bank — the nearest broad-gauge railway stations.',
                'description' => "Pathankot Junction and Pathankot Cantt (Chakki Bank) are the nearest major railway stations to Dharamshala, with overnight trains to and from Delhi. The 90 km drive passes through Shahpur and Nurpur.\n\nWe time pickups to your train and help with luggage on early-morning arrivals.",
                'highlights'  => ['Pathankot Junction & Chakki Bank', 'Via Nurpur Fort', 'Early-morning train pickups'],
            ],
            [
                'from_city'   => 'Dharamshala',
                'to_city'     => 'Palampur',
                'distance_km' => 35,
                'duration'    => '1–1.5 hours',
                'fares'       => [1300, 1800, 3200],
                'image'       => $img('palampur-tea'),
                'short_desc'  => 'A scenic drive through the tea country of the Kangra Valley to Palampur, with stops at Chamunda Devi and tea estates.',
                'description' => "Palampur is the tea capital of north India, surrounded by estates producing GI-tagged Kangra tea. The drive from Dharamshala follows the Dhauladhar foothills past Chamunda Devi Temple.\n\nExtend the trip to Baijnath Temple, Andretta artists' village or Bir Billing.",
                'highlights'  => ['Chamunda Devi Temple', 'Tea gardens', 'Option to continue to Baijnath & Bir'],
            ],
            [
                'from_city'   => 'Dharamshala',
                'to_city'     => 'Bir Billing',
                'distance_km' => 65,
                'duration'    => '2 hours',
                'fares'       => [2200, 3000, 5000],
                'image'       => $img('bir-paragliding'),
                'short_desc'  => 'Drop or return day trip from Dharamshala to Bir Billing for paragliding, monasteries and cafés.',
                'description' => "Bir Billing is around 65 km from Dharamshala via Palampur and Baijnath. Most travellers do it as a day trip: paragliding in the morning when conditions are best, then the Tibetan colony and monasteries in Bir.\n\nRound-trip bookings include waiting time at Bir while you fly.",
                'highlights'  => ['Via Palampur & Baijnath', 'Waiting time included on round trips', 'Sherab Ling & Chokling monasteries'],
            ],
            [
                'from_city'   => 'Dharamshala',
                'to_city'     => 'Dalhousie',
                'distance_km' => 120,
                'duration'    => '3.5–4 hours',
                'fares'       => [3500, 4800, 7500],
                'image'       => $img('dalhousie'),
                'short_desc'  => 'One-way or round-trip cab from Dharamshala to the colonial hill station of Dalhousie and the meadows of Khajjiar.',
                'description' => "The road to Dalhousie descends towards Nurpur and then climbs into the Chamba hills via Banikhet. Dalhousie's Mall Road, churches and pine forests make it a popular extension to a Dharamshala holiday.\n\nAdd a day for Khajjiar, the meadow and lake 22 km beyond Dalhousie.",
                'highlights'  => ['Nurpur Fort on the way', 'Dalhousie Mall Road', 'Optional Khajjiar excursion'],
            ],
            [
                'from_city'   => 'Dharamshala',
                'to_city'     => 'Amritsar',
                'distance_km' => 200,
                'duration'    => '5–5.5 hours',
                'fares'       => [5000, 7000, 11000],
                'image'       => $img('dhauladhar-alpenglow'),
                'short_desc'  => 'Comfortable outstation cab from Dharamshala to Amritsar for the Golden Temple, Wagah Border and Amritsar airport.',
                'description' => "The drive to Amritsar runs via Pathankot and Gurdaspur on good highways, taking around five hours. It is a popular combination with Dharamshala for the Golden Temple and the evening ceremony at the Attari–Wagah border.\n\nDrops are available to Amritsar city, the Golden Temple area, Amritsar railway station and Sri Guru Ram Dass Jee International Airport.",
                'highlights'  => ['Golden Temple & Wagah Border', 'Amritsar airport drops', 'Via Pathankot & Gurdaspur'],
            ],
            [
                'from_city'   => 'Dharamshala',
                'to_city'     => 'Chandigarh',
                'distance_km' => 240,
                'duration'    => '6–6.5 hours',
                'fares'       => [5500, 7500, 12000],
                'image'       => $img('kangra-tea-garden'),
                'short_desc'  => 'Outstation taxi from Dharamshala to Chandigarh, Mohali or Panchkula, including Chandigarh airport and railway station.',
                'description' => "The Dharamshala–Chandigarh route runs via Kangra, Ranital, Una and Ropar. It is the most common way to connect Dharamshala with Chandigarh International Airport and onward trains.\n\nComfort breaks are planned at good roadside dhabas along the way.",
                'highlights'  => ['Via Una & Ropar', 'Chandigarh airport & railway station', 'Mohali & Panchkula drops'],
            ],
            [
                'from_city'   => 'Dharamshala',
                'to_city'     => 'Manali',
                'distance_km' => 235,
                'duration'    => '6.5–7.5 hours',
                'fares'       => [5500, 7500, 12000],
                'image'       => $img('manali-mall-road'),
                'short_desc'  => 'Mountain road trip from Dharamshala to Manali via Palampur, Baijnath and Mandi along the Beas valley.',
                'description' => "One of the most scenic drives in Himachal, the route to Manali passes Palampur's tea gardens, Baijnath, Jogindernagar and Mandi before following the Beas river up the Kullu valley.\n\nOur drivers are experienced on the Mandi–Kullu stretch and in winter conditions. Stop at Bir Billing on the way for a paragliding flight if you set off early.",
                'highlights'  => ['Palampur & Baijnath', 'Mandi and the Beas valley', 'Option to stop at Bir Billing'],
            ],
            [
                'from_city'   => 'Dharamshala',
                'to_city'     => 'Shimla',
                'distance_km' => 235,
                'duration'    => '6.5–7 hours',
                'fares'       => [5500, 7500, 12000],
                'image'       => $img('dhauladhar-peaks'),
                'short_desc'  => 'Outstation cab from Dharamshala to Shimla, the summer capital, via Jawalamukhi, Hamirpur and Bilaspur.',
                'description' => "The road to Shimla runs through Kangra, Jawalamukhi, Hamirpur and Bilaspur before climbing to the capital of Himachal Pradesh. Pilgrims often stop at the Jawalamukhi temple on the way.\n\nDrops are available anywhere in Shimla, including hotels near the Mall Road and the ISBT.",
                'highlights'  => ['Jawalamukhi Temple', 'Via Hamirpur & Bilaspur', 'Drops near Mall Road'],
            ],
            [
                'from_city'   => 'Dharamshala',
                'to_city'     => 'Delhi',
                'distance_km' => 480,
                'duration'    => '10–11 hours',
                'fares'       => [9500, 13500, 22000],
                'image'       => $img('dharamshala-town'),
                'short_desc'  => 'One-way taxi from Dharamshala to Delhi, Delhi airport (IGI) or Gurugram with experienced highway drivers.',
                'description' => "The long-distance drive to Delhi follows Una, Ropar and the Ambala–Delhi highway, taking around 10–11 hours with breaks. Night departures are possible with two-driver arrangements on request.\n\nDrops are available anywhere in Delhi NCR, including Indira Gandhi International Airport.",
                'highlights'  => ['Delhi airport (IGI) drops', 'Gurugram & Noida drops', 'Comfort breaks at highway dhabas'],
            ],
        ];

        foreach ($routes as $index => $route) {
            [$sedan, $suv, $traveller] = $route['fares'];
            unset($route['fares']);

            $slug = \Illuminate\Support\Str::slug("{$route['from_city']} to {$route['to_city']} taxi");

            TaxiRoute::updateOrCreate(
                ['slug' => $slug],
                $route + [
                    'sedan_fare'       => $sedan,
                    'suv_fare'         => $suv,
                    'traveller_fare'   => $traveller,
                    'is_popular'       => true,
                    'sort_order'       => $index,
                    'meta_title'       => "{$route['from_city']} to {$route['to_city']} Taxi — Book Cab | Dharamshala Travels",
                    'meta_description' => "Book a {$route['from_city']} to {$route['to_city']} taxi ({$route['distance_km']} km, {$route['duration']}). Sedan, Innova Crysta SUV & Tempo Traveller with verified local drivers.",
                ]
            );
        }
    }
}
