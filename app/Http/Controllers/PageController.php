<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Package;
use App\Models\TaxiRoute;
use App\Models\Vehicle;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Places to visit — listing.
     */
    public function destinations()
    {
        $destinations = Destination::orderBy('sort_order')->orderBy('name')->get();

        $seo = [
            'title'       => 'Places to Visit in Dharamshala & McLeodganj — Sightseeing Guide',
            'description' => 'Explore the best places to visit in Dharamshala, McLeodganj and the Kangra Valley — Dalai Lama Temple, Bhagsu Waterfall, Triund, Kangra Fort, Bir Billing and more, with distances, timings and taxi tips.',
            'keywords'    => 'places to visit in dharamshala, mcleodganj sightseeing, dharamshala tourist places, kangra valley attractions, triund, bhagsu waterfall',
            'image'       => '/images/dharamshala/mcleodganj-view.jpg',
            'breadcrumbs' => ['Destinations' => route('destinations.index')],
            'schema'      => [[
                '@type'           => 'ItemList',
                'name'            => 'Places to visit in Dharamshala',
                'itemListElement' => $destinations->values()->map(fn ($d, $i) => [
                    '@type'    => 'ListItem',
                    'position' => $i + 1,
                    'url'      => route('destinations.show', $d),
                    'name'     => $d->name,
                ])->all(),
            ]],
        ];

        return view('destinations.index', compact('destinations', 'seo'));
    }

    /**
     * Single destination guide.
     */
    public function destination(Destination $destination)
    {
        $related = Destination::where('id', '!=', $destination->id)
            ->where(fn ($q) => $q->where('category', $destination->category)->orWhere('is_featured', true))
            ->orderByRaw('category = ? desc', [$destination->category])
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        $packages = Package::where('is_featured', true)->take(3)->get();

        $attraction = [
            '@type'       => 'TouristAttraction',
            'name'        => $destination->name,
            'description' => $destination->short_desc,
            'image'       => array_values(array_unique(array_merge([$destination->image_url], $destination->gallery_urls))),
            'url'         => route('destinations.show', $destination),
            'address'     => [
                '@type'           => 'PostalAddress',
                'addressRegion'   => 'Himachal Pradesh',
                'addressCountry'  => 'IN',
            ],
            'isAccessibleForFree' => Str::contains(Str::lower((string) $destination->entry_fee), 'free'),
        ];

        if ($destination->latitude && $destination->longitude) {
            $attraction['geo'] = [
                '@type'     => 'GeoCoordinates',
                'latitude'  => $destination->latitude,
                'longitude' => $destination->longitude,
            ];
        }

        $seo = [
            'title'       => $destination->meta_title ?: "{$destination->name} — Dharamshala Travel Guide",
            'description' => $destination->meta_description ?: $destination->short_desc,
            'keywords'    => Str::lower("{$destination->name}, {$destination->name} dharamshala, {$destination->name} timings, taxi to {$destination->name}, dharamshala sightseeing"),
            'image'       => $destination->image,
            'type'        => 'article',
            'breadcrumbs' => [
                'Destinations'     => route('destinations.index'),
                $destination->name => route('destinations.show', $destination),
            ],
            'schema'      => [$attraction],
        ];

        return view('destinations.show', compact('destination', 'related', 'packages', 'seo'));
    }

    /**
     * Taxi routes — listing.
     */
    public function taxiRoutes()
    {
        $routes = TaxiRoute::orderBy('sort_order')->get();
        $vehicles = Vehicle::where('is_active', true)->orderBy('base_fare')->get();

        $seo = [
            'title'       => 'Dharamshala Taxi Routes — Outstation & Airport Cabs',
            'description' => 'Book taxis from Dharamshala and Gaggal Airport to McLeodganj, Pathankot, Amritsar, Chandigarh, Manali, Shimla, Dalhousie, Bir Billing and Delhi. Sedan, SUV and Tempo Traveller.',
            'keywords'    => 'dharamshala taxi service, dharamshala to manali taxi, dharamshala to amritsar taxi, dharamshala to delhi taxi, gaggal airport taxi, dharamshala outstation cab',
            'image'       => '/images/dharamshala/car-innova-crysta.jpg',
            'breadcrumbs' => ['Taxi Routes' => route('taxi-routes.index')],
        ];

        return view('taxi-routes.index', compact('routes', 'vehicles', 'seo'));
    }

    /**
     * Single taxi route.
     */
    public function taxiRoute(TaxiRoute $taxiRoute)
    {
        $route = $taxiRoute;

        $otherRoutes = TaxiRoute::where('id', '!=', $route->id)->orderBy('sort_order')->take(6)->get();
        $faqs = [
            ["How far is {$route->to_city} from {$route->from_city}?",
                "{$route->to_city} is approximately {$route->distance_km} km from {$route->from_city} by road. The drive usually takes {$route->duration}, depending on traffic and weather."],
            ["Which cabs are available from {$route->from_city} to {$route->to_city}?",
                'You can book a sedan (Swift Dzire or Etios), a Toyota Innova Crysta SUV or a 12-seater Tempo Traveller for this route.'],
            ['Can I book a round trip?',
                'Yes. Round trips and multi-day bookings are available — tell us your dates and our travel desk will arrange it.'],
            ['Do I need to pay in advance?',
                'No advance payment is needed to send a booking request. Our team calls you to confirm the vehicle and pickup time.'],
        ];

        $seo = [
            'title'       => $route->meta_title ?: "{$route->title} — Booking & Route Guide",
            'description' => $route->meta_description ?: $route->short_desc,
            'keywords'    => Str::lower("{$route->from_city} to {$route->to_city} taxi, {$route->from_city} to {$route->to_city} cab, {$route->to_city} taxi"),
            'image'       => $route->image,
            'breadcrumbs' => [
                'Taxi Routes' => route('taxi-routes.index'),
                $route->title => route('taxi-routes.show', $route),
            ],
            'schema'      => [
                [
                    '@type'       => 'Service',
                    'serviceType' => 'Taxi service',
                    'name'        => $route->title,
                    'description' => $route->short_desc,
                    'image'       => $route->image_url,
                    'provider'    => ['@type' => 'TaxiService', 'name' => \App\Models\Setting::get('site_title') ?: 'Dharamshala Travels', 'url' => url('/')],
                    'areaServed'  => [['@type' => 'Place', 'name' => $route->from_city], ['@type' => 'Place', 'name' => $route->to_city]],
                ],
                static::faqSchema($faqs),
            ],
        ];

        return view('taxi-routes.show', compact('route', 'otherRoutes', 'faqs', 'seo'));
    }

    /**
     * Gaggal (Kangra) Airport taxi landing page.
     */
    public function airportTaxi()
    {
        $airportRoutes = TaxiRoute::where('from_city', 'like', 'Gaggal%')->orderBy('sort_order')->get();
        $vehicles = Vehicle::where('is_active', true)->orderBy('base_fare')->get();

        $faqs = [
            ['How far is Gaggal Airport from Dharamshala and McLeodganj?',
                'Gaggal (Kangra) Airport is about 13 km from Dharamshala (30–40 minutes) and about 22 km from McLeodganj (45–60 minutes).'],
            ['Will the driver wait if my flight is delayed?',
                'Yes. Share your flight number when booking — the driver tracks your flight and waits at arrivals with a name board.'],
            ['Which cab should I book for a family?',
                'A sedan (Swift Dzire or Etios) suits up to 4 passengers with 2–3 bags. For families with more luggage, the Toyota Innova Crysta is more comfortable, and a Tempo Traveller suits groups of 8–12.'],
            ['Can you drop us directly at hotels in Bhagsu or Dharamkot?',
                'We drop as close to your hotel as the road allows. Some lanes in Bhagsu and Dharamkot are not motorable — our driver will help you with luggage for the last few steps.'],
            ['Is the airport also called Kangra Airport?',
                'Yes. Gaggal Airport and Kangra Airport are the same airport, with the IATA code DHM.'],
        ];

        $seo = [
            'title'       => 'Gaggal Airport Taxi — Kangra Airport (DHM) to Dharamshala & McLeodganj Cabs',
            'description' => 'Pre-book a Gaggal (Kangra) Airport taxi to Dharamshala, McLeodganj, Bhagsu, Dharamkot and Palampur. Flight tracking, name-board pickup and experienced local drivers.',
            'keywords'    => 'gaggal airport taxi, kangra airport taxi, dhm airport cab, gaggal airport to mcleodganj taxi, gaggal airport to dharamshala taxi',
            'image'       => '/images/dharamshala/kangra-airport.jpg',
            'breadcrumbs' => ['Gaggal Airport Taxi' => route('airport-taxi')],
            'schema'      => [static::faqSchema($faqs)],
        ];

        return view('pages.airport-taxi', compact('airportRoutes', 'vehicles', 'faqs', 'seo'));
    }

    /**
     * About us.
     */
    public function about()
    {
        $seo = [
            'title'       => 'About Dharamshala Travels — Local Taxi & Tour Operator',
            'description' => 'Dharamshala Travels is a local taxi and tour desk in Dharamshala, Himachal Pradesh, offering airport transfers, sightseeing, outstation cabs and Himachal tour packages with experienced hill drivers.',
            'image'       => '/images/dharamshala/dhauladhar-alpenglow.jpg',
            'breadcrumbs' => ['About Us' => route('about')],
        ];

        $vehicles = Vehicle::where('is_active', true)->orderBy('base_fare')->get();

        return view('pages.about', compact('seo', 'vehicles'));
    }

    /**
     * Attribution for Creative Commons photographs used on the site.
     */
    public function photoCredits()
    {
        $credits = collect(json_decode(file_get_contents(resource_path('data/photo-credits.json')), true))
            ->map(fn ($c, $key) => $c + ['file' => "/images/dharamshala/{$key}.jpg"]);

        $seo = [
            'title'       => 'Photo Credits — Dharamshala Travels',
            'description' => 'Attribution for the Creative Commons photographs of Dharamshala, McLeodganj and the Kangra Valley used on this website.',
            'breadcrumbs' => ['Photo Credits' => route('photo-credits')],
        ];

        return view('pages.photo-credits', compact('credits', 'seo'));
    }

    /**
     * FAQPage JSON-LD from [question, answer] pairs.
     */
    public static function faqSchema(array $faqs): array
    {
        return [
            '@type'      => 'FAQPage',
            'mainEntity' => array_map(fn ($faq) => [
                '@type'          => 'Question',
                'name'           => $faq[0],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq[1]],
            ], $faqs),
        ];
    }
}
