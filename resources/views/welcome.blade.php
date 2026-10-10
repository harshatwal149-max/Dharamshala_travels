@extends('layouts.site')

@use('App\Support\Media')
@use('App\Models\Setting')

@php
    $phone = Setting::get('contact_phone', '+91 98765 43210');
    $phoneHref = preg_replace('/[^0-9+]/', '', $phone);

    $slides = $heroBanners->map(fn ($b) => [
        'image'    => Media::url($b->image),
        'title'    => $b->title ?: $banner['hero_title'],
        'subtitle' => $b->subtitle ?: $banner['hero_subtitle'],
    ])->values();

    if ($slides->isEmpty()) {
        $slides = collect([[
            'image'    => Media::url($banner['hero_banner_image'], '/images/dharamshala/dhauladhar-alpenglow.jpg'),
            'title'    => $banner['hero_title'],
            'subtitle' => $banner['hero_subtitle'],
        ]]);
    }
@endphp

@section('content')

{{-- =====================================================================
     HERO
     ===================================================================== --}}
<section class="relative isolate overflow-hidden bg-pine-950 text-white"
         x-data="{ active: 0, total: {{ $slides->count() }}, timer: null,
                   go(i) { this.active = (i + this.total) % this.total },
                   start() { if (this.total > 1) this.timer = setInterval(() => this.go(this.active + 1), 6500) } }"
         x-init="start()">

    @foreach($slides as $i => $slide)
        <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] }}"
             class="absolute inset-0 -z-20 h-full w-full object-cover transition-opacity duration-1000"
             :class="active === {{ $i }} ? 'opacity-100' : 'opacity-0'"
             @if($i === 0) fetchpriority="high" @else loading="lazy" style="opacity:0" :style="''" @endif>
    @endforeach
    <div class="dt-hero-fade absolute inset-0 -z-10"></div>

    <div class="mx-auto grid max-w-7xl gap-10 px-4 pb-16 pt-14 sm:px-6 sm:pt-20 lg:grid-cols-12 lg:items-center lg:gap-12 lg:px-8 lg:pb-24 lg:pt-24">

        {{-- Copy --}}
        <div class="lg:col-span-7">
            <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold text-saffron-300 backdrop-blur">
                <i data-lucide="map-pin" class="h-3.5 w-3.5"></i>
                Dharamshala • McLeodganj • Kangra Valley
            </span>

            <div class="mt-5 grid text-white">
                @foreach($slides as $i => $slide)
                    <div class="[grid-area:1/1] transition-all duration-700"
                         :class="active === {{ $i }} ? 'opacity-100 translate-y-0' : 'pointer-events-none opacity-0 translate-y-3'"
                         @if($i > 0) style="opacity:0" :style="''" @endif
                         :aria-hidden="active !== {{ $i }}">
                        @if($i === 0)
                            <h1 class="text-4xl font-extrabold leading-[1.08] sm:text-5xl lg:text-6xl">{{ $slide['title'] }}</h1>
                        @else
                            <p class="text-4xl font-extrabold leading-[1.08] sm:text-5xl lg:text-6xl" role="heading" aria-level="2">{{ $slide['title'] }}</p>
                        @endif
                        <p class="mt-5 max-w-xl text-base leading-relaxed text-white/80 sm:text-lg">{{ $slide['subtitle'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <button type="button" @click="$dispatch('open-booking', { type: 'airport' })"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-saffron-500 px-6 py-3.5 text-sm font-bold text-pine-950 shadow-lg shadow-saffron-500/30 transition hover:bg-saffron-400">
                    <i data-lucide="calendar-check" class="h-4 w-4"></i>
                    Book a Cab
                </button>
                <a href="tel:{{ $phoneHref }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/25 bg-white/10 px-6 py-3.5 text-sm font-semibold text-white backdrop-blur transition hover:bg-white/20">
                    <i data-lucide="phone-call" class="h-4 w-4"></i>
                    {{ $phone }}
                </a>
            </div>

            <dl class="mt-10 grid max-w-xl grid-cols-3 gap-4 border-t border-white/15 pt-6 text-sm">
                <div>
                    <dt class="flex items-center gap-1.5 font-semibold text-white"><i data-lucide="plane-landing" class="h-4 w-4 text-saffron-400"></i>Airport pickups</dt>
                    <dd class="mt-1 text-xs text-white/65">Flight-tracked, name-board meet</dd>
                </div>
                <div>
                    <dt class="flex items-center gap-1.5 font-semibold text-white"><i data-lucide="badge-check" class="h-4 w-4 text-saffron-400"></i>Hill drivers</dt>
                    <dd class="mt-1 text-xs text-white/65">Verified & locally experienced</dd>
                </div>
                <div>
                    <dt class="flex items-center gap-1.5 font-semibold text-white"><i data-lucide="clock-3" class="h-4 w-4 text-saffron-400"></i>Always on time</dt>
                    <dd class="mt-1 text-xs text-white/65">6 AM – 11 PM travel desk</dd>
                </div>
            </dl>

            @if($slides->count() > 1)
                <div class="mt-8 flex items-center gap-2">
                    @foreach($slides as $i => $slide)
                        <button type="button" @click="go({{ $i }}); clearInterval(timer); start()"
                                class="h-1.5 rounded-full transition-all"
                                :class="active === {{ $i }} ? 'w-8 bg-saffron-400' : 'w-4 bg-white/40 hover:bg-white/70'"
                                aria-label="Show slide {{ $i + 1 }}"></button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Quick booking card --}}
        <div class="lg:col-span-5" x-data="{ type: 'airport' }">
            <form action="{{ route('bookings.store') }}" method="POST"
                  class="rounded-3xl bg-white p-5 text-stone-800 shadow-2xl shadow-black/30 sm:p-7">
                @csrf
                <input type="hidden" name="booking_type" :value="type">

                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-extrabold text-pine-950">Get a quick quote</h2>
                    <span class="rounded-full bg-pine-50 px-2.5 py-1 text-[11px] font-semibold text-pine-700">Reply in minutes</span>
                </div>

                <div class="mt-4 grid grid-cols-3 gap-1 rounded-xl bg-stone-100 p-1 text-xs font-semibold">
                    @foreach(['airport' => 'Airport', 'local' => 'Local', 'outstation' => 'Outstation'] as $key => $label)
                        <button type="button" @click="type = '{{ $key }}'"
                                :class="type === '{{ $key }}' ? 'bg-white text-pine-900 shadow-sm' : 'text-stone-500 hover:text-stone-800'"
                                class="rounded-lg py-2 transition">{{ $label }}</button>
                    @endforeach
                </div>

                <div class="mt-4 space-y-3">
                    <div class="relative">
                        <i data-lucide="circle-dot" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-pine-500"></i>
                        <input type="text" name="pickup_location" required maxlength="255"
                               :value="type === 'airport' ? 'Gaggal Airport (DHM)' : ''"
                               placeholder="Pickup — hotel, airport or station" class="dt-input pl-9" aria-label="Pickup location">
                    </div>
                    <div class="relative">
                        <i data-lucide="map-pin" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-saffron-600"></i>
                        <input type="text" name="drop_location" maxlength="255"
                               :placeholder="type === 'local' ? 'Places to visit (optional)' : 'Drop — e.g. McLeodganj, Manali'"
                               class="dt-input pl-9" aria-label="Drop location">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <input type="date" name="travel_date" required min="{{ now()->toDateString() }}" value="{{ now()->toDateString() }}" class="dt-input" aria-label="Travel date">
                        <select name="vehicle_id" class="dt-input" aria-label="Cab type">
                            <option value="">Any cab</option>
                            @foreach($vehicles as $veh)
                                <option value="{{ $veh->id }}">{{ $veh->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" name="customer_name" required maxlength="100" placeholder="Your name" class="dt-input" autocomplete="name" aria-label="Your name">
                        <input type="tel" name="customer_phone" required maxlength="20" placeholder="Mobile number" class="dt-input" autocomplete="tel" aria-label="Mobile number">
                    </div>
                </div>

                <button type="submit" class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-pine-900 px-6 py-3.5 text-sm font-bold text-white transition hover:bg-pine-800">
                    Request booking
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </button>
                <p class="mt-3 text-center text-[11px] text-stone-500">No advance payment • We call back to confirm your booking</p>
            </form>
        </div>
    </div>
</section>

{{-- =====================================================================
     SERVICES
     ===================================================================== --}}
<section class="relative z-10 -mt-px bg-white">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="max-w-2xl">
            <span class="dt-eyebrow">What we do</span>
            <h2 class="mt-3 text-3xl font-extrabold text-pine-950 sm:text-4xl">Every ride in the Kangra Valley, sorted</h2>
            <p class="mt-3 text-stone-600">From the moment you land at Gaggal to your last sunset at Naddi — one local team for airport transfers, sightseeing and long-distance trips.</p>
        </div>

        @php
            $services = [
                ['icon' => 'plane', 'title' => 'Gaggal Airport Transfers', 'text' => 'Pickups and drops between Kangra Airport (DHM) and any hotel in Dharamshala, McLeodganj, Bhagsu or Dharamkot.', 'url' => route('airport-taxi'), 'cta' => 'Airport taxi'],
                ['icon' => 'map', 'title' => 'Local Sightseeing', 'text' => 'Full and half-day tours of the Dalai Lama Temple, Bhagsu, St. John’s Church, Dal Lake, Naddi and the HPCA Stadium.', 'url' => route('destinations.index'), 'cta' => 'Places to visit'],
                ['icon' => 'route', 'title' => 'Outstation Cabs', 'text' => 'One-way and round trips to Manali, Shimla, Dalhousie, Amritsar, Chandigarh, Pathankot and Delhi.', 'url' => route('taxi-routes.index'), 'cta' => 'See taxi routes'],
                ['icon' => 'mountain-snow', 'title' => 'Tours & Treks', 'text' => 'Triund and Kareri treks, Bir Billing paragliding days and multi-day Himachal circuits with one dedicated driver.', 'url' => route('tours.index'), 'cta' => 'Browse packages'],
            ];
        @endphp

        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($services as $service)
                <a href="{{ $service['url'] }}" class="group flex flex-col rounded-2xl border border-stone-200 bg-cream p-6 transition hover:-translate-y-1 hover:border-pine-200 hover:bg-white hover:shadow-xl hover:shadow-pine-900/5">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-pine-900 text-saffron-400 transition group-hover:bg-saffron-500 group-hover:text-pine-950">
                        <i data-lucide="{{ $service['icon'] }}" class="h-6 w-6"></i>
                    </span>
                    <h3 class="mt-5 text-lg font-bold text-pine-950">{{ $service['title'] }}</h3>
                    <p class="mt-2 flex-1 text-sm leading-relaxed text-stone-600">{{ $service['text'] }}</p>
                    <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-pine-700">
                        {{ $service['cta'] }}
                        <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-1"></i>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- =====================================================================
     DESTINATIONS
     ===================================================================== --}}
@if($destinations->isNotEmpty())
<section id="destinations" class="bg-cream">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div class="max-w-2xl">
                <span class="dt-eyebrow">Places to visit</span>
                <h2 class="mt-3 text-3xl font-extrabold text-pine-950 sm:text-4xl">Explore Dharamshala & beyond</h2>
                <p class="mt-3 text-stone-600">Monasteries, waterfalls, forts and alpine ridges — all within easy driving distance of your hotel.</p>
            </div>
            <a href="{{ route('destinations.index') }}" class="inline-flex shrink-0 items-center gap-1.5 text-sm font-semibold text-pine-700 hover:text-pine-900">
                All destinations <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>

        <div class="mt-10 grid auto-rows-[220px] grid-cols-1 gap-4 sm:grid-cols-2 lg:auto-rows-[240px] lg:grid-cols-4">
            @foreach($destinations as $i => $place)
                <a href="{{ route('destinations.show', $place) }}"
                   class="group relative overflow-hidden rounded-2xl bg-pine-900 {{ $i === 0 ? 'sm:col-span-2 sm:row-span-2' : '' }} {{ $i === 3 ? 'lg:col-span-2' : '' }}">
                    <img src="{{ $place->image_url }}" alt="{{ $place->name }}" loading="lazy"
                         class="dt-card-img absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-pine-950/90 via-pine-950/20 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 p-5">
                        <span class="rounded-full bg-white/15 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide text-white backdrop-blur">{{ $place->category }}</span>
                        <h3 class="mt-2 font-bold text-white {{ $i === 0 ? 'text-2xl sm:text-3xl' : 'text-lg' }}">{{ $place->name }}</h3>
                        @if($i === 0)
                            <p class="mt-2 max-w-md text-sm text-white/80">{{ $place->short_desc }}</p>
                        @endif
                        @if($place->distance)
                            <p class="mt-1 flex items-center gap-1 text-xs text-white/70"><i data-lucide="navigation" class="h-3 w-3"></i>{{ \Illuminate\Support\Str::before($place->distance, '•') }}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- =====================================================================
     FLEET
     ===================================================================== --}}
