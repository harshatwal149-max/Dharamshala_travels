@extends('layouts.site')

@section('content')

@include('partials.page-hero', [
    'eyebrow'  => 'About us',
    'title'    => 'Your local travel desk in Dharamshala',
    'subtitle' => 'We are a Dharamshala-based taxi and tour operator helping travellers explore the Kangra Valley and Himachal Pradesh safely and comfortably.',
    'image'    => '/images/dharamshala/dhauladhar-alpenglow.jpg',
    'crumbs'   => ['About Us' => route('about')],
])

<section class="bg-cream">
    <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-14 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-20">
        <div>
            <span class="dt-eyebrow">Our story</span>
            <h2 class="mt-3 text-3xl font-extrabold text-pine-950 sm:text-4xl">Rooted in the Dhauladhars</h2>
            <div class="dt-prose mt-5 text-stone-700">
                <p>Dharamshala Travels started with a simple idea: visitors to Dharamshala deserve the same easy, honest travel experience they would get from a friend who lives here. Mountain roads, narrow lanes and changing weather can make getting around tricky — local knowledge makes all the difference.</p>
                <p>Today our team handles Gaggal Airport transfers, McLeodganj and Kangra Valley sightseeing, trek drop-offs for Triund and Kareri, and outstation trips across Himachal, Punjab and Delhi. Every booking is handled by our own travel desk.</p>
                <p>Whether you are here for the Dalai Lama Temple, a cricket match at the HPCA Stadium, paragliding at Bir Billing or a quiet week of meditation in Dharamkot, we will get you there.</p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <img src="{{ \App\Support\Media::url('/images/dharamshala/mcleodganj-market.jpg') }}" alt="McLeodganj market" loading="lazy" class="aspect-[3/4] w-full rounded-2xl object-cover">
            <img src="{{ \App\Support\Media::url('/images/dharamshala/dharamshala-tea-garden.jpg') }}" alt="Tea gardens of Dharamshala" loading="lazy" class="mt-10 aspect-[3/4] w-full rounded-2xl object-cover">
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
        <div class="max-w-2xl">
            <span class="dt-eyebrow">What we stand for</span>
            <h2 class="mt-3 text-3xl font-extrabold text-pine-950">How we work</h2>
        </div>
        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach([
                ['shield-check', 'Safety first', 'Experienced hill drivers, well-maintained cars and no rushing on mountain roads.'],
                ['phone-call', 'Personal service', 'Every booking is confirmed by a real person from our travel desk.'],
                ['map', 'Local knowledge', 'We know the best times, viewpoints, parking spots and shortcuts.'],
                ['heart-handshake', 'Respect for the hills', 'We encourage responsible travel — no littering, respect for monasteries and local customs.'],
            ] as [$icon, $valueTitle, $valueText])
                <div class="rounded-2xl bg-cream p-6">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-pine-900 text-saffron-400"><i data-lucide="{{ $icon }}" class="h-5 w-5"></i></span>
                    <h3 class="mt-4 font-bold text-pine-950">{{ $valueTitle }}</h3>
                    <p class="mt-1.5 text-sm text-stone-600">{{ $valueText }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-pine-950 text-white">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-extrabold sm:text-3xl">Areas we serve</h2>
        <div class="mt-6 flex flex-wrap gap-2">
            @foreach(['Dharamshala', 'McLeodganj', 'Bhagsu', 'Dharamkot', 'Naddi', 'Forsyth Ganj', 'Sidhbari', 'Gaggal Airport', 'Kangra', 'Palampur', 'Bir Billing', 'Dalhousie', 'Khajjiar', 'Manali', 'Shimla', 'Pathankot', 'Amritsar', 'Chandigarh', 'Delhi'] as $area)
                <span class="rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm">{{ $area }}</span>
            @endforeach
        </div>
    </div>
</section>

@include('partials.cta-band', [
    'heading' => 'Ready to explore Himachal?',
    'text'    => 'Tell us where you want to go — we will plan the ride.',
    'type'    => 'local',
])

@endsection
