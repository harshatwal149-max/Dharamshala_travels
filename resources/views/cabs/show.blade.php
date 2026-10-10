@extends('layouts.site')

@use('App\Support\Media')

@php
    $fallback = Media::url('/images/dharamshala/car-dzire.jpg');
    $gallery = $images->isNotEmpty() ? $images : collect([$fallback]);
    $features = is_array($vehicle->features) ? $vehicle->features : (json_decode((string) $vehicle->features, true) ?: []);
    $seats = (int) $vehicle->seating_capacity;
    $idealFor = $seats >= 8
        ? ['Group tours & family get-togethers', 'Corporate & school trips', 'Pilgrimage circuits', 'Long outstation journeys']
        : ($seats >= 6
            ? ['Families with luggage', 'Long outstation drives', 'Dalhousie, Manali & Shimla trips', 'Comfortable hill-road travel']
            : ['Couples & solo travellers', 'Gaggal Airport transfers', 'McLeodganj local sightseeing', 'Short day trips']);
@endphp

@section('content')

{{-- Title bar --}}
<section class="border-b border-stone-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <nav aria-label="Breadcrumb" class="flex flex-wrap items-center gap-1.5 text-xs font-medium text-stone-500">
            <a href="{{ url('/') }}" class="hover:text-pine-800">Home</a>
            <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
            <a href="{{ route('cabs.index') }}" class="hover:text-pine-800">Book a Cab</a>
            <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
            <span class="text-pine-900" aria-current="page">{{ $vehicle->name }}</span>
        </nav>
        <div class="mt-4 flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="rounded-full bg-pine-50 px-3 py-1 text-xs font-bold uppercase tracking-wide text-pine-700">{{ $vehicle->category }}</span>
                    @if($vehicle->badge)
                        <span class="rounded-full bg-saffron-500 px-3 py-1 text-xs font-bold text-pine-950">{{ $vehicle->badge }}</span>
                    @endif
                </div>
                <h1 class="mt-3 text-3xl font-extrabold text-pine-950 sm:text-4xl">{{ $vehicle->name }} Taxi in Dharamshala</h1>
            </div>
            <div class="flex flex-wrap gap-4 text-sm text-stone-600">
                <span class="flex items-center gap-1.5"><i data-lucide="users" class="h-4 w-4 text-pine-500"></i>{{ $vehicle->seating_capacity }} seats</span>
                <span class="flex items-center gap-1.5"><i data-lucide="briefcase" class="h-4 w-4 text-pine-500"></i>{{ $vehicle->luggage_capacity }} bags</span>
                <span class="flex items-center gap-1.5"><i data-lucide="snowflake" class="h-4 w-4 text-pine-500"></i>Air conditioned</span>
            </div>
        </div>
    </div>
</section>