<section id="fleet" class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div class="max-w-2xl">
                <span class="dt-eyebrow">Our fleet</span>
                <h2 class="mt-3 text-3xl font-extrabold text-pine-950 sm:text-4xl">Clean, comfortable cabs for mountain roads</h2>
                <p class="mt-3 text-stone-600">Every car is serviced for hill driving and comes with a driver who knows the hairpins, one-ways and parking spots.</p>
            </div>
            <a href="{{ route('cabs.index') }}" class="inline-flex shrink-0 items-center gap-1.5 text-sm font-semibold text-pine-700 hover:text-pine-900">
                View all cabs <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>

        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @forelse($vehicles as $veh)
                <article class="group flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white transition hover:shadow-xl hover:shadow-pine-900/5">
                    <a href="{{ route('cabs.show', $veh->slug) }}" class="relative block aspect-[4/3] overflow-hidden bg-stone-100">
                        @if($veh->image)
                            <img src="{{ Media::url($veh->image) }}" alt="{{ $veh->name }} taxi in Dharamshala" loading="lazy" class="dt-card-img h-full w-full object-cover">
                        @endif
                        @if($veh->badge)
                            <span class="absolute left-3 top-3 rounded-full bg-saffron-500 px-2.5 py-1 text-[11px] font-bold text-pine-950">{{ $veh->badge }}</span>
                        @endif
                    </a>
                    <div class="flex flex-1 flex-col p-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-pine-600">{{ $veh->category }}</p>
                        <h3 class="mt-1 text-lg font-bold text-pine-950">
                            <a href="{{ route('cabs.show', $veh->slug) }}" class="hover:text-pine-700">{{ $veh->name }}</a>
                        </h3>
                        <div class="mt-3 flex gap-4 text-xs text-stone-600">
                            <span class="flex items-center gap-1"><i data-lucide="users" class="h-3.5 w-3.5 text-pine-500"></i>{{ $veh->seating_capacity }} seats</span>
                            <span class="flex items-center gap-1"><i data-lucide="briefcase" class="h-3.5 w-3.5 text-pine-500"></i>{{ $veh->luggage_capacity }} bags</span>
                            <span class="flex items-center gap-1"><i data-lucide="snowflake" class="h-3.5 w-3.5 text-pine-500"></i>AC</span>
                        </div>
                        <div class="mt-auto flex items-end justify-between gap-3 border-t border-stone-100 pt-4 mt-5">
                            <a href="{{ route('cabs.show', $veh->slug) }}" class="text-xs font-semibold text-pine-700 hover:text-pine-900">View details →</a>
                            <button type="button" @click="$dispatch('open-booking', { type: 'outstation', vehicle: {{ $veh->id }} })"
                                    class="rounded-lg bg-pine-900 px-4 py-2 text-xs font-semibold text-white transition hover:bg-pine-800">Book</button>
                        </div>
                    </div>
                </article>
            @empty
                <p class="col-span-full rounded-2xl border border-dashed border-stone-300 p-10 text-center text-sm text-stone-500">Our fleet is being updated — call us for availability.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- =====================================================================
     TAXI ROUTES
     ===================================================================== --}}
