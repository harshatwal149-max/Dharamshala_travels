<?php



use Illuminate\Support\Facades\Route;



use App\Http\Controllers\BookingController;

use App\Http\Controllers\Admin\AdminDashboardController;

use App\Http\Controllers\Admin\AdminAuthController;

use App\Http\Controllers\ReviewController;



use App\Models\Vehicle;

use App\Models\Package;

use App\Models\Blog;



use App\Http\Controllers\ContactController;

use App\Http\Controllers\PageController;

use App\Models\Destination;

use App\Models\TaxiRoute;

use App\Http\Controllers\Admin\EnquiryController as AdminEnquiryController;

use App\Http\Controllers\Admin\HeroBannerController;

use App\Http\Controllers\Admin\BlogController;





/*

|--------------------------------------------------------------------------

| Public Client Routes

|--------------------------------------------------------------------------

*/





/*

|--------------------------------------------------------------------------

| Home

|--------------------------------------------------------------------------

*/



Route::get('/', [BookingController::class, 'index'])

    ->name('home');





/*

|--------------------------------------------------------------------------

| Booking

|--------------------------------------------------------------------------

*/



Route::post('/bookings', [BookingController::class, 'store'])

    ->name('bookings.store');





/*

|--------------------------------------------------------------------------

| Reviews Submission

|--------------------------------------------------------------------------

|

| Review page navigation removed.

| Review submission is kept so existing homepage functionality

| does not break.

|

*/



Route::get('/reviews', [

    ReviewController::class,

    'index'

])->name('reviews.index');



Route::post('/reviews', [ReviewController::class, 'store'])

    ->name('reviews.store');





/*

|--------------------------------------------------------------------------

| Contact & Enquiry Routes

|--------------------------------------------------------------------------

*/



Route::get('/contact', [ContactController::class, 'index'])

    ->name('contact');



Route::post('/contact', [ContactController::class, 'store'])

    ->name('contact.store');





/*

|--------------------------------------------------------------------------

| Public Blog Routes

|--------------------------------------------------------------------------

|

| IMPORTANT:

| This is the public /blogs page.

| Admin blogs remain available at /admin/blogs.

|

*/



Route::get('/blogs', function () {



    $blogs = \App\Models\Blog::query()
        ->latest('blog_date')
        ->latest('id')
        ->paginate(10);

    $seo = [
        'title'       => 'Dharamshala Travel Blog — Guides, Treks & Travel Tips',
        'description' => 'Travel guides for Dharamshala, McLeodganj and the Kangra Valley: places to visit, how to reach, Triund trek tips, the best time to visit and Bir Billing paragliding.',
        'keywords'    => 'dharamshala travel blog, mcleodganj travel guide, triund trek guide, best time to visit dharamshala, how to reach dharamshala',
        'image'       => '/images/dharamshala/mcleodganj-view.jpg',
        'breadcrumbs' => ['Blog' => route('blogs.public')],
        'schema'      => [[
            '@type'    => 'Blog',
            'name'     => 'Dharamshala Travels Blog',
            'url'      => route('blogs.public'),
            'blogPost' => $blogs->getCollection()->map(fn ($b) => [
                '@type'         => 'BlogPosting',
                'headline'      => \Illuminate\Support\Str::limit($b->title, 110, ''),
                'url'           => route('blogs.show', $b->slug),
                'datePublished' => optional($b->blog_date)->toDateString(),
            ])->all(),
        ]],
    ];

    return view('blogs.index', compact('blogs', 'seo'));
})->name('blogs.public');





Route::get('/blogs/{slug}', function ($slug) {



    $blog = \App\Models\Blog::where('slug', $slug)->firstOrFail();

    $related = \App\Models\Blog::where('id', '!=', $blog->id)
        ->whereNotNull('image')
        ->latest('blog_date')
        ->latest('id')
        ->take(3)
        ->get();

    $plain = trim(preg_replace('/\s+/', ' ', strip_tags($blog->description ?? '')));
    $image = \App\Support\Media::url($blog->image);

    $seo = [
        'title'       => $blog->title . ' | Dharamshala Travels',
        'description' => \Illuminate\Support\Str::limit($plain, 158),
        'image'       => $blog->image,
        'type'        => 'article',
        'breadcrumbs' => [
            'Blog'      => route('blogs.public'),
            $blog->title => route('blogs.show', $blog->slug),
        ],
        'schema'      => [array_filter([
            '@type'            => 'BlogPosting',
            'headline'         => \Illuminate\Support\Str::limit($blog->title, 110, ''),
            'description'      => \Illuminate\Support\Str::limit($plain, 200),
            'image'            => $image,
            'datePublished'    => optional($blog->blog_date ?? $blog->created_at)->toDateString(),
            'dateModified'     => optional($blog->updated_at)->toAtomString(),
            'wordCount'        => str_word_count($plain),
            'mainEntityOfPage' => route('blogs.show', $blog->slug),
            'author'           => ['@type' => 'Organization', 'name' => \App\Models\Setting::get('site_title') ?: 'Dharamshala Travels', 'url' => url('/')],
            'publisher'        => ['@type' => 'Organization', 'name' => \App\Models\Setting::get('site_title') ?: 'Dharamshala Travels', 'url' => url('/')],
        ])],
    ];

    return view('blogs.show', compact('blog', 'related', 'seo'));
})->name('blogs.show');





/*

|--------------------------------------------------------------------------

| Dedicated Standalone Pages

|--------------------------------------------------------------------------

*/





/*

|--------------------------------------------------------------------------

| Book Cab

|--------------------------------------------------------------------------

*/



Route::get('/cabs', [BookingController::class, 'cabsPage'])

    ->name('cabs.index');





/*

|--------------------------------------------------------------------------

| Tour Packages

|--------------------------------------------------------------------------

*/



Route::get('/tours', [BookingController::class, 'toursPage'])

    ->name('tours.index');





/*
|--------------------------------------------------------------------------
| Destinations, Taxi Routes & Info Pages
|--------------------------------------------------------------------------
*/

Route::get('/destinations', [PageController::class, 'destinations'])
    ->name('destinations.index');

Route::get('/destinations/{destination}', [PageController::class, 'destination'])
    ->name('destinations.show');

Route::get('/taxi-routes', [PageController::class, 'taxiRoutes'])
    ->name('taxi-routes.index');

Route::get('/taxi-routes/{taxiRoute}', [PageController::class, 'taxiRoute'])
    ->name('taxi-routes.show');

Route::get('/gaggal-airport-taxi', [PageController::class, 'airportTaxi'])
    ->name('airport-taxi');

Route::get('/about', [PageController::class, 'about'])
    ->name('about');

Route::get('/photo-credits', [PageController::class, 'photoCredits'])
    ->name('photo-credits');


/*

|--------------------------------------------------------------------------

| Cabs Detail Routes - SLUG

|--------------------------------------------------------------------------

*/



Route::get('/cabs/{slug}', function ($slug) {

    $vehicle = Vehicle::where('slug', $slug)->firstOrFail();

    $relatedVehicles = Vehicle::where('id', '!=', $vehicle->id)
        ->where('is_active', true)
        ->orderBy('seating_capacity')
        ->take(3)
        ->get();

    $routes = TaxiRoute::orderBy('sort_order')->take(6)->get();

    $faqs = [
        ["How many people can travel in the {$vehicle->name}?",
            "The {$vehicle->name} seats {$vehicle->seating_capacity} passengers comfortably, plus the driver, with space for about {$vehicle->luggage_capacity} medium bags."],
        ["Can I book the {$vehicle->name} for Gaggal Airport pickup?",
            'Yes. Share your flight number when booking and the driver will meet you at arrivals with a name board.'],
        ["Is the {$vehicle->name} suitable for mountain roads?",
            'Yes. All our cabs are serviced for hill driving and come with an experienced local driver who knows the roads of the Kangra Valley and beyond.'],
        ['Can I book this cab for several days?',
            'Yes — book it for a full day, multiple days or a complete Himachal tour with the same driver throughout.'],
    ];

    $images = collect($vehicle->all_images)->map(fn ($img) => \App\Support\Media::url($img))->filter()->values();

    $seo = [
        'title'       => "{$vehicle->name} Taxi in Dharamshala — {$vehicle->seating_capacity} Seater {$vehicle->category} | Dharamshala Travels",
        'description' => "Book a {$vehicle->name} ({$vehicle->category}, {$vehicle->seating_capacity} seats) in Dharamshala and McLeodganj for Gaggal Airport transfers, local sightseeing and outstation trips with an experienced hill driver.",
        'keywords'    => \Illuminate\Support\Str::lower("{$vehicle->name} dharamshala, {$vehicle->name} taxi, {$vehicle->category} cab dharamshala, {$vehicle->name} on rent mcleodganj"),
        'image'       => $vehicle->image,
        'breadcrumbs' => [
            'Book a Cab'   => route('cabs.index'),
            $vehicle->name => route('cabs.show', $vehicle->slug),
        ],
        'schema'      => [
            array_filter([
                '@type'            => 'Vehicle',
                'name'             => $vehicle->name,
                'vehicleConfiguration' => $vehicle->category,
                'seatingCapacity'  => $vehicle->seating_capacity,
                'image'            => $images->all(),
                'url'              => route('cabs.show', $vehicle->slug),
            ]),
            \App\Http\Controllers\PageController::faqSchema($faqs),
        ],
    ];

    return view('cabs.show', compact('vehicle', 'relatedVehicles', 'routes', 'faqs', 'images', 'seo'));
})->name('cabs.show');





/*

|--------------------------------------------------------------------------

| Legacy Vehicle URL

|--------------------------------------------------------------------------

|

| Old: /vehicles/1

| New: /cabs/maruti-suzuki-dzire

|

*/



Route::get('/vehicles/{id}', function ($id) {



    $vehicle = Vehicle::findOrFail($id);



    return redirect()->route(

        'cabs.show',

        ['slug' => $vehicle->slug],

        301

    );
})->name('vehicles.show');





/*

|--------------------------------------------------------------------------

| Tour Package Detail Routes - SLUG

|--------------------------------------------------------------------------

*/



Route::get('/tours/{slug}', function ($slug) {



    $package = Package::where('slug', $slug)->firstOrFail();



    $relatedPackages = Package::where('id', '!=', $package->id)

        ->take(3)

        ->get();



    $vehicles = Vehicle::where('is_active', true)

        ->get();



    $seo = [
        'title'       => "{$package->title} — {$package->duration} | Dharamshala Travels",
        'description' => $package->short_desc,
        'image'       => $package->thumbnail,
        'breadcrumbs' => [
            'Tour Packages' => route('tours.index'),
            $package->title => route('tours.show', $package->slug),
        ],
    ];



    if (view()->exists('tours.show')) {

        return view(

            'tours.show',

            compact(

                'package',

                'relatedPackages',

                'vehicles',

                'seo'

            )

        );
    }



    return view(

        'packages.show',

        compact(

            'package',

            'relatedPackages',

            'vehicles'

        )

    );
})->name('tours.show');





/*

|--------------------------------------------------------------------------

| Legacy Package URL

|--------------------------------------------------------------------------

|

| Old: /packages/1

| New: /tours/package-slug

|

*/



Route::get('/packages/{id}', function ($id) {



    $package = Package::findOrFail($id);



    return redirect()->route(

        'tours.show',

        ['slug' => $package->slug],

        301

    );
})->name('packages.show');

/*

|--------------------------------------------------------------------------

| Dynamic XML Sitemap

|--------------------------------------------------------------------------

*/



