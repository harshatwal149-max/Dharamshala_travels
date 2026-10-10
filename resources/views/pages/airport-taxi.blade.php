@extends('layouts.site')

@section('content')

@include('partials.page-hero', [
    'eyebrow'  => 'Kangra Airport (DHM)',
    'title'    => 'Gaggal Airport Taxi to Dharamshala & McLeodganj',
    'subtitle' => 'Pre-booked pickups with flight tracking and a name-board welcome at arrivals. Local drivers, help with luggage, no queue at the taxi counter.',
    'image'    => '/images/dharamshala/kangra-airport.jpg',
    'crumbs'   => ['Gaggal Airport Taxi' => route('airport-taxi')],
])

@php
    $extraDrops = [
        ['Bhagsu / Dharamkot', '25–27 km', '50–70 min'],
        ['Naddi', '26 km', '55–70 min'],
        ['Palampur', '40 km', '1–1.25 hrs'],
        ['Kangra town', '12 km', '25 min'],
    ];
@endphp

<section class="bg-cream">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-6 md:grid-cols-2">
            @foreach($airportRoutes as $r)
                <div class="flex flex-col overflow-hidden rounded-2xl bg-white ring-1 ring-stone-200 sm:flex-row">
                    <img src="{{ $r->image_url }}" alt="{{ $r->title }}" loading="lazy" class="h-48 w-full object-cover sm:h-auto sm:w-48">
                    <div class="flex flex-1 flex-col p-6">
                        <h2 class="text-xl font-extrabold text-pine-950">To {{ $r->to_city }}</h2>
                        <p class="mt-1 text-sm text-stone-500">{{ $r->distance_km }} km • {{ $r->duration }}</p>
                        <ul class="mt-4 space-y-1.5 text-sm text-stone-600">
                            <li class="flex items-center gap-2"><i data-lucide="check" class="h-4 w-4 text-pine-500"></i>Sedan, SUV & Tempo Traveller</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="h-4 w-4 text-pine-500"></i>Name-board meet at arrivals</li>
                        </ul>
                        <div class="mt-5 flex gap-2">
                            <button type="button" @click="$dispatch('open-booking', { type: 'airport', pickup: 'Gaggal Airport (DHM)', drop: @js($r->to_city) })"
                                    class="flex-1 rounded-xl bg-saffron-500 px-4 py-2.5 text-sm font-bold text-pine-950 transition hover:bg-saffron-400">Book pickup</button>
                            <a href="{{ route('taxi-routes.show', $r) }}" class="rounded-xl px-4 py-2.5 text-sm font-semibold text-pine-700 ring-1 ring-stone-200 hover:bg-stone-50">Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 rounded-2xl bg-white p-6 ring-1 ring-stone-200">
            <h2 class="text-lg font-extrabold text-pine-950">Other drops from Gaggal Airport</h2>
            <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($extraDrops as [$place, $km, $time])
                    <button type="button" @click="$dispatch('open-booking', { type: 'airport', pickup: 'Gaggal Airport (DHM)', drop: @js($place) })"
                            class="rounded-xl border border-stone-200 p-4 text-left transition hover:border-pine-300 hover:bg-pine-50/50">
                        <p class="font-semibold text-pine-950">{{ $place }}</p>
                        <p class="mt-0.5 text-xs text-stone-500">{{ $km }} • {{ $time }}</p>
                        <p class="mt-2 text-xs font-semibold text-pine-700">Book pickup →</p>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
        <span class="dt-eyebrow">How airport pickup works</span>
        <h2 class="mt-3 text-3xl font-extrabold text-pine-950">From runway to hotel, stress-free</h2>
        <ol class="mt-10 grid gap-6 md:grid-cols-4">
            @foreach([
                ['ticket', 'Share your flight', 'Send your flight number, arrival date and hotel name.'],
                ['phone-call', 'Get a confirmation', 'We call or WhatsApp to confirm your cab and pickup time.'],
                ['plane-landing', 'We track your flight', 'Your driver adjusts to early or delayed arrivals.'],
                ['hand-helping', 'Meet at arrivals', 'Look for your name board outside the terminal exit.'],
            ] as $n => [$icon, $stepTitle, $stepText])
                <li class="relative rounded-2xl bg-cream p-6">
                    <span class="absolute right-5 top-5 text-4xl font-extrabold text-pine-100">0{{ $n + 1 }}</span>
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-pine-900 text-saffron-400"><i data-lucide="{{ $icon }}" class="h-5 w-5"></i></span>
                    <h3 class="mt-4 font-bold text-pine-950">{{ $stepTitle }}</h3>
                    <p class="mt-1.5 text-sm text-stone-600">{{ $stepText }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>

<section class="bg-cream">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-12 lg:px-8 lg:py-20">
        <div class="lg:col-span-4">
            <span class="dt-eyebrow">FAQ</span>
            <h2 class="mt-3 text-3xl font-extrabold text-pine-950">Gaggal Airport taxi questions</h2>
            <img src="{{ \App\Support\Media::url('/images/dharamshala/gaggal-terminal.jpg') }}" alt="Gaggal Airport terminal, Kangra" loading="lazy" class="mt-6 hidden aspect-[4/3] w-full rounded-2xl object-cover lg:block">
        </div>
        <div class="lg:col-span-8">
            @include('partials.faq-list', ['faqs' => $faqs])
        </div>
    </div>
</section>

@include('partials.cta-band', [
    'heading' => 'Book your Gaggal Airport pickup',
    'text'    => 'Tell us your flight details — your driver will be waiting.',
    'type'    => 'airport',
    'button'  => 'Book airport pickup',
])

@endsection