@if($taxiRoutes->isNotEmpty())
<section id="routes" class="bg-pine-950 text-white">
    <div class="mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-12 lg:px-8 lg:py-20">
        <div class="lg:col-span-4">
            <span class="dt-eyebrow !text-saffron-400">Popular routes</span>
            <h2 class="mt-3 text-3xl font-extrabold sm:text-4xl">Outstation & airport taxi routes</h2>
            <p class="mt-4 text-white/70">Our most-booked routes from Dharamshala and Gaggal Airport — one-way or round trip, with experienced hill drivers. Call or send a request for a quote.</p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row lg:flex-col">
                <a href="{{ route('taxi-routes.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-saffron-500 px-5 py-3 text-sm font-bold text-pine-950 transition hover:bg-saffron-400">
                    All taxi routes <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>
                <button type="button" @click="$dispatch('open-booking', { type: 'outstation', pickup: 'Dharamshala' })"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/20 px-5 py-3 text-sm font-semibold transition hover:bg-white/10">
                    Ask for a custom quote
                </button>
            </div>
        </div>

        <div class="grid gap-3 sm:grid-cols-2 lg:col-span-8">
            @foreach($taxiRoutes as $r)
                <a href="{{ route('taxi-routes.show', $r) }}" class="group flex items-center gap-4 rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:border-saffron-400/50 hover:bg-white/10">
                    <img src="{{ $r->image_url }}" alt="{{ $r->title }}" loading="lazy" class="h-16 w-16 shrink-0 rounded-xl object-cover">
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-bold">{{ $r->from_city }} <span class="text-saffron-400">→</span> {{ $r->to_city }}</p>
                        <p class="mt-0.5 text-xs text-white/60">{{ $r->distance_km }} km • {{ $r->duration }}</p>
                    </div>
                    <i data-lucide="arrow-up-right" class="h-5 w-5 shrink-0 text-saffron-400 transition group-hover:translate-x-0.5"></i>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- =====================================================================
     TOUR PACKAGES
     ===================================================================== --}}