<section class="bg-cream">
    <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 lg:grid-cols-12 lg:px-8 lg:py-14">

        {{-- Left --}}
        <div class="space-y-8 lg:col-span-8">

            {{-- Gallery --}}
            <div x-data="{ active: 0, images: @js($gallery->values()) }" class="overflow-hidden rounded-3xl bg-white ring-1 ring-stone-200">
                <div class="relative aspect-[16/10] bg-stone-100">
                    <template x-for="(src, i) in images" :key="i">
                        <img :src="src" alt="{{ $vehicle->name }}" x-show="active === i" x-transition.opacity
                             class="absolute inset-0 h-full w-full object-cover"
                             onerror="this.onerror=null; this.src=@js($fallback)">
                    </template>
                    <noscript><img src="{{ $gallery->first() }}" alt="{{ $vehicle->name }}" class="absolute inset-0 h-full w-full object-cover"></noscript>
                    @if($gallery->count() > 1)
                        <button type="button" @click="active = (active - 1 + images.length) % images.length" class="absolute left-3 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-pine-900 shadow hover:bg-white" aria-label="Previous photo">
                            <i data-lucide="chevron-left" class="h-5 w-5"></i>
                        </button>
                        <button type="button" @click="active = (active + 1) % images.length" class="absolute right-3 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-pine-900 shadow hover:bg-white" aria-label="Next photo">
                            <i data-lucide="chevron-right" class="h-5 w-5"></i>
                        </button>
                    @endif
                </div>
                @if($gallery->count() > 1)
                    <div class="flex gap-2 overflow-x-auto p-3 dt-scroll-x">
                        @foreach($gallery as $i => $src)
                            <button type="button" @click="active = {{ $i }}" class="h-16 w-24 shrink-0 overflow-hidden rounded-xl ring-2 transition"
                                    :class="active === {{ $i }} ? 'ring-saffron-500' : 'ring-transparent opacity-70 hover:opacity-100'" aria-label="Photo {{ $i + 1 }}">
                                <img src="{{ $src }}" alt="" loading="lazy" class="h-full w-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Specs --}}
            <div class="rounded-3xl bg-white p-6 ring-1 ring-stone-200 sm:p-8">
                <h2 class="text-xl font-extrabold text-pine-950">Vehicle details</h2>
                <dl class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-4">
                    @foreach([
                        ['car-front', 'Type', $vehicle->category],
                        ['users', 'Seats', $vehicle->seating_capacity . ' passengers'],
                        ['briefcase', 'Luggage', $vehicle->luggage_capacity . ' bags'],
                        ['user-check', 'Driver', 'Local hill driver'],
                    ] as [$icon, $label, $value])
                        <div class="rounded-2xl bg-cream p-4">
                            <dt class="flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wide text-stone-500"><i data-lucide="{{ $icon }}" class="h-4 w-4 text-pine-500"></i>{{ $label }}</dt>
                            <dd class="mt-1.5 font-bold text-pine-950">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>

                @if($features)
                    <h3 class="mt-8 font-extrabold text-pine-950">Features</h3>
                    <ul class="mt-3 grid gap-2.5 sm:grid-cols-2">
                        @foreach($features as $feature)
                            <li class="flex items-start gap-2.5 text-sm text-stone-700"><i data-lucide="check-circle-2" class="mt-0.5 h-4 w-4 shrink-0 text-pine-500"></i>{{ $feature }}</li>
                        @endforeach
                    </ul>
                @endif

                <h3 class="mt-8 font-extrabold text-pine-950">Ideal for</h3>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach($idealFor as $use)
                        <span class="rounded-full bg-pine-50 px-3 py-1.5 text-xs font-semibold text-pine-800">{{ $use }}</span>
                    @endforeach
                </div>
            </div>

            {{-- Routes --}}
            @if($routes->isNotEmpty())
                <div class="rounded-3xl bg-white p-6 ring-1 ring-stone-200 sm:p-8">
                    <h2 class="text-xl font-extrabold text-pine-950">Popular trips in the {{ $vehicle->name }}</h2>
                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        @foreach($routes as $r)
                            <button type="button" @click="$dispatch('open-booking', { type: @js(str_contains($r->from_city, 'Airport') ? 'airport' : 'outstation'), vehicle: {{ $vehicle->id }}, pickup: @js($r->from_city), drop: @js($r->to_city) })"
                                    class="group flex items-center gap-3 rounded-2xl p-3 text-left ring-1 ring-stone-200 transition hover:bg-pine-50 hover:ring-pine-300">
                                <img src="{{ $r->image_url }}" alt="" loading="lazy" class="h-12 w-12 shrink-0 rounded-xl object-cover">
                                <span class="min-w-0 flex-1">
                                    <span class="block truncate text-sm font-bold text-pine-950">{{ $r->from_city }} → {{ $r->to_city }}</span>
                                    <span class="block text-xs text-stone-500">{{ $r->distance_km }} km • {{ $r->duration }}</span>
                                </span>
                                <span class="text-xs font-semibold text-pine-700 group-hover:text-pine-900">Book →</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- FAQ --}}
            <div>
                <h2 class="text-xl font-extrabold text-pine-950">Frequently asked questions</h2>
                <div class="mt-4">@include('partials.faq-list', ['faqs' => $faqs])</div>
            </div>
        </div>

        {{-- Right: booking --}}
        <aside class="lg:col-span-4">
            <div class="sticky top-24 space-y-5">
                <div class="rounded-3xl bg-pine-900 p-6 text-white">
                    <h2 class="text-xl font-extrabold">Book the {{ $vehicle->name }}</h2>
                    <p class="mt-2 text-sm text-white/75">Send a request — our travel desk calls you to confirm pickup details.</p>
                    <div class="mt-5 grid gap-2">
                        @foreach([['plane-landing', 'Airport transfer', 'airport'], ['map', 'Local sightseeing', 'local'], ['route', 'Outstation trip', 'outstation']] as [$icon, $label, $type])
                            <button type="button" @click="$dispatch('open-booking', { type: @js($type), vehicle: {{ $vehicle->id }} })"
                                    class="flex items-center justify-between rounded-xl bg-white/10 px-4 py-3 text-sm font-semibold transition hover:bg-white/15">
                                <span class="flex items-center gap-2.5"><i data-lucide="{{ $icon }}" class="h-4 w-4 text-saffron-400"></i>{{ $label }}</span>
                                <i data-lucide="chevron-right" class="h-4 w-4 text-white/60"></i>
                            </button>
                        @endforeach
                    </div>
                    <button type="button" @click="$dispatch('open-booking', { type: 'outstation', vehicle: {{ $vehicle->id }} })"
                            class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-saffron-500 px-5 py-3.5 text-sm font-bold text-pine-950 transition hover:bg-saffron-400">
                        <i data-lucide="calendar-check" class="h-4 w-4"></i> Book this cab
                    </button>
                </div>

                <div class="rounded-3xl bg-white p-6 ring-1 ring-stone-200">
                    <h2 class="font-extrabold text-pine-950">Every booking includes</h2>
                    <ul class="mt-4 space-y-3 text-sm text-stone-700">
                        @foreach(['Clean, sanitised AC cab', 'Experienced local hill driver', 'Doorstep pickup & drop', 'Booking confirmed by phone'] as $inc)
                            <li class="flex items-center gap-2.5"><i data-lucide="check" class="h-4 w-4 text-pine-500"></i>{{ $inc }}</li>
                        @endforeach
                    </ul>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', \App\Models\Setting::get('contact_phone') ?: '+91 98765 43210') }}"
                       class="mt-5 flex items-center justify-center gap-2 rounded-xl px-4 py-3 text-sm font-semibold text-pine-800 ring-1 ring-stone-200 hover:bg-stone-50">
                        <i data-lucide="phone" class="h-4 w-4"></i> Call {{ \App\Models\Setting::get('contact_phone') ?: '+91 98765 43210' }}
                    </a>
                </div>
            </div>
        </aside>
    </div>
</section>

{{-- Other cabs --}}
@if($relatedVehicles->isNotEmpty())
<section class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between gap-4">
            <h2 class="text-2xl font-extrabold text-pine-950 sm:text-3xl">Other cabs in our fleet</h2>
            <a href="{{ route('cabs.index') }}" class="inline-flex shrink-0 items-center gap-1.5 text-sm font-semibold text-pine-700 hover:text-pine-900">All cabs <i data-lucide="arrow-right" class="h-4 w-4"></i></a>
        </div>
        <div class="mt-8 grid gap-6 sm:grid-cols-3">
            @foreach($relatedVehicles as $rel)
                <a href="{{ route('cabs.show', $rel->slug) }}" class="group overflow-hidden rounded-2xl bg-white ring-1 ring-stone-200 transition hover:shadow-xl hover:shadow-pine-900/10">
                    <div class="aspect-[4/3] overflow-hidden bg-stone-100">
                        <img src="{{ Media::url($rel->image) ?: $fallback }}" alt="{{ $rel->name }}" loading="lazy" class="dt-card-img h-full w-full object-cover"
                             onerror="this.onerror=null; this.src=@js($fallback)">
                    </div>
                    <div class="p-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-pine-600">{{ $rel->category }}</p>
                        <h3 class="mt-1 text-lg font-bold text-pine-950">{{ $rel->name }}</h3>
                        <p class="mt-2 flex gap-4 text-xs text-stone-500">
                            <span class="flex items-center gap-1"><i data-lucide="users" class="h-3.5 w-3.5"></i>{{ $rel->seating_capacity }} seats</span>
                            <span class="flex items-center gap-1"><i data-lucide="briefcase" class="h-3.5 w-3.5"></i>{{ $rel->luggage_capacity }} bags</span>
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
