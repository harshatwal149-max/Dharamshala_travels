{{--
    Shared SEO head tags.

    Optional page-level variables:
      $title, $description, $keywords, $image, $type (og:type),
      $canonical, $breadcrumbs ([label => url]), $schema (array of JSON-LD objects)
--}}
@use('App\Models\Setting')
@use('App\Support\Media')
@php

    /*
    |--------------------------------------------------------------------------
    | BASIC SETTINGS
    |--------------------------------------------------------------------------
    */
    $siteTitle = Setting::get('site_title') ?: 'Dharamshala Travels';

    $metaTitle = $title ?? (Setting::get('meta_title') ?: 'Dharamshala Travels — Taxi Service & Himachal Tours');

    $metaDescription = $description ?? (Setting::get('meta_description')
        ?: 'Book verified taxi services in Dharamshala, Gaggal Airport transfers, McLeodganj sightseeing, and customized Himachal holiday tours.');

    $metaKeywords = $keywords ?? (Setting::get('meta_keywords')
        ?: 'taxi in dharamshala, gaggal airport cab, mcleodganj taxi booking, himachal tours');

    $metaRobots = Setting::get('meta_robots') ?: 'index,follow';

    $isPageLevel = isset($title);

    /*
    |--------------------------------------------------------------------------
    | IMAGES
    |--------------------------------------------------------------------------
    */
    $siteLogo = Media::url(Setting::get('site_logo')) ?: asset('images/logo.png');

    /*
    |--------------------------------------------------------------------------
    | CONTACT / BUSINESS
    |--------------------------------------------------------------------------
    */
    $phone = Setting::get('seo_business_phone') ?: Setting::get('contact_phone', '+91 98765 43210');
    $email = Setting::get('seo_business_email') ?: Setting::get('contact_email', 'info@dharamshalatravels.com');
    $address = Setting::get('seo_business_address')
        ?: Setting::get('contact_address', 'Main Taxi Stand, Kotwali Bazar, Dharamshala, Himachal Pradesh 176215');
    $businessName = Setting::get('seo_business_name') ?: $siteTitle;
    $businessLogo = Media::url(Setting::get('seo_business_logo')) ?: $siteLogo;

    /*
    |--------------------------------------------------------------------------
    | LOCATION & BUSINESS SEO
    |--------------------------------------------------------------------------
    */
    $latitude = Setting::get('seo_latitude', '');
    $longitude = Setting::get('seo_longitude', '');
    $openingHours = Setting::get('seo_opening_hours') ?: 'Mo-Su 06:00-23:00';
    $priceRange = Setting::get('seo_price_range');
    $serviceAreas = Setting::get('seo_service_areas') ?: 'Dharamshala, McLeodganj, Kangra, Himachal Pradesh';

    /*
    |--------------------------------------------------------------------------
    | OPEN GRAPH / TWITTER
    |--------------------------------------------------------------------------
    | Page-level values win over the global defaults from settings.
    */
    $ogTitle = $isPageLevel ? $metaTitle : (Setting::get('og_title') ?: $metaTitle);
    $ogDescription = isset($description) ? $metaDescription : (Setting::get('og_description') ?: $metaDescription);
    $ogImage = Media::url($image ?? null) ?: (Media::url(Setting::get('og_image')) ?: $siteLogo);
    $ogType = $type ?? 'website';

    $twitterCard = Setting::get('twitter_card') ?: 'summary_large_image';
    $twitterTitle = $isPageLevel ? $metaTitle : (Setting::get('twitter_title') ?: $metaTitle);
    $twitterDescription = isset($description) ? $metaDescription : (Setting::get('twitter_description') ?: $metaDescription);
    $twitterImage = isset($image) ? $ogImage : (Media::url(Setting::get('twitter_image')) ?: $ogImage);

    /*
    |--------------------------------------------------------------------------
    | GOOGLE
    |--------------------------------------------------------------------------
    */
    $googleVerification = Setting::get('google_site_verification', '');
    $googleAnalyticsId = Setting::get('google_analytics_id', '');

    $schemaEnabled = Setting::get('seo_schema_enabled', '1');

    $currentUrl = $canonical ?? url()->current();

    /*
    |--------------------------------------------------------------------------
    | SCHEMA DATA
    |--------------------------------------------------------------------------
    */
    $areaNames = collect(preg_split('/[,;\n]+/', $serviceAreas))
        ->map(fn ($area) => trim($area))
        ->filter()
        ->values();

    $schemaData = [
        '@context' => 'https://schema.org',
        '@type' => 'TaxiService',
        'name' => $businessName,
        'image' => $businessLogo,
        'telephone' => $phone,
        'email' => $email,
        'url' => url('/'),
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $address,
            'addressLocality' => 'Dharamshala',
            'addressRegion' => 'Himachal Pradesh',
            'postalCode' => '176215',
            'addressCountry' => 'IN',
        ],
        'areaServed' => $areaNames
            ->map(fn ($area) => ['@type' => 'Place', 'name' => $area])
            ->all(),
        'openingHours' => $openingHours,
    ];

    if (filled($priceRange)) {
        $schemaData['priceRange'] = $priceRange;
    }

    if ($latitude !== '' && $latitude !== null && $longitude !== '' && $longitude !== null) {
        $schemaData['geo'] = [
            '@type' => 'GeoCoordinates',
            'latitude' => (float) $latitude,
            'longitude' => (float) $longitude,
        ];
    }

    $schemas = [$schemaData];

    if (!empty($breadcrumbs)) {
        $items = array_merge(['Home' => url('/')], $breadcrumbs);
        $schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)->values()->map(fn ($url, $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => array_keys($items)[$i],
                'item' => $url,
            ])->all(),
        ];
    }

    foreach ($schema ?? [] as $item) {
        $schemas[] = ['@context' => 'https://schema.org'] + $item;
    }
@endphp

{{-- PRIMARY SEO --}}
<title>{{ $metaTitle }}</title>
<meta name="title" content="{{ $metaTitle }}">
<meta name="description" content="{{ $metaDescription }}">
<meta name="keywords" content="{{ $metaKeywords }}">
<meta name="robots" content="{{ $metaRobots }}">
<meta name="language" content="English">
<meta name="geo.region" content="IN-HP">
<meta name="geo.placename" content="Dharamshala">
<link rel="canonical" href="{{ $currentUrl }}">

@if($googleVerification)
    <meta name="google-site-verification" content="{{ $googleVerification }}">
@endif

{{-- OPEN GRAPH / FACEBOOK / WHATSAPP --}}
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:url" content="{{ $currentUrl }}">
<meta property="og:title" content="{{ $ogTitle }}">
<meta property="og:description" content="{{ $ogDescription }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:image:alt" content="{{ $ogTitle }}">
<meta property="og:site_name" content="{{ $siteTitle }}">
<meta property="og:locale" content="en_IN">

{{-- TWITTER / X --}}
<meta name="twitter:card" content="{{ $twitterCard }}">
<meta name="twitter:url" content="{{ $currentUrl }}">
<meta name="twitter:title" content="{{ $twitterTitle }}">
<meta name="twitter:description" content="{{ $twitterDescription }}">
<meta name="twitter:image" content="{{ $twitterImage }}">

{{-- GOOGLE ANALYTICS --}}
@if($googleAnalyticsId)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ urlencode($googleAnalyticsId) }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', @json($googleAnalyticsId));
    </script>
@endif

{{-- STRUCTURED DATA / JSON-LD --}}
@if($schemaEnabled == '1')
    @foreach($schemas as $jsonLd)
        <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
    @endforeach
@endif