<section id="tours" class="bg-cream">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div class="max-w-2xl">
                <span class="dt-eyebrow">Tour packages</span>
                <h2 class="mt-3 text-3xl font-extrabold text-pine-950 sm:text-4xl">Hand-planned Himachal itineraries</h2>
                <p class="mt-3 text-stone-600">Private tours with a dedicated cab and an experienced local driver.</p>
            </div>
            <a href="{{ route('tours.index') }}" class="inline-flex shrink-0 items-center gap-1.5 text-sm font-semibold text-pine-700 hover:text-pine-900">
                All packages <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>

        <div class="dt-scroll-x -mx-4 mt-10 flex snap-x snap-mandatory gap-5 overflow-x-auto px-4 pb-4 sm:mx-0 sm:grid sm:grid-cols-2 sm:overflow-visible sm:px-0 lg:grid-cols-3">
            @forelse($packages->take(6) as $pkg)
                <article class="group flex w-[85%] shrink-0 snap-start flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-stone-200 transition hover:shadow-xl hover:shadow-pine-900/5 sm:w-auto">
                    <a href="{{ route('tours.show', $pkg->slug) }}" class="relative block aspect-[16/10] overflow-hidden bg-stone-100">
                        @if($pkg->thumbnail)
                            <img src="{{ Media::url($pkg->thumbnail) }}" alt="{{ $pkg->title }}" loading="lazy" class="dt-card-img h-full w-full object-cover">
                        @endif
                        <span class="absolute left-3 top-3 inline-flex items-center gap-1 rounded-full bg-pine-950/80 px-2.5 py-1 text-[11px] font-semibold text-white backdrop-blur">
                            <i data-lucide="clock" class="h-3 w-3 text-saffron-400"></i>{{ $pkg->duration }}
                        </span>
                    </a>
                    <div class="flex flex-1 flex-col p-5">
                        <h3 class="text-lg font-bold leading-snug text-pine-950">
                            <a href="{{ route('tours.show', $pkg->slug) }}" class="hover:text-pine-700">{{ $pkg->title }}</a>
                        </h3>
                        <p class="mt-2 line-clamp-2 text-sm text-stone-600">{{ $pkg->short_desc }}</p>
                        <div class="mt-auto flex items-end justify-between border-t border-stone-100 pt-4 mt-5">
                            <a href="{{ route('tours.show', $pkg->slug) }}" class="text-xs font-semibold text-pine-700 hover:text-pine-900">View itinerary →</a>
                            <button type="button" @click="$dispatch('open-booking', { type: 'package', package: {{ $pkg->id }} })"
                                    class="rounded-lg bg-saffron-500 px-4 py-2 text-xs font-bold text-pine-950 transition hover:bg-saffron-400">Enquire</button>
                        </div>
                    </div>
                </article>
            @empty
                <p class="w-full rounded-2xl border border-dashed border-stone-300 p-10 text-center text-sm text-stone-500 sm:col-span-full">Custom itineraries available on request.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- =====================================================================
     WHY US + HOW IT WORKS
     ===================================================================== --}}
