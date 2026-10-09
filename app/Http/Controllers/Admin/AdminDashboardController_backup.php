<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Package;
use App\Models\Vehicle;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'total_revenue' => Booking::whereIn(
                'status',
                ['confirmed', 'completed']
            )->sum('estimated_fare'),
            'active_fleet' => Vehicle::where('is_active', true)->count(),
            'total_packages' => Package::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // ==========================================
    // Dedicated Admin Pages
    // ==========================================

    public function bookings(Request $request)
    {
        $query = Booking::with(['vehicle', 'package'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $bookings = $query->paginate(15)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function vehicles()
    {
        $vehicles = Vehicle::latest()->get();

        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function tours()
    {
        $packages = Package::latest()->get();

        return view('admin.tours.index', compact('packages'));
    }

    // ==========================================
    // Separate Settings Pages
    // ==========================================

    public function topAnnouncement()
    {
        $announcement = [
            'top_bar_text' => Setting::get(
                'top_bar_text',
                'Gaggal Airport (DHM) & Himachal Tour Chauffeur Network'
            ),
            'top_bar_phone' => Setting::get(
                'top_bar_phone',
                '+91 98765 43210'
            ),
            'top_bar_location' => Setting::get(
                'top_bar_location',
                'Dharamshala, HP'
            ),
        ];

        return view(
            'admin.top-announcement',
            compact('announcement')
        );
    }

    public function updateTopAnnouncement(Request $request)
    {
        $validated = $request->validate([
            'top_bar_text' => 'nullable|string|max:255',
            'top_bar_phone' => 'nullable|string|max:50',
            'top_bar_location' => 'nullable|string|max:100',
        ]);

        Setting::set(
            'top_bar_text',
            $validated['top_bar_text']
                ?? 'Gaggal Airport (DHM) & Himachal Tour Chauffeur Network'
        );

        Setting::set(
            'top_bar_phone',
            $validated['top_bar_phone']
                ?? '+91 98765 43210'
        );

        Setting::set(
            'top_bar_location',
            $validated['top_bar_location']
                ?? 'Dharamshala, HP'
        );

        return back()->with(
            'success',
            'Top Announcement Bar updated successfully!'
        );
    }

    public function logoFavicon()
    {
        $branding = [
            'site_logo' => Setting::get('site_logo', ''),
            'site_favicon' => Setting::get('site_favicon', ''),
        ];

        return view(
            'admin.logo-favicon',
            compact('branding')
        );
    }

    public function updateLogoFavicon(Request $request)
    {
        $request->validate([
            'site_logo' => 'nullable|url',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'site_favicon' => 'nullable|url',
            'favicon_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,ico,svg|max:1024',
        ]);

        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')
                ->store('branding', 'public');

            Setting::set(
                'site_logo',
                asset('storage/' . $path)
            );
        } elseif ($request->filled('site_logo')) {
            Setting::set(
                'site_logo',
                $request->site_logo
            );
        }

        if ($request->hasFile('favicon_file')) {
            $path = $request->file('favicon_file')
                ->store('branding', 'public');

            Setting::set(
                'site_favicon',
                asset('storage/' . $path)
            );
        } elseif ($request->filled('site_favicon')) {
            Setting::set(
                'site_favicon',
                $request->site_favicon
            );
        }

        return back()->with(
            'success',
            'Logo & Favicon updated successfully!'
        );
    }

    public function contactInformation()
    {
        $contact = [
            'contact_phone' => Setting::get(
                'contact_phone',
                '+91 98765 43210'
            ),
            'contact_hours' => Setting::get(
                'contact_hours',
                'Available 6:00 AM – 11:00 PM'
            ),
            'contact_address' => Setting::get(
                'contact_address',
                'Main Taxi Stand, Kotwali Bazar, Dharamshala, Himachal Pradesh 176215'
            ),
        ];

        return view(
            'admin.contact',
            compact('contact')
        );
    }

    public function updateContactInformation(Request $request)
    {
        $validated = $request->validate([
            'contact_phone' => 'nullable|string|max:50',
            'contact_hours' => 'nullable|string|max:100',
            'contact_address' => 'nullable|string|max:500',
        ]);

        Setting::set(
            'contact_phone',
            $validated['contact_phone']
                ?? '+91 98765 43210'
        );

        Setting::set(
            'contact_hours',
            $validated['contact_hours']
                ?? 'Available 6:00 AM – 11:00 PM'
        );

        Setting::set(
            'contact_address',
            $validated['contact_address']
                ?? 'Main Taxi Stand, Kotwali Bazar, Dharamshala, Himachal Pradesh 176215'
        );

        return back()->with(
            'success',
            'Basic Contact Information updated successfully!'
        );
    }

    public function emailDesk()
    {
        $email = [
            'contact_email' => Setting::get(
                'contact_email',
                'info@dharamshalatravels.com'
            ),
            'contact_email_response' => Setting::get(
                'contact_email_response',
                'Response within 2 hours'
            ),
        ];

        return view(
            'admin.email-desk',
            compact('email')
        );
    }

    public function updateEmailDesk(Request $request)
    {
        $validated = $request->validate([
            'contact_email' => 'nullable|email|max:100',
            'contact_email_response' => 'nullable|string|max:100',
        ]);

        Setting::set(
            'contact_email',
            $validated['contact_email']
                ?? 'info@dharamshalatravels.com'
        );

        Setting::set(
            'contact_email_response',
            $validated['contact_email_response']
                ?? 'Response within 2 hours'
        );

        return back()->with(
            'success',
            'Email Desk updated successfully!'
        );
    }

    // ==========================================
    // Bookings Management
    // ==========================================

    public function updateBookingStatus(
        Request $request,
        Booking $booking
    ) {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $booking->update($validated);

        return back()->with(
            'success',
            "Booking {$booking->booking_code} marked as "
                . ucfirst($validated['status'])
        );
    }

    public function deleteBooking(Booking $booking)
    {
        $code = $booking->booking_code;

        $booking->delete();

        return back()->with(
            'success',
            "Booking {$code} has been deleted."
        );
    }

    // ==========================================
    // Vehicles Fleet Management
    // ==========================================

    public function storeVehicle(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string|max:50',
            'badge' => 'nullable|string|max:50',
            'base_fare' => 'required|numeric|min:0',
            'rate_per_km' => 'required|numeric|min:0',
            'seating_capacity' => 'required|integer|min:1',
            'luggage_capacity' => 'required|integer|min:0',
            'image' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')
                ->store('vehicles', 'public');

            $validated['image'] = asset(
                'storage/' . $path
            );
        }

        if (empty($validated['image'])) {
            return back()->withErrors([
                'image' =>
                'Please provide an Image URL or upload an image file.'
            ]);
        }

        $gallery = [];

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $photo) {
                $storedPath = $photo->store(
                    'vehicles/gallery',
                    'public'
                );

                $gallery[] = asset(
                    'storage/' . $storedPath
                );
            }
        }

        $validated['gallery'] = $gallery;

        unset($validated['image_file']);

        $validated['is_active'] = true;

        Vehicle::create($validated);

        return back()->with(
            'success',
            "Vehicle {$validated['name']} added to fleet."
        );
    }

    public function editVehicle(Vehicle $vehicle)
    {
        return view(
            'admin.vehicles.edit',
            compact('vehicle')
        );
    }

    public function updateVehicle(
        Request $request,
        Vehicle $vehicle
    ) {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string|max:50',
            'badge' => 'nullable|string|max:50',
            'base_fare' => 'required|numeric|min:0',
            'rate_per_km' => 'required|numeric|min:0',
            'seating_capacity' => 'required|integer|min:1',
            'luggage_capacity' => 'required|integer|min:0',
            'image' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')
                ->store('vehicles', 'public');

            $validated['image'] = asset(
                'storage/' . $path
            );
        }

        if ($request->hasFile('gallery')) {
            $gallery = $vehicle->gallery ?? [];

            foreach ($request->file('gallery') as $photo) {
                $storedPath = $photo->store(
                    'vehicles/gallery',
                    'public'
                );

                $gallery[] = asset(
                    'storage/' . $storedPath
                );
            }

            $validated['gallery'] = array_values(
                array_unique($gallery)
            );
        }

        unset($validated['image_file']);

        $vehicle->update($validated);

        return redirect()
            ->route('admin.vehicles.index')
            ->with(
                'success',
                "Vehicle {$vehicle->name} updated successfully."
            );
    }

    public function deleteVehicle(Vehicle $vehicle)
    {
        $name = $vehicle->name;

        $vehicle->delete();

        return back()->with(
            'success',
            "Vehicle {$name} removed from fleet."
        );
    }

    /**
     * Delete individual interior/gallery photo
     * from storage and database.
     */
    public function deleteGalleryImage(
        Request $request,
        Vehicle $vehicle
    ) {
        $request->validate([
            'image_url' => 'required|string',
        ]);

        $targetImage = $request->input('image_url');

        $currentGallery = $vehicle->gallery ?? [];

        $updatedGallery = array_values(
            array_filter(
                $currentGallery,
                function ($img) use ($targetImage) {
                    return $img !== $targetImage;
                }
            )
        );

        $relativePath = str_replace(
            asset('storage') . '/',
            '',
            $targetImage
        );

        $relativePath = str_replace(
            '/storage/',
            '',
            $relativePath
        );

        if (
            Storage::disk('public')
            ->exists($relativePath)
        ) {
            Storage::disk('public')
                ->delete($relativePath);
        }

        $vehicle->update([
            'gallery' => $updatedGallery
        ]);

        return back()->with(
            'success',
            'Interior photo removed successfully.'
        );
    }

    // ==========================================
    // Tour Packages Management
    // ==========================================

    public function storePackage(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:150',
            'duration'       => 'required|string|max:50',
            'starting_price' => 'required|numeric|min:0',
            'short_desc'     => 'required|string|max:255',
            'itinerary'      => 'nullable|string',
            'inclusions'     => 'nullable',

            'thumbnail'      => 'nullable|url',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',

            'image_2'        => 'nullable|url',
            'image_2_file'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',

            'image_3'        => 'nullable|url',
            'image_3_file'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',

            'image_4'        => 'nullable|url',
            'image_4_file'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',

            'image_5'        => 'nullable|url',
            'image_5_file'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        // Main Thumbnail
        if ($request->hasFile('thumbnail_file')) {
            $path = $request->file('thumbnail_file')
                ->store('packages', 'public');

            $validated['thumbnail'] = asset(
                'storage/' . $path
            );
        }

        if (empty($validated['thumbnail'])) {
            return back()->withErrors([
                'thumbnail' =>
                'Please provide a Thumbnail URL or upload an image file.'
            ]);
        }

        unset($validated['thumbnail_file']);

        // Additional Gallery Images
        foreach (['image_2', 'image_3', 'image_4', 'image_5'] as $field) {

            $fileField = $field . '_file';

            if ($request->hasFile($fileField)) {

                $path = $request->file($fileField)
                    ->store('packages/gallery', 'public');

                $validated[$field] = asset(
                    'storage/' . $path
                );
            }

            unset($validated[$fileField]);
        }

        $validated['itinerary'] =
            $validated['itinerary']
            ?? $validated['short_desc'];

        $validated['inclusions'] =
            $validated['inclusions']
            ?? json_encode([
                'Dedicated Sanitized Cab',
                'Verified Mountain Driver',
                'Fuel & Parking Included'
            ]);

        $validated['slug'] =
            Str::slug($validated['title'])
            . '-'
            . Str::random(4);

        $validated['rating'] = 5.0;
        $validated['reviews_count'] = 1;
        $validated['is_featured'] = true;

        Package::create($validated);

        return back()->with(
            'success',
            "Tour package {$validated['title']} published."
        );
    }

    public function editPackage(Package $package)
    {
        return view(
            'admin.packages.edit',
            compact('package')
        );
    }

    public function updatePackage(
        Request $request,
        Package $package
    ) {
        $validated = $request->validate([
            'title'          => 'required|string|max:150',
            'duration'       => 'required|string|max:50',
            'starting_price' => 'required|numeric|min:0',
            'short_desc'     => 'required|string|max:255',
            'itinerary'      => 'nullable|string',
            'inclusions'     => 'nullable',

            'thumbnail'      => 'nullable|url',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',

            'image_2'        => 'nullable|url',
            'image_2_file'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',

            'image_3'        => 'nullable|url',
            'image_3_file'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',

            'image_4'        => 'nullable|url',
            'image_4_file'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',

            'image_5'        => 'nullable|url',
            'image_5_file'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        // Main Thumbnail
        if ($request->hasFile('thumbnail_file')) {

            $path = $request->file('thumbnail_file')
                ->store('packages', 'public');

            $validated['thumbnail'] = asset(
                'storage/' . $path
            );
        }

        unset($validated['thumbnail_file']);

        // Additional Gallery Images
        foreach (['image_2', 'image_3', 'image_4', 'image_5'] as $field) {

            $fileField = $field . '_file';

            if ($request->hasFile($fileField)) {

                $path = $request->file($fileField)
                    ->store('packages/gallery', 'public');

                $validated[$field] = asset(
                    'storage/' . $path
                );
            } elseif (!$request->filled($field)) {

                // Existing image ko blank field ki wajah se delete nahi karna
                unset($validated[$field]);
            }

            unset($validated[$fileField]);
        }

        $validated['itinerary'] =
            $validated['itinerary']
            ?? $validated['short_desc'];

        if (
            isset($validated['inclusions']) &&
            is_array($validated['inclusions'])
        ) {
            $validated['inclusions'] =
                json_encode($validated['inclusions']);
        }

        $package->update($validated);

        return redirect()
            ->route('admin.tours.index')
            ->with(
                'success',
                "Package {$package->title} updated successfully."
            );
    }

    public function deletePackage(Package $package)
    {
        $title = $package->title;

        $package->delete();

        return back()->with(
            'success',
            "Package {$title} removed."
        );
    }
   // ==========================================
// Hero Banner Settings
// ==========================================

public function banner()
{
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

    $banners = \App\Models\HeroBanner::orderBy('sort_order')
        ->orderBy('id')
        ->get();

    return view(
        'admin.banner',
        compact('banner', 'banners')
    );
}

public function updateBanner(Request $request)
{
    $request->validate([
        'hero_title' => 'required|string|max:200',
        'hero_subtitle' => 'required|string|max:500',
        'hero_banner_image' => 'nullable|url',
        'banner_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
    ]);

    if ($request->hasFile('banner_file')) {
        $path = $request->file('banner_file')
            ->store('banners', 'public');

        Setting::set(
            'hero_banner_image',
            asset('storage/' . $path)
        );
    } elseif ($request->filled('hero_banner_image')) {
        Setting::set(
            'hero_banner_image',
            $request->hero_banner_image
        );
    }

    Setting::set(
        'hero_title',
        $request->hero_title
    );

    Setting::set(
        'hero_subtitle',
        $request->hero_subtitle
    );

    return back()->with(
        'success',
        'Hero Banner settings updated successfully!'
    );
}

    // ==========================================
    // Basic Settings
    // SEO, Branding & Contact Page
    // ==========================================

    public function settings()
    {
        $settings = [

            // SEO
            'meta_title' => Setting::get(
                'meta_title',
                'Dharamshala Travels — Premier Mountain Mobility & Cab Services'
            ),

            'meta_description' => Setting::get(
                'meta_description',
                'Book verified taxi services in Dharamshala, Gaggal Airport transfers, McLeodganj sightseeing, and customized Himachal holiday tours.'
            ),

            'meta_keywords' => Setting::get(
                'meta_keywords',
                'taxi in dharamshala, gaggal airport cab, mcleodganj taxi booking, himachal tours'
            ),

            'meta_robots' => Setting::get('meta_robots', 'index,follow'),

            'og_title' => Setting::get('og_title', ''),
            'og_description' => Setting::get('og_description', ''),
            'og_image' => Setting::get('og_image', ''),

            'twitter_card' => Setting::get('twitter_card', 'summary_large_image'),
            'twitter_title' => Setting::get('twitter_title', ''),
            'twitter_description' => Setting::get('twitter_description', ''),
            'twitter_image' => Setting::get('twitter_image', ''),

            'seo_schema_enabled' => Setting::get('seo_schema_enabled', '1'),

            'seo_business_name' => Setting::get('seo_business_name', 'Dharamshala Travels'),
            'seo_business_logo' => Setting::get('seo_business_logo', ''),
            'seo_business_phone' => Setting::get('seo_business_phone', '+91 98765 43210'),
            'seo_business_email' => Setting::get('seo_business_email', 'info@dharamshalatravels.com'),
            'seo_business_address' => Setting::get(
                'seo_business_address',
                'Dharamshala, Himachal Pradesh, India'
            ),

            'seo_latitude' => Setting::get('seo_latitude', ''),
            'seo_longitude' => Setting::get('seo_longitude', ''),

            'seo_opening_hours' => Setting::get(
                'seo_opening_hours',
                'Mo-Su 06:00-23:00'
            ),

            'seo_price_range' => Setting::get('seo_price_range', '₹₹'),

            'seo_service_areas' => Setting::get(
                'seo_service_areas',
                'Dharamshala, McLeodganj, Kangra, Himachal Pradesh'
            ),

            'google_site_verification' => Setting::get(
                'google_site_verification',
                ''
            ),

            'google_analytics_id' => Setting::get(
                'google_analytics_id',
                ''
            ),

            // Branding
            'site_logo' => Setting::get(
                'site_logo',
                ''
            ),

            'site_favicon' => Setting::get(
                'site_favicon',
                ''
            ),

            'site_title' => Setting::get(
                'site_title',
                'Dharamshala Travels'
            ),

            'site_phone' => Setting::get(
                'site_phone',
                '+91 98765 43210'
            ),

            'site_email' => Setting::get(
                'site_email',
                'info@dharamshalatravels.com'
            ),

            'site_address' => Setting::get(
                'site_address',
                'Main Square, McLeodganj'
            ),

            // Contact
            'contact_subtitle' => Setting::get(
                'contact_subtitle',
                'Official Himachal Pradesh taxi and tour mobility operations center.'
            ),

            'contact_phone' => Setting::get(
                'contact_phone',
                '+91 98765 43210'
            ),

            'contact_hours' => Setting::get(
                'contact_hours',
                'Available 6:00 AM – 11:00 PM'
            ),

            'contact_email' => Setting::get(
                'contact_email',
                'info@dharamshalatravels.com'
            ),

            'contact_email_response' => Setting::get(
                'contact_email_response',
                'Response within 2 hours'
            ),

            'contact_address' => Setting::get(
                'contact_address',
                'Main Taxi Stand, Kotwali Bazar, Dharamshala, Himachal Pradesh 176215'
            ),

            'contact_guarantee_title' => Setting::get(
                'contact_guarantee_title',
                'Transparent Rates Guarantee'
            ),

            'contact_guarantee_desc' => Setting::get(
                'contact_guarantee_desc',
                'No hidden hill surcharges, permit fees, or toll taxes. Instant dispatch for Gaggal Airport transfers.'
            ),

            // ==========================================
            // FOOTER SETTINGS
            // ==========================================

            'footer_description' => Setting::get(
                'footer_description',
                'Reliable cab services, airport transfers and Himachal tour packages from Dharamshala. Travel comfortably with experienced local drivers.'
            ),

            'footer_facebook' => Setting::get(
                'footer_facebook',
                ''
            ),

            'footer_instagram' => Setting::get(
                'footer_instagram',
                ''
            ),

            'footer_youtube' => Setting::get(
                'footer_youtube',
                ''
            ),

            'footer_whatsapp' => Setting::get(
                'footer_whatsapp',
                ''
            ),

            'footer_map_url' => Setting::get(
                'footer_map_url',
                ''
            ),
        ];

        return view(
            'admin.settings',
            compact('settings')
        );
    }

    public function updateSettings(Request $request)
    {
        $request->validate([

            // SEO
            // SEO
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:500',

            'meta_robots' => 'nullable|in:index,follow,index,nofollow,noindex,follow,noindex,nofollow',

            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:160',
            'og_image' => 'nullable|url|max:1000',

            'twitter_card' => 'nullable|in:summary,summary_large_image',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:160',
            'twitter_image' => 'nullable|url|max:1000',

            'seo_schema_enabled' => 'nullable|boolean',

            'seo_business_name' => 'nullable|string|max:255',
            'seo_business_logo' => 'nullable|url|max:1000',
            'seo_business_phone' => 'nullable|string|max:50',
            'seo_business_email' => 'nullable|email|max:100',
            'seo_business_address' => 'nullable|string|max:500',

            'seo_latitude' => 'nullable|numeric|between:-90,90',
            'seo_longitude' => 'nullable|numeric|between:-180,180',

            'seo_opening_hours' => 'nullable|string|max:1000',
            'seo_price_range' => 'nullable|string|max:20',
            'seo_service_areas' => 'nullable|string|max:1000',

            'google_site_verification' => 'nullable|string|max:255',
            'google_analytics_id' => 'nullable|string|max:100',
            // Business Information
            'site_title' => 'nullable|string|max:255',
            'site_phone' => 'nullable|string|max:50',
            'site_email' => 'nullable|email|max:100',
            'site_address' => 'nullable|string|max:500',

            // Branding
            'site_logo' => 'nullable|url',
            'site_favicon' => 'nullable|url',

            'logo_file' =>
            'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',

            'favicon_file' =>
            'nullable|image|mimes:jpeg,png,jpg,webp,ico,svg|max:1024',

            // Contact
            'contact_subtitle' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_hours' => 'nullable|string|max:100',
            'contact_email' => 'nullable|email|max:100',
            'contact_email_response' => 'nullable|string|max:100',
            'contact_address' => 'nullable|string|max:500',
            'contact_guarantee_title' => 'nullable|string|max:100',
            'contact_guarantee_desc' => 'nullable|string|max:500',

            // Footer
            'footer_description' => 'nullable|string|max:500',
            'footer_facebook' => 'nullable|url|max:500',
            'footer_instagram' => 'nullable|url|max:500',
            'footer_youtube' => 'nullable|url|max:500',
            'footer_whatsapp' => 'nullable|string|max:30',
            'footer_map_url' => 'nullable|url|max:1000',
        ]);

        // ==========================================
        // Logo File / URL
        // ==========================================

        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')
                ->store('branding', 'public');

            Setting::set(
                'site_logo',
                asset('storage/' . $path)
            );
        } elseif ($request->filled('site_logo')) {
            Setting::set(
                'site_logo',
                $request->site_logo
            );
        }

        // ==========================================
        // Favicon File / URL
        // ==========================================

        if ($request->hasFile('favicon_file')) {
            $path = $request->file('favicon_file')
                ->store('branding', 'public');

            Setting::set(
                'site_favicon',
                asset('storage/' . $path)
            );
        } elseif ($request->filled('site_favicon')) {
            Setting::set(
                'site_favicon',
                $request->site_favicon
            );
        }

        // ==========================================
        // SEO Fields
        // ==========================================

        Setting::set(
            'meta_title',
            $request->meta_title
        );

        Setting::set(
            'meta_description',
            $request->meta_description
        );

        Setting::set(
            'meta_keywords',
            $request->meta_keywords
        );

        Setting::set(
            'meta_robots',
            $request->input('meta_robots') ?: 'index,follow'
        );

        Setting::set(
            'og_title',
            $request->input('og_title')
        );

        Setting::set(
            'og_description',
            $request->input('og_description')
        );

        Setting::set(
            'og_image',
            $request->input('og_image')
        );

        Setting::set(
            'twitter_card',
            $request->input('twitter_card') ?: 'summary_large_image'
        );

        Setting::set(
            'twitter_title',
            $request->input('twitter_title')
        );

        Setting::set(
            'twitter_description',
            $request->input('twitter_description')
        );

        Setting::set(
            'twitter_image',
            $request->input('twitter_image')
        );

        Setting::set(
            'seo_schema_enabled',
            $request->boolean('seo_schema_enabled') ? '1' : '0'
        );

        Setting::set(
            'seo_business_name',
            $request->input('seo_business_name') ?: 'Dharamshala Travels'
        );

        Setting::set(
            'seo_business_logo',
            $request->input('seo_business_logo')
        );

        Setting::set(
            'seo_business_phone',
            $request->input('seo_business_phone')
        );

        Setting::set(
            'seo_business_email',
            $request->input('seo_business_email')
        );

        Setting::set(
            'seo_business_address',
            $request->input('seo_business_address')
        );

        Setting::set(
            'seo_latitude',
            $request->input('seo_latitude')
        );

        Setting::set(
            'seo_longitude',
            $request->input('seo_longitude')
        );

        Setting::set(
            'seo_opening_hours',
            $request->input('seo_opening_hours')
        );

        Setting::set(
            'seo_price_range',
            $request->input('seo_price_range')
        );

        Setting::set(
            'seo_service_areas',
            $request->input('seo_service_areas')
        );

        Setting::set(
            'google_site_verification',
            $request->input('google_site_verification')
        );

        Setting::set(
            'google_analytics_id',
            $request->input('google_analytics_id')
        );
        // ==========================================
        // Business Information
        // ==========================================

        Setting::set(
            'site_title',
            $request->input('site_title')
                ?: 'Dharamshala Travels'
        );

        Setting::set(
            'site_phone',
            $request->input('site_phone')
                ?: '+91 98765 43210'
        );

        Setting::set(
            'site_email',
            $request->input('site_email')
                ?: 'info@dharamshalatravels.com'
        );

        Setting::set(
            'site_address',
            $request->input('site_address')
                ?: 'Main Square, McLeodganj'
        );

        // ==========================================
        // Contact Page Details
        // ==========================================

        Setting::set(
            'contact_subtitle',
            $request->input('contact_subtitle')
                ?: 'Official Himachal Pradesh taxi and tour mobility operations center.'
        );

        Setting::set(
            'contact_phone',
            $request->input('contact_phone')
                ?: '+91 98765 43210'
        );

        Setting::set(
            'contact_hours',
            $request->input('contact_hours')
                ?: 'Available 6:00 AM – 11:00 PM'
        );

        Setting::set(
            'contact_email',
            $request->input('contact_email')
                ?: 'info@dharamshalatravels.com'
        );

        Setting::set(
            'contact_email_response',
            $request->input('contact_email_response')
                ?: 'Response within 2 hours'
        );

        Setting::set(
            'contact_address',
            $request->input('contact_address')
                ?: 'Main Taxi Stand, Kotwali Bazar, Dharamshala, Himachal Pradesh 176215'
        );

        Setting::set(
            'contact_guarantee_title',
            $request->input('contact_guarantee_title')
                ?: 'Transparent Rates Guarantee'
        );

        Setting::set(
            'contact_guarantee_desc',
            $request->input('contact_guarantee_desc')
                ?: 'No hidden hill surcharges, permit fees, or toll taxes. Instant dispatch for Gaggal Airport transfers.'
        );

        // ==========================================
        // Footer Settings
        // ==========================================

        Setting::set(
            'footer_description',
            $request->input('footer_description')
                ?: 'Reliable cab services, airport transfers and Himachal tour packages from Dharamshala. Travel comfortably with experienced local drivers.'
        );

        Setting::set(
            'footer_facebook',
            $request->input('footer_facebook')
        );

        Setting::set(
            'footer_instagram',
            $request->input('footer_instagram')
        );

        Setting::set(
            'footer_youtube',
            $request->input('footer_youtube')
        );

        Setting::set(
            'footer_whatsapp',
            $request->input('footer_whatsapp')
        );

        Setting::set(
            'footer_map_url',
            $request->input('footer_map_url')
        );

        return back()->with(
            'success',
            'Settings updated successfully!'
        );
    }
}
