<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\Vehicle;
use App\Models\Setting;
use App\Models\Review;
use App\Models\Blog;
use App\Models\Destination;
use App\Models\HeroBanner;
use App\Models\TaxiRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Homepage
     */
    public function index()
    {
        $vehicles = Vehicle::where('is_active', true)
            ->get();

        $packages = Package::where('is_featured', true)
            ->get();

        $reviews = Review::where('is_approved', true)
            ->latest()
            ->take(6)
            ->get();

        $blogs = Blog::latest('blog_date')
            ->latest('id')
            ->take(3)
            ->get();

        /*
         * Fallback hero settings.
         *
         * Actual active HeroBanner records are handled
         * directly in welcome.blade.php.
         */
        $banner = [
            'hero_banner_image' => Setting::get(
                'hero_banner_image',
                'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=1200&q=80'
            ),

            'hero_title' => Setting::get(
                'hero_title',
                'Reliable Cab Services in Dharamshala'
            ),

            'hero_subtitle' => Setting::get(
                'hero_subtitle',
                'Punctual airport transfers, outstation routes, and local excursions with verified drivers and upfront rates.'
            ),
        ];

        $heroBanners = HeroBanner::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            // Skip banners whose uploaded file is missing from the public disk.
            ->filter(fn ($b) => Str::startsWith($b->image, ['http://', 'https://', '/'])
                || Storage::disk('public')->exists($b->image))
            ->values();

        $destinations = Destination::where('is_featured', true)
            ->orderBy('sort_order')
            ->take(7)
            ->get();

        $taxiRoutes = TaxiRoute::where('is_popular', true)
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        $faqs = [
            ['How do I book a taxi in Dharamshala?',
                'Use the booking form on this page, call us or message us on WhatsApp. Share your pickup point, destination and travel date, and our travel desk confirms your cab by phone.'],
            ['How far is Gaggal Airport from McLeodganj?',
                'Gaggal (Kangra) Airport is about 22 km from McLeodganj — roughly 45–60 minutes by taxi. Lower Dharamshala is about 13 km, or 30–40 minutes.'],
            ['Can I book a round trip or multi-day cab?',
                'Yes. Round trips, multi-day sightseeing and full Himachal circuits are available with the same driver throughout.'],
            ['Which places can I cover in one day of local sightseeing?',
                'A typical full day covers the Dalai Lama Temple, Bhagsu Waterfall, St. John in the Wilderness, Dal Lake, the War Memorial and the HPCA Cricket Stadium.'],
            ['Do you provide cabs for Triund trek and Bir Billing?',
                'Yes. We drop trekkers at the Gallu Devi trailhead for Triund, and run day trips to Bir Billing for paragliding with waiting time included.'],
            ['Can I book a cab from Dharamshala to Manali, Amritsar or Delhi?',
                'Yes. We run one-way and round-trip outstation cabs to Manali, Shimla, Dalhousie, Amritsar, Chandigarh, Pathankot and Delhi.'],
        ];

        $seo = [
            'image'  => $heroBanners->first()->image ?? '/images/dharamshala/dhauladhar-alpenglow.jpg',
            'schema' => [PageController::faqSchema($faqs)],
        ];

        return view('welcome', compact(
            'vehicles',
            'packages',
            'reviews',
            'banner',
            'blogs',
            'heroBanners',
            'destinations',
            'taxiRoutes',
            'faqs',
            'seo'
        ));
    }

    /**
     * Store Booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_type'    => 'required|string|max:50',
            'customer_name'   => 'required|string|max:100',
            'customer_phone'  => 'required|string|max:20',
            'travel_date'     => 'required|date',
            'pickup_location' => 'required|string|max:255',
            'drop_location'   => 'nullable|string|max:255',
            'vehicle_id'      => 'nullable|exists:vehicles,id',
            'package_id'      => 'nullable|exists:packages,id',
        ]);

        /*
         * Generate unique booking reference.
         */
        $validated['booking_code'] = 'DT-' . strtoupper(Str::random(6));

        $validated['status'] = 'pending';

        /*
         * Calculate estimated fare.
         */
        $fare = 0;

        if (!empty($validated['package_id'])) {
            $package = Package::find($validated['package_id']);

            $fare = $package
                ? $package->starting_price
                : 0;
        } elseif (!empty($validated['vehicle_id'])) {
            $vehicle = Vehicle::find($validated['vehicle_id']);

            $fare = $vehicle
                ? $vehicle->base_fare
                : 0;
        } else {
            $fare = 1500;
        }

        $validated['estimated_fare'] = $fare;

        /*
         * Create booking.
         */
        $booking = Booking::create($validated);

        \App\Support\AdminNotifier::booking($booking);

        return back()->with([
            'booking_success' => true,
            'booking_code'    => $booking->booking_code,
            'customer_name'   => $booking->customer_name,
            'travel_date'     => $booking->travel_date,
        ]);
    }

    /**
     * Dedicated Cabs Listing Page
     */
    public function cabsPage()
    {
        $vehicles = Vehicle::where('is_active', true)
            ->orderBy('seating_capacity')
            ->orderBy('name')
            ->get();

        $faqs = [
            ['Which cab is best for hill roads?',
                'For families or anyone with more luggage, the Toyota Innova Crysta is the most comfortable on mountain roads. Sedans like the Swift Dzire or Etios are ideal for couples and short local trips.'],
            ['Are your drivers experienced on mountain roads?',
                'Yes. Our drivers are locals who drive the Kangra Valley and the roads to Manali, Dalhousie and Shimla every week.'],
            ['Can I book a cab for multiple days?',
                'Yes. You can book a cab and driver for a full day, several days or an entire Himachal tour — the same driver stays with you throughout.'],
            ['Is advance payment required to book?',
                'No advance payment is needed to send a booking request. Our travel desk calls you to confirm the cab and pickup details.'],
        ];

        $seo = [
            'title'       => 'Book a Cab in Dharamshala — Sedan, Innova Crysta & Tempo Traveller',
            'description' => 'Book clean, AC cabs in Dharamshala and McLeodganj with experienced hill drivers: Swift Dzire, Etios, Toyota Innova Crysta and 12-seater Tempo Traveller for airport, local and outstation trips.',
            'keywords'    => 'cab in dharamshala, taxi booking dharamshala, innova crysta dharamshala, tempo traveller dharamshala, mcleodganj cab',
            'image'       => '/images/dharamshala/car-innova-crysta.jpg',
            'breadcrumbs' => ['Book a Cab' => route('cabs.index')],
            'schema'      => [PageController::faqSchema($faqs)],
        ];

        return view('cabs.index', compact('vehicles', 'faqs', 'seo'));
    }

    /**
     * Dedicated Tour Packages Page
     */
    public function toursPage()
    {
        $packages = Package::latest()
            ->paginate(12);

        $faqs = [
            ['Are these tours private?',
                'Yes. Every package is a private tour with a dedicated cab and driver for your group only — no shared buses or fixed group departures.'],
            ['Can I customise an itinerary?',
                'Absolutely. Add or remove days, change hotels or combine packages — tell us what you would like and our travel desk will plan it with you.'],
            ['Which cab will we travel in?',
                'Choose a sedan (Swift Dzire / Etios) for up to 4 people, a Toyota Innova Crysta for families, or a 12-seater Tempo Traveller for groups.'],
            ['Do I need to pay to send an enquiry?',
                'No. Sending an enquiry is free — our team calls you to confirm dates, cab and itinerary details before anything is booked.'],
        ];

        $seo = [
            'title'       => 'Himachal Tour Packages from Dharamshala — Private Cab Tours & Treks',
            'description' => 'Private Himachal tour packages from Dharamshala: McLeodganj sightseeing, Triund & Kareri treks, Kangra Valley heritage, Bir Billing, Dalhousie, Khajjiar and Manali circuits.',
            'keywords'    => 'himachal tour packages, dharamshala tour packages, mcleodganj tour package, triund trek package, dalhousie khajjiar tour, dharamshala manali tour',
            'image'       => '/images/dharamshala/kangra-tea-garden.jpg',
            'breadcrumbs' => ['Tour Packages' => route('tours.index')],
            'schema'      => [
                [
                    '@type'           => 'ItemList',
                    'name'            => 'Himachal tour packages from Dharamshala',
                    'itemListElement' => $packages->getCollection()->values()->map(fn ($p, $i) => [
                        '@type'    => 'ListItem',
                        'position' => $i + 1,
                        'url'      => route('tours.show', $p->slug),
                        'name'     => $p->title,
                    ])->all(),
                ],
                PageController::faqSchema($faqs),
            ],
        ];

        return view('tours.index', compact('packages', 'faqs', 'seo'));
    }

    /**
     * Dedicated Reviews Page
     */
    public function reviewsPage()
    {
        $reviews = Review::where('is_approved', true)
            ->latest()
            ->paginate(12);

        return view('reviews.index', compact('reviews'));
    }
}