<section class="overflow-hidden bg-white">
    <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-24">
        <div class="relative order-2 lg:order-1">
            <div class="grid grid-cols-5 grid-rows-5 gap-3" style="height: 460px">
                <img src="{{ Media::url('/images/dharamshala/dhauladhar-peaks.jpg') }}" alt="Snow-capped Dhauladhar range above Dharamshala" loading="lazy" class="col-span-3 row-span-5 h-full w-full rounded-2xl object-cover">
                <img src="{{ Media::url('/images/dharamshala/prayer-flags.jpg') }}" alt="Tibetan prayer flags in McLeodganj" loading="lazy" class="col-span-2 row-span-3 h-full w-full rounded-2xl object-cover">
                <img src="{{ Media::url('/images/dharamshala/dharamshala-tea-garden.jpg') }}" alt="Tea gardens near Dharamshala" loading="lazy" class="col-span-2 row-span-2 h-full w-full rounded-2xl object-cover">
            </div>
            <div class="absolute -bottom-5 left-6 flex items-center gap-3 rounded-2xl bg-pine-900 px-5 py-4 text-white shadow-xl">
                <i data-lucide="mountain" class="h-8 w-8 text-saffron-400"></i>
                <div>
                    <p class="text-sm font-bold">Born in the Dhauladhars</p>
                    <p class="text-xs text-white/70">Local drivers, local knowledge</p>
                </div>
            </div>
        </div>

        <div class="order-1 lg:order-2">
            <span class="dt-eyebrow">Why travel with us</span>
            <h2 class="mt-3 text-3xl font-extrabold text-pine-950 sm:text-4xl">Mountain roads need mountain drivers</h2>
            <p class="mt-4 text-stone-600">The road from Gaggal to McLeodganj gains almost a thousand metres in 22 km. Our team grew up on these roads — we know when Temple Road jams, where to park in Bhagsu and how to time Naddi for sunset.</p>

            @php
                $reasons = [
                    ['shield-check', 'Verified, experienced drivers', 'Background-checked chauffeurs with years of hill-driving experience.'],
                    ['map', 'Local route knowledge', 'We know the best times, viewpoints and parking spots across the valley.'],
                    ['clock-3', 'On time, every time', 'Flight-tracked airport pickups and early-morning trek drops.'],
                    ['headset', 'Real people, quick replies', 'Call or WhatsApp our desk from 6 AM to 11 PM.'],
                ];
            @endphp
            <ul class="mt-8 grid gap-6 sm:grid-cols-2">
                @foreach($reasons as [$icon, $title, $text])
                    <li class="flex gap-4">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-pine-50 text-pine-700"><i data-lucide="{{ $icon }}" class="h-5 w-5"></i></span>
                        <div>
                            <h3 class="font-bold text-pine-950">{{ $title }}</h3>
                            <p class="mt-1 text-sm text-stone-600">{{ $text }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="mt-10 rounded-2xl border border-stone-200 bg-cream p-6">
                <p class="text-sm font-bold text-pine-950">Book in three easy steps</p>
                <ol class="mt-4 grid gap-4 sm:grid-cols-3">
                    @foreach(['Share your trip details', 'Get a confirmation call', 'Meet your driver & go'] as $n => $step)
                        <li class="flex items-center gap-3 text-sm text-stone-700">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-saffron-500 text-sm font-extrabold text-pine-950">{{ $n + 1 }}</span>
                            {{ $step }}
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</section>

{{-- =====================================================================
     REVIEWS
     ===================================================================== --}}
@if($reviews->isNotEmpty())
<section id="reviews" class="bg-cream">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <span class="dt-eyebrow">Traveller reviews</span>
                <h2 class="mt-3 text-3xl font-extrabold text-pine-950 sm:text-4xl">What our guests say</h2>
            </div>
            <a href="{{ route('reviews.index') }}" class="inline-flex shrink-0 items-center gap-1.5 text-sm font-semibold text-pine-700 hover:text-pine-900">
                Read all & write a review <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>

        <div class="dt-scroll-x -mx-4 mt-10 flex snap-x gap-5 overflow-x-auto px-4 pb-4 sm:mx-0 sm:grid sm:grid-cols-2 sm:px-0 lg:grid-cols-3">
            @foreach($reviews as $review)
                <figure class="flex w-[85%] shrink-0 snap-start flex-col rounded-2xl bg-white p-6 ring-1 ring-stone-200 sm:w-auto">
                    <div class="flex gap-0.5 text-saffron-500" aria-label="{{ $review->rating }} out of 5 stars">
                        @for($s = 1; $s <= 5; $s++)
                            <i data-lucide="star" class="h-4 w-4 {{ $s <= $review->rating ? 'fill-current' : 'text-stone-200' }}"></i>
                        @endfor
                    </div>
                    <blockquote class="mt-4 flex-1 text-sm leading-relaxed text-stone-700">“{{ \Illuminate\Support\Str::limit($review->comment, 260) }}”</blockquote>
                    <figcaption class="mt-5 flex items-center gap-3 border-t border-stone-100 pt-4">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-pine-900 text-sm font-bold uppercase text-saffron-300">{{ mb_substr($review->customer_name, 0, 1) }}</span>
                        <div>
                            <p class="text-sm font-bold text-pine-950">{{ $review->customer_name }}</p>
                            <p class="text-xs text-stone-500">{{ $review->created_at?->format('M Y') }}</p>
                        </div>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- =====================================================================
     BLOG
     ===================================================================== --}}