Route::get('/sitemap.xml', function () {



    $packages = Package::latest('id')->get();



    $vehicles = Vehicle::where('is_active', true)

        ->latest('id')

        ->get();



    $blogs = Blog::latest('blog_date')

        ->latest('id')

        ->get();



    /*

    |--------------------------------------------------------------------------

    | Fallback XML Sitemap

    |--------------------------------------------------------------------------

    */



    $xml = '<?xml version="1.0" encoding="UTF-8"?>';



    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';





    /*

    |--------------------------------------------------------------------------

    | Homepage

    |--------------------------------------------------------------------------

    */



    $xml .= '<url>';



    $xml .= '<loc>'

        . htmlspecialchars(url('/'))

        . '</loc>';



    $xml .= '<changefreq>daily</changefreq>';



    $xml .= '<priority>1.0</priority>';



    $xml .= '</url>';





    /*

    |--------------------------------------------------------------------------

    | Static Pages

    |--------------------------------------------------------------------------

    */



    $staticUrls = [

        route('cabs.index'),

        route('tours.index'),

        route('blogs.public'),

        route('reviews.index'),

        route('contact'),

        route('destinations.index'),

        route('taxi-routes.index'),

        route('airport-taxi'),

        route('about'),

    ];



    foreach ($staticUrls as $url) {



        $xml .= '<url>';



        $xml .= '<loc>'

            . htmlspecialchars($url)

            . '</loc>';



        $xml .= '<changefreq>weekly</changefreq>';



        $xml .= '<priority>0.8</priority>';



        $xml .= '</url>';
    }





    /*

    |--------------------------------------------------------------------------

    | Vehicle URLs

    |--------------------------------------------------------------------------

    */



    foreach ($vehicles as $vehicle) {



        $xml .= '<url>';



        $xml .= '<loc>'

            . htmlspecialchars(

               route(
    'cabs.show',
    ['slug' => $vehicle->slug]
)

            )

            . '</loc>';



        $xml .= '<changefreq>weekly</changefreq>';



        $xml .= '<priority>0.7</priority>';



        $xml .= '</url>';
    }





    /*

    |--------------------------------------------------------------------------

    | Tour Package URLs

    |--------------------------------------------------------------------------

    */



    foreach ($packages as $package) {



        $xml .= '<url>';



        $xml .= '<loc>'

            . htmlspecialchars(

              route(
    'tours.show',
    ['slug' => $package->slug]
)

            )

            . '</loc>';



        $xml .= '<changefreq>weekly</changefreq>';



        $xml .= '<priority>0.8</priority>';



        $xml .= '</url>';
    }





    /*

    |--------------------------------------------------------------------------

    | Blog URLs

    |--------------------------------------------------------------------------

    */



    foreach ($blogs as $blog) {



        $xml .= '<url>';



        $xml .= '<loc>'

            . htmlspecialchars(

                route(

                    'blogs.show',

                    $blog->slug

                )

            )

            . '</loc>';



        $xml .= '<changefreq>weekly</changefreq>';



        $xml .= '<priority>0.6</priority>';



        $xml .= '</url>';
    }





    /*
    |--------------------------------------------------------------------------
    | Destination & Taxi Route URLs
    |--------------------------------------------------------------------------
    */

    foreach (Destination::orderBy('sort_order')->get() as $destination) {
        $xml .= '<url><loc>' . htmlspecialchars(route('destinations.show', $destination)) . '</loc>'
            . '<lastmod>' . $destination->updated_at->toAtomString() . '</lastmod>'
            . '<changefreq>monthly</changefreq><priority>0.7</priority></url>';
    }

    foreach (TaxiRoute::orderBy('sort_order')->get() as $taxiRoute) {
        $xml .= '<url><loc>' . htmlspecialchars(route('taxi-routes.show', $taxiRoute)) . '</loc>'
            . '<lastmod>' . $taxiRoute->updated_at->toAtomString() . '</lastmod>'
            . '<changefreq>monthly</changefreq><priority>0.8</priority></url>';
    }


    $xml .= '</urlset>';





    return response($xml, 200)

        ->header(

            'Content-Type',

            'application/xml'

        );
})->name('sitemap');





/*

|--------------------------------------------------------------------------

| Robots.txt

|--------------------------------------------------------------------------

*/



Route::get('/robots.txt', function () {



    $content = "User-agent: *\n";



    $content .= "Disallow: /admin\n";



    $content .= "Disallow: /admin/*\n";



    $content .= "Allow: /\n\n";



    $content .= "Sitemap: "

        . url('/sitemap.xml')

        . "\n";





    return response($content, 200)

        ->header(

            'Content-Type',

            'text/plain'

        );
})->name('robots');



/*

|--------------------------------------------------------------------------

| Login Alias

|--------------------------------------------------------------------------

*/



Route::get('/login', function () {



    return redirect()->route(

        'admin.login'

    );
})->name('login');





/*

|--------------------------------------------------------------------------

| Admin Panel Routes

|--------------------------------------------------------------------------

*/



Route::prefix('admin')

    ->name('admin.')

    ->group(function () {



        /*

        |--------------------------------------------------------------------------

        | Guest Routes

        |--------------------------------------------------------------------------

        */



        Route::get('/login', [

            AdminAuthController::class,

            'showLoginForm'

        ])->name('login');



        Route::post('/login', [

            AdminAuthController::class,

            'login'

        ])->name('login.submit');



        Route::post('/logout', [

            AdminAuthController::class,

            'logout'

        ])->name('logout');





        /*

        |--------------------------------------------------------------------------

        | Protected Admin Routes

        |--------------------------------------------------------------------------

        */



        Route::middleware('auth')->group(function () {



            /*

            |--------------------------------------------------------------------------

            | Dashboard

            |--------------------------------------------------------------------------

            */



            Route::get('/', [

                AdminDashboardController::class,

                'index'

            ])->name('dashboard');





            /*

            |--------------------------------------------------------------------------

            | Bookings

            |--------------------------------------------------------------------------

            */



            Route::get('/bookings', [

                AdminDashboardController::class,

                'bookings'

            ])->name('bookings.index');



            Route::patch('/bookings/{booking}/status', [

                AdminDashboardController::class,

                'updateBookingStatus'

            ])->name('bookings.status');



            Route::delete('/bookings/{booking}', [

                AdminDashboardController::class,

                'deleteBooking'

            ])->name('bookings.destroy');





            /*

            |--------------------------------------------------------------------------

            | Vehicles

            |--------------------------------------------------------------------------

            */



            Route::get('/vehicles', [

                AdminDashboardController::class,

                'vehicles'

            ])->name('vehicles.index');



            Route::post('/vehicles', [

                AdminDashboardController::class,

                'storeVehicle'

            ])->name('vehicles.store');



            Route::get('/vehicles/{vehicle}/edit', [

                AdminDashboardController::class,

                'editVehicle'

            ])->name('vehicles.edit');



            Route::put('/vehicles/{vehicle}', [

                AdminDashboardController::class,

                'updateVehicle'

            ])->name('vehicles.update');



            Route::delete('/vehicles/{vehicle}', [

                AdminDashboardController::class,

                'deleteVehicle'

            ])->name('vehicles.destroy');



            Route::delete('/vehicles/{vehicle}/gallery', [

                AdminDashboardController::class,

                'deleteGalleryImage'

            ])->name('vehicles.gallery.delete');





            /*

            |--------------------------------------------------------------------------

            | Tours

            |--------------------------------------------------------------------------

            */



            Route::get('/tours', [

                AdminDashboardController::class,

                'tours'

            ])->name('tours.index');



            Route::get('/packages/create', [

                AdminDashboardController::class,

                'createPackage'

            ])->name('packages.create');



            Route::post('/packages', [

                AdminDashboardController::class,

                'storePackage'

            ])->name('packages.store');



            Route::get('/packages/{package}/edit', [

                AdminDashboardController::class,

                'editPackage'

            ])->name('packages.edit');



            Route::put('/packages/{package}', [

                AdminDashboardController::class,

                'updatePackage'

            ])->name('packages.update');



            Route::delete('/packages/{package}', [

                AdminDashboardController::class,

                'deletePackage'

            ])->name('packages.destroy');





            /*

            |--------------------------------------------------------------------------

            | Inquiries

            |--------------------------------------------------------------------------

            */



            Route::get('/inquiries', [

                AdminEnquiryController::class,

                'index'

            ])->name('inquiries.index');



            Route::patch('/inquiries/{enquiry}/status', [

                AdminEnquiryController::class,

                'updateStatus'

            ])->name('inquiries.update-status');



            Route::delete('/inquiries/{enquiry}', [

                AdminEnquiryController::class,

                'destroy'

            ])->name('inquiries.destroy');





            /*

            |--------------------------------------------------------------------------

            | Blogs

            |--------------------------------------------------------------------------

            */



            Route::get('/blogs', [

                BlogController::class,

                'index'

            ])->name('blogs.index');



            Route::get('/blogs/create', [

                BlogController::class,

                'create'

            ])->name('blogs.create');



            Route::post('/blogs', [

                BlogController::class,

                'store'

            ])->name('blogs.store');



            Route::get('/blogs/{blog}/edit', [

                BlogController::class,

                'edit'

            ])->name('blogs.edit');



            Route::put('/blogs/{blog}', [

                BlogController::class,

                'update'

            ])->name('blogs.update');



            Route::delete('/blogs/{blog}', [

                BlogController::class,

                'destroy'

            ])->name('blogs.destroy');





            /*

            |--------------------------------------------------------------------------

            | Hero Banners

            |--------------------------------------------------------------------------

            */



            Route::get('/banner', [

                HeroBannerController::class,

                'index'

            ])->name('banner');



            Route::post('/banner', [

                HeroBannerController::class,

                'store'

            ])->name('banner.store');



            Route::put('/banner/{heroBanner}', [

                HeroBannerController::class,

                'update'

            ])->name('banner.update');



            Route::delete('/banner/{heroBanner}', [

                HeroBannerController::class,

                'destroy'

            ])->name('banner.destroy');





            /*

            |--------------------------------------------------------------------------

            | Old Hero Banner URL

            |--------------------------------------------------------------------------

            */



            Route::get('/hero-banners', function () {



                return redirect()->route('admin.banner');
            })->name('hero-banners.index');





            /*

            |--------------------------------------------------------------------------

            | Top Announcement Bar

            |--------------------------------------------------------------------------

            */



            Route::get('/top-announcement', [

                AdminDashboardController::class,

                'topAnnouncement'

            ])->name('top-announcement');



            Route::post('/top-announcement', [

                AdminDashboardController::class,

                'updateTopAnnouncement'

            ])->name('top-announcement.update');





            /*

            |--------------------------------------------------------------------------

            | Logo & Favicon

            |--------------------------------------------------------------------------

            */



            Route::get('/logo-favicon', [

                AdminDashboardController::class,

                'logoFavicon'

            ])->name('logo-favicon');



            Route::post('/logo-favicon', [

                AdminDashboardController::class,

                'updateLogoFavicon'

            ])->name('logo-favicon.update');





            /*

            |--------------------------------------------------------------------------

            | Contact Information

            |--------------------------------------------------------------------------

            */



            Route::get('/contact-information', [

                AdminDashboardController::class,

                'contactInformation'

            ])->name('contact-information');



            Route::post('/contact-information', [

                AdminDashboardController::class,

                'updateContactInformation'

            ])->name('contact-information.update');





            /*

            |--------------------------------------------------------------------------

            | Email Desk

            |--------------------------------------------------------------------------

            */



            Route::get('/email-desk', [

                AdminDashboardController::class,

                'emailDesk'

            ])->name('email-desk');



            Route::post('/email-desk', [

                AdminDashboardController::class,

                'updateEmailDesk'

            ])->name('email-desk.update');





            /*

            |--------------------------------------------------------------------------

            | SEO / Basic Settings

            |--------------------------------------------------------------------------

            */



            Route::get('/settings', [

                AdminDashboardController::class,

                'settings'

            ])->name('settings');



            Route::post('/settings', [

                AdminDashboardController::class,

                'updateSettings'

            ])->name('settings.update');





            /*

            |--------------------------------------------------------------------------

            | Admin Reviews

            |--------------------------------------------------------------------------

            */



            Route::get('/reviews', [

                ReviewController::class,

                'adminIndex'

            ])->name('reviews.index');



            Route::put('/reviews/{review}', [

                ReviewController::class,

                'adminUpdate'

            ])->name('reviews.update');



            Route::delete('/reviews/{review}', [

                ReviewController::class,

                'adminDestroy'

            ])->name('reviews.destroy');
        });
    });
