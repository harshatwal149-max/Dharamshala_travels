<!DOCTYPE html>
<html lang="en-IN" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0a1f1a">

    <link rel="icon" type="image/png" href="{{ \App\Support\Media::url(\App\Models\Setting::get('site_favicon') ?: '/images/favicon-48.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/favicon-512.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">

    {{-- Rendered in isolation so page variables ($title, $image…) never leak into SEO tags --}}
    {!! view('components.seo', $seo ?? [])->render() !!}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js" defer></script>

    @stack('head')
</head>
<body class="dt-site text-stone-800 antialiased" x-data>

    @include('components.header')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    @include('partials.booking-modal')
    @include('partials.floating-contact')
    @include('partials.booking-success')

    @stack('scripts')
</body>
</html>