@if($blogs->isNotEmpty())
<section id="blogs" class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div class="max-w-2xl">
                <span class="dt-eyebrow">Travel guides</span>
                <h2 class="mt-3 text-3xl font-extrabold text-pine-950 sm:text-4xl">Plan your Dharamshala trip</h2>
            </div>
            <a href="{{ route('blogs.public') }}" class="inline-flex shrink-0 items-center gap-1.5 text-sm font-semibold text-pine-700 hover:text-pine-900">
                All articles <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>

        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @foreach($blogs as $blog)
                <article class="group">
                    <a href="{{ route('blogs.show', ['slug' => $blog->slug]) }}" class="block aspect-[16/10] overflow-hidden rounded-2xl bg-stone-100">
                        @if($blog->image)
                            <img src="{{ Media::url($blog->image) }}" alt="{{ $blog->title }}" loading="lazy" class="dt-card-img h-full w-full object-cover">
                        @else
                            <div class="flex h-full items-center justify-center text-stone-300"><i data-lucide="image" class="h-10 w-10"></i></div>
                        @endif
                    </a>
                    <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-pine-600">{{ $blog->blog_date?->format('d M Y') }}</p>
                    <h3 class="mt-1.5 text-lg font-bold leading-snug text-pine-950">
                        <a href="{{ route('blogs.show', ['slug' => $blog->slug]) }}" class="hover:text-pine-700">{{ $blog->title }}</a>
                    </h3>
                    <p class="mt-2 line-clamp-2 text-sm text-stone-600">{{ \Illuminate\Support\Str::limit(strip_tags($blog->description), 150) }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- =====================================================================
     FAQ
     ===================================================================== --}}
<section id="faq" class="bg-cream">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-12 lg:px-8 lg:py-20">
        <div class="lg:col-span-4">
            <span class="dt-eyebrow">FAQ</span>
            <h2 class="mt-3 text-3xl font-extrabold text-pine-950 sm:text-4xl">Good to know before you travel</h2>
            <p class="mt-3 text-stone-600">Can’t find your answer? <a href="{{ route('contact') }}" class="font-semibold text-pine-700 underline underline-offset-4">Contact our travel desk</a>.</p>
        </div>
        <div class="lg:col-span-8">
            @include('partials.faq-list', ['faqs' => $faqs])
        </div>
    </div>
</section>

{{-- =====================================================================
     CTA
     ===================================================================== --}}
<section class="relative isolate overflow-hidden bg-pine-900">
    <img src="{{ Media::url('/images/dharamshala/five-towns-triund.jpg') }}" alt="" aria-hidden="true" loading="lazy" class="absolute inset-0 -z-10 h-full w-full object-cover opacity-25">
    <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-8 px-4 py-14 sm:px-6 lg:flex-row lg:items-center lg:px-8">
        <div class="max-w-2xl text-white">
            <h2 class="text-3xl font-extrabold sm:text-4xl">Landing at Gaggal soon?</h2>
            <p class="mt-3 text-white/75">Send us your flight details and we will have a driver waiting at arrivals with your name.</p>
        </div>
        <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row">
            <button type="button" @click="$dispatch('open-booking', { type: 'airport' })" class="inline-flex items-center justify-center gap-2 rounded-xl bg-saffron-500 px-6 py-3.5 text-sm font-bold text-pine-950 transition hover:bg-saffron-400">
                <i data-lucide="plane-landing" class="h-4 w-4"></i> Book airport pickup
            </button>
            <a href="tel:{{ $phoneHref }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-6 py-3.5 text-sm font-bold text-pine-950 transition hover:bg-stone-100">
                <i data-lucide="phone" class="h-4 w-4"></i> Call {{ $phone }}
            </a>
        </div>
    </div>
</section>

@endsection
