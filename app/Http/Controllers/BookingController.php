<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\Vehicle;
use App\Models\Setting;
use App\Models\Review;
use App\Models\Blog;
use Illuminate\Http\Request;
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

        return view('welcome', compact(
            'vehicles',
            'packages',
            'reviews',
            'banner',
            'blogs'
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
            ->latest()
            ->get();

        return view('cabs.index', compact('vehicles'));
    }

    /**
     * Dedicated Tour Packages Page
     */
    public function toursPage()
    {
        $packages = Package::latest()
            ->paginate(9);

        return view('tours.index', compact('packages'));
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