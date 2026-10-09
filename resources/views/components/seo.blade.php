@php

    /*
    |--------------------------------------------------------------------------
    | BASIC SETTINGS
    |--------------------------------------------------------------------------
    */

    $siteTitle = \App\Models\Setting::get(
        'site_title',
        'Dharamshala Travels'
    );

    $metaTitle = $title ?? \App\Models\Setting::get(
        'meta_title',
        'Dharamshala Travels — Premier Mountain Mobility & Cab Services'
    );

    $metaDescription = $description ?? \App\Models\Setting::get(
        'meta_description',
        'Book verified taxi services in Dharamshala, Gaggal Airport transfers, McLeodganj sightseeing, and customized Himachal holiday tours.'
    );

    $metaKeywords = \App\Models\Setting::get(
        'meta_keywords',
        'taxi in dharamshala, gaggal airport cab, mcleodganj taxi booking, himachal tours'
    );

    $metaRobots = \App\Models\Setting::get(
        'meta_robots',
        'index,follow'
    );


    /*
    |--------------------------------------------------------------------------
    | IMAGES
    |--------------------------------------------------------------------------
    */

    $siteLogo = \App\Models\Setting::get(
        'site_logo'
    ) ?: asset('images/logo.png');


    /*
    |--------------------------------------------------------------------------
    | CONTACT / BUSINESS
    |--------------------------------------------------------------------------
    */

    $phone = \App\Models\Setting::get(
        'seo_business_phone',
        \App\Models\Setting::get(
            'contact_phone',
            '+91 98765 43210'
        )
    );

    $email = \App\Models\Setting::get(
        'seo_business_email',
        \App\Models\Setting::get(
            'contact_email',
            'info@dharamshalatravels.com'
        )
    );

    $address = \App\Models\Setting::get(
        'seo_business_address',
        \App\Models\Setting::get(
            'contact_address',
            'Main Taxi Stand, Kotwali Bazar, Dharamshala, Himachal Pradesh 176215'
        )
    );

    $businessName = \App\Models\Setting::get(
        'seo_business_name',
        $siteTitle
    );

    $businessLogo = \App\Models\Setting::get(
        'seo_business_logo',
        $siteLogo
    ) ?: $siteLogo;


    /*
    |--------------------------------------------------------------------------
    | LOCATION
    |--------------------------------------------------------------------------
    */

    $latitude = \App\Models\Setting::get(
        'seo_latitude',
        ''
    );

    $longitude = \App\Models\Setting::get(
        'seo_longitude',
        ''
    );


    /*
    |--------------------------------------------------------------------------
    | BUSINESS SEO
    |--------------------------------------------------------------------------
    */

    $openingHours = \App\Models\Setting::get(
        'seo_opening_hours',
        'Mo-Su 06:00-23:00'
    );

    $priceRange = \App\Models\Setting::get(
        'seo_price_range',
        '₹₹'
    );

    $serviceAreas = \App\Models\Setting::get(
        'seo_service_areas',
        'Dharamshala, McLeodganj, Kangra, Himachal Pradesh'
    );


    /*
    |--------------------------------------------------------------------------
    | OPEN GRAPH
    |--------------------------------------------------------------------------
    */

    $ogTitle = \App\Models\Setting::get(
        'og_title'
    ) ?: $metaTitle;

    $ogDescription = \App\Models\Setting::get(
        'og_description'
    ) ?: $metaDescription;

    $ogImage = \App\Models\Setting::get(
        'og_image'
    ) ?: $siteLogo;


    /*
    |--------------------------------------------------------------------------
    | TWITTER / X
    |--------------------------------------------------------------------------
    */

    $twitterCard = \App\Models\Setting::get(
        'twitter_card',
        'summary_large_image'
    );

    $twitterTitle = \App\Models\Setting::get(
        'twitter_title'
    ) ?: $metaTitle;

    $twitterDescription = \App\Models\Setting::get(
        'twitter_description'
    ) ?: $metaDescription;

    $twitterImage = \App\Models\Setting::get(
        'twitter_image'
    ) ?: $ogImage;


    /*
    |--------------------------------------------------------------------------
    | GOOGLE
    |--------------------------------------------------------------------------
    */

    $googleVerification = \App\Models\Setting::get(
        'google_site_verification',
        ''
    );

    $googleAnalyticsId = \App\Models\Setting::get(
        'google_analytics_id',
        ''
    );


    /*
    |--------------------------------------------------------------------------
    | SCHEMA ENABLE / DISABLE
    |--------------------------------------------------------------------------
    */

    $schemaEnabled = \App\Models\Setting::get(
        'seo_schema_enabled',
        '1'
    );


    /*
    |--------------------------------------------------------------------------
    | CURRENT URL
    |--------------------------------------------------------------------------
    */

    $currentUrl = url()->current();


    /*
    |--------------------------------------------------------------------------
    | SERVICE AREAS
    |--------------------------------------------------------------------------
    */

    $areaNames = collect(
        preg_split('/[,;\n]+/', $serviceAreas)
    )
    ->map(fn ($area) => trim($area))
    ->filter()
    ->values();


    /*
    |--------------------------------------------------------------------------
    | SCHEMA DATA
    |--------------------------------------------------------------------------
    */

    $schemaData = [
        '@context' => 'https://schema.org',

        '@type' => 'TaxiService',

        'name' => $businessName,

        'image' => $businessLogo,

        'telephone' => $phone,

        'email' => $email,

        'url' => url('/'),

        'priceRange' => $priceRange,

        'address' => [
            '@type' => 'PostalAddress',

            'streetAddress' => $address,

            'addressLocality' => 'Dharamshala',

            'addressRegion' => 'Himachal Pradesh',

            'postalCode' => '176215',

            'addressCountry' => 'IN',
        ],

        'areaServed' => $areaNames
            ->map(function ($area) {

                return [
                    '@type' => 'Place',
                    'name' => $area,
                ];

            })
            ->values()
            ->all(),

        'openingHours' => $openingHours,
    ];


    /*
    |--------------------------------------------------------------------------
    | GEO COORDINATES
    |--------------------------------------------------------------------------
    */

    if (
        $latitude !== '' &&
        $longitude !== ''
    ) {

        $schemaData['geo'] = [

            '@type' => 'GeoCoordinates',

            'latitude' => (float) $latitude,

            'longitude' => (float) $longitude,

        ];

    }

