<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $img = fn (string $name) => "/images/dharamshala/{$name}.jpg";

        $blogs = [
            [
                'title'     => 'Top 12 Places to Visit in Dharamshala & McLeodganj',
                'slug'      => 'top-places-to-visit-in-dharamshala-mcleodganj',
                'blog_date' => '2026-09-28',
                'image'     => $img('mcleodganj-view'),
                'multiple_images' => [$img('namgyal-temple'), $img('bhagsu-falls'), $img('st-john-church'), $img('hpca-stadium')],
                'description' => <<<'TXT'
Dharamshala is really two towns in one: lower Dharamshala, with the Kotwali Bazar, the HPCA Cricket Stadium and the War Memorial, and upper Dharamshala — McLeodganj — the hilltop home of the Tibetan community in exile. Here are the places we recommend most often to our guests.

1. Tsuglagkhang Complex (Dalai Lama Temple)
The spiritual heart of McLeodganj, with the main temple, Namgyal Monastery and the Tibet Museum. Walk the kora path around the complex in the early morning.

2. McLeodganj Market
Temple Road and Jogiwara Road are full of Tibetan handicrafts, bookshops, cafés and momo stalls.

3. Bhagsunag Temple & Bhagsu Waterfall
An ancient Shiva temple with spring-fed pools, and a short walk to the waterfall. Best after the monsoon.

4. Triund
The most popular trek in the region — around 7 km from the Gallu Devi trailhead to a ridge facing the Dhauladhar range.

5. St. John in the Wilderness
A neo-Gothic church from 1852, hidden among deodar trees on the road to McLeodganj.

6. Dal Lake & Naddi Viewpoint
A calm lake in the forest and, a little further on, one of the best sunset views of the Dhauladhars.

7. HPCA Cricket Stadium
Arguably the most scenic cricket ground in the world, with snow peaks behind the pavilion.

8. War Memorial
A peaceful park in the pines honouring the soldiers of Himachal Pradesh.

9. Norbulingka Institute
Gardens and workshops dedicated to Tibetan art — watch thangka painters at work.

10. Gyuto Monastery
A golden-roofed tantric monastery in Sidhbari with a dramatic mountain backdrop.

11. Dharamkot
Cafés, meditation centres and forest walks in a quiet village above McLeodganj.

12. Kangra Tea Gardens
Rolling tea estates on the Palampur road, producing GI-tagged Kangra tea.

You can comfortably cover most of these in a full-day local sightseeing tour with a private cab, leaving the Triund trek for a separate day.
TXT,
            ],
            [
                'title'     => 'How to Reach Dharamshala: Flights, Trains, Buses & Taxis',
                'slug'      => 'how-to-reach-dharamshala',
                'blog_date' => '2026-09-20',
                'image'     => $img('kangra-airport'),
                'multiple_images' => [$img('gaggal-terminal'), $img('dharamshala-town')],
                'description' => <<<'TXT'
Dharamshala is in the Kangra district of Himachal Pradesh, about 480 km north of Delhi. Here is how to get here.

By Air — Gaggal (Kangra) Airport, DHM
The nearest airport is Kangra Airport at Gaggal, around 13 km from Dharamshala and 22 km from McLeodganj. There are daily flights from Delhi, and connections to other cities through Delhi. A pre-booked taxi takes 30–40 minutes to Dharamshala and 45–60 minutes to McLeodganj.

By Train — Pathankot
The nearest broad-gauge railway stations are Pathankot Junction and Pathankot Cantt (Chakki Bank), around 90 km away, with overnight trains from Delhi. The drive from Pathankot to Dharamshala takes about 2.5–3 hours. The narrow-gauge Kangra Valley Railway from Pathankot to Joginder Nagar is a slow but beautiful heritage ride; Kangra Mandir station is the nearest stop for Dharamshala.

By Road
Volvo and HRTC buses run overnight from Delhi (ISBT Kashmere Gate) and Chandigarh to Dharamshala and McLeodganj. By car or taxi, the route from Delhi runs via Ambala, Ropar, Una and Kangra and takes 10–11 hours.

Getting Around
Roads in the upper town are narrow and steep, and parking is limited. Most visitors hire a local taxi for airport transfers and sightseeing rather than self-driving.

Planning tip: Book your airport pickup in advance so a driver is waiting at arrivals with your name — especially for evening flights.
TXT,
            ],
            [
                'title'     => 'Triund Trek Guide: Distance, Difficulty, Best Time & Tips',
                'slug'      => 'triund-trek-guide',
                'blog_date' => '2026-09-12',
                'image'     => $img('triund-ridge'),
                'multiple_images' => [$img('triund-hilltop'), $img('triund-campsite'), $img('five-towns-triund')],
                'description' => <<<'TXT'
Triund is a grassy ridge at around 2,850 m above McLeodganj, and the most popular trek in Dharamshala. It is ideal for beginners with reasonable fitness.

Trail & Distance
The usual starting point is the Gallu Devi temple above Dharamkot, which you can reach by taxi. From there the trail is about 7 km one way and takes 3–5 hours up. You can also start on foot from McLeodganj via Dharamkot, which adds about 2 km.

Difficulty
Easy to moderate. The first half climbs gently through oak and rhododendron forest; the last stretch, known locally as the "22 curves", is steeper and rocky.

Best Time
March to June and September to December. During the monsoon (July–August) the trail is slippery and views are often hidden by cloud. In winter there can be snow at the top.

Camping
Camping on the ridge lets you watch both sunset and sunrise over the Dhauladhar range. Use a registered operator and carry back all your waste.

What to Carry
Good trekking shoes, at least 2 litres of water, a warm layer (it gets cold at night even in summer), a rain jacket, snacks, sunscreen and a torch.

Going Further
Fit trekkers can continue to the Snowline café and Laka Glacier, around 5 km beyond Triund. Indrahar Pass is a much tougher multi-day extension.
TXT,
            ],
            [
                'title'     => 'Best Time to Visit Dharamshala: A Season-by-Season Guide',
                'slug'      => 'best-time-to-visit-dharamshala',
                'blog_date' => '2026-09-02',
                'image'     => $img('dhauladhar-alpenglow'),
                'multiple_images' => [$img('kangra-tea-garden'), $img('dhauladhar-peaks')],
                'description' => <<<'TXT'
Dharamshala is a year-round destination, but each season offers a very different trip.

Spring (March to April)
Rhododendrons bloom on the trails, the air is clear and the Dhauladhars still carry plenty of snow. A great time for Triund and sightseeing.

Summer (May to June)
Peak season. Daytime temperatures are pleasant (roughly 20–30°C in lower Dharamshala) while the plains are hot. Book cabs and hotels early, especially on weekends.

Monsoon (July to August)
Dharamshala is one of the wettest places in Himachal. Waterfalls like Bhagsu are at their fullest and the valley is lush green, but treks can be slippery and landslides occasionally disrupt mountain roads.

Autumn (September to November)
Our favourite season. The rain washes the air clean, giving crisp views of the snow peaks, and it is the best time for paragliding at Bir Billing.

Winter (December to February)
Cold, with occasional snowfall in McLeodganj and regular snow on the peaks. Quieter streets and lower hotel rates. Carry warm clothing, and expect higher trails to be closed after heavy snow.

In short: March–June and September–November are ideal for most travellers, while winter suits those who want snow views and fewer crowds.
TXT,
            ],
            [
                'title'     => 'Gaggal Airport to McLeodganj: Taxi Guide, Travel Time & Tips',
                'slug'      => 'gaggal-airport-to-mcleodganj-taxi-guide',
                'blog_date' => '2026-08-24',
                'image'     => $img('gaggal-terminal'),
                'multiple_images' => [$img('kangra-airport'), $img('mcleodganj-market')],
                'description' => <<<'TXT'
Kangra Airport at Gaggal (airport code DHM) is the closest airport to Dharamshala and McLeodganj. Here is what to expect when you land.

Distance & Time
Gaggal Airport to Dharamshala is about 13 km (30–40 minutes). Gaggal Airport to McLeodganj is about 22 km (45–60 minutes), climbing through Dharamshala and Forsyth Ganj.

Taxi Options
The airport has a taxi stand, but pre-booking means a driver is already waiting at arrivals with your name. Sedans (Swift Dzire, Etios) suit up to 4 passengers with light luggage; an Innova Crysta is better for families or larger bags; a Tempo Traveller works for groups of 8–12.

Tips
• Share your flight number so the driver can track delays.
• If your hotel is in Bhagsu, Dharamkot or on a narrow lane, tell us the exact location — some lanes are not motorable.
• Evening arrivals: roads to McLeodganj are well travelled, but a local driver familiar with the hairpins makes the night drive much easier.
TXT,
            ],
            [
                'title'     => 'Bir Billing Paragliding from Dharamshala: Complete Day-Trip Guide',
                'slug'      => 'bir-billing-paragliding-day-trip-from-dharamshala',
                'blog_date' => '2026-08-15',
                'image'     => $img('bir-paragliding'),
                'multiple_images' => [$img('palampur-tea'), $img('gyuto-monastery')],
                'description' => <<<'TXT'
Bir Billing, around 65 km from Dharamshala, is one of the best paragliding sites in the world and hosted the Paragliding World Cup in 2015. It is an easy and rewarding day trip.

Getting There
The drive takes about 2 hours via Palampur and Baijnath. Leave Dharamshala by 7:00–7:30 AM — flying conditions are usually best from late morning to early afternoon.

The Flight
Tandem flights take off from the Billing meadow (approx. 2,400 m) and land at Bir (approx. 1,400 m). Flights usually last 15–30 minutes depending on the package and the weather. Always fly with a certified pilot and a registered operator.

Best Season
October–November and March–May have the most stable weather. Flying is suspended during the monsoon, typically from mid-July to mid-September.

What Else to Do in Bir
Explore the Tibetan colony, Sherab Ling and Chokling monasteries, and the many cafés near the landing site. Tea gardens around Bir and Palampur make great photo stops on the drive back.

Our Tip
Book a round-trip cab: the driver waits while you fly, and you can stop at Chamunda Devi Temple or the Palampur tea estates on the way home.
TXT,
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::updateOrCreate(['slug' => $blog['slug']], $blog);
        }
    }
}