@endphp


{{-- ===================================================================== --}}
{{-- PRIMARY SEO --}}
{{-- ===================================================================== --}}

<title>{{ $metaTitle }}</title>

<meta
    name="title"
    content="{{ $metaTitle }}"
>

<meta
    name="description"
    content="{{ $metaDescription }}"
>

<meta
    name="keywords"
    content="{{ $metaKeywords }}"
>

<meta
    name="robots"
    content="{{ $metaRobots }}"
>

<meta
    name="language"
    content="English"
>

<link
    rel="canonical"
    href="{{ $currentUrl }}"
>


{{-- ===================================================================== --}}
{{-- GOOGLE SEARCH CONSOLE --}}
{{-- ===================================================================== --}}

@if($googleVerification)

    <meta
        name="google-site-verification"
        content="{{ $googleVerification }}"
    >

@endif


{{-- ===================================================================== --}}
{{-- OPEN GRAPH / FACEBOOK / WHATSAPP --}}
{{-- ===================================================================== --}}

<meta
    property="og:type"
    content="website"
>

<meta
    property="og:url"
    content="{{ $currentUrl }}"
>

<meta
    property="og:title"
    content="{{ $ogTitle }}"
>

<meta
    property="og:description"
    content="{{ $ogDescription }}"
>

<meta
    property="og:image"
    content="{{ $ogImage }}"
>

<meta
    property="og:site_name"
    content="{{ $siteTitle }}"
>

<meta
    property="og:locale"
    content="en_IN"
>


{{-- ===================================================================== --}}
{{-- TWITTER / X --}}
{{-- ===================================================================== --}}

<meta
    name="twitter:card"
    content="{{ $twitterCard }}"
>

<meta
    name="twitter:url"
    content="{{ $currentUrl }}"
>

<meta
    name="twitter:title"
    content="{{ $twitterTitle }}"
>

<meta
    name="twitter:description"
    content="{{ $twitterDescription }}"
>

<meta
    name="twitter:image"
    content="{{ $twitterImage }}"
>


{{-- ===================================================================== --}}
{{-- GOOGLE ANALYTICS --}}
{{-- ===================================================================== --}}

@if($googleAnalyticsId)

    <script
        async
        src="https://www.googletagmanager.com/gtag/js?id={{ urlencode($googleAnalyticsId) }}"
    ></script>

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag(
            'config',
            @json($googleAnalyticsId)
        );
    </script>

@endif


{{-- ===================================================================== --}}
{{-- STRUCTURED DATA / JSON-LD --}}
{{-- ===================================================================== --}}

@if($schemaEnabled == '1')

    <script type="application/ld+json">
        {!! json_encode(
            $schemaData,
            JSON_UNESCAPED_SLASHES |
            JSON_UNESCAPED_UNICODE |
            JSON_PRETTY_PRINT
        ) !!}
    </script>

@endif