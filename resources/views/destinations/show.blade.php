@extends('layouts.site')

@section('content')

@include('partials.page-hero', [
    'eyebrow'  => $destination->category,
    'title'    => $destination->name,
    'subtitle' => $destination->tagline,
    'image'    => $destination->image,
    'crumbs'   => ['Destinations' => route('destinations.index'), $destination->name => route('destinations.show', $destination)],
])

@php
    $facts = array_filter([
        ['navigation', 'Distance', $destination->distance],
        ['mountain', 'Altitude', $destination->altitude],
        ['sun', 'Best time', $destination->best_time],
        ['clock', 'Timings', $destination->timings],
        ['ticket', 'Entry', $destination->entry_fee],
    ], fn ($f) => filled($f[2]));
    $gallery = collect($destination->gallery_urls)->reject(fn ($u) => $u === $destination->image_url)->values();
@endphp

<section class="bg-cream">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-12 lg:px-8 lg:py-16">

        <article class="lg:col-span-8">
            <p class="text-lg font-medium leading-relaxed text-pine-900">{{ $destination->short_desc }}</p>

            <div class="dt-prose mt-6 text-stone-700">
                @foreach(preg_split('/\n\s*\n/', trim($destination->description)) as $para)
                    <p>{{ $para }}</p>
                @endforeach
            </div>

            @if(!empty($destination->highlights))
                <h2 class="mt-10 text-2xl font-extrabold text-pine-950">Highlights</h2>
                <ul class="mt-4 grid gap-3 sm:grid-cols-2">
                    @foreach($destination->highlights as $h)
                        <li class="flex items-start gap-3 rounded-xl bg-white p-4 text-sm text-stone-700 ring-1 ring-stone-200">
                            <i data-lucide="check-circle-2" class="mt-0.5 h-4 w-4 shrink-0 text-pine-500"></i>{{ $h }}
                        </li>
                    @endforeach
                </ul>
            @endif

            @if($gallery->isNotEmpty())
                <h2 class="mt-10 text-2xl font-extrabold text-pine-950">Photos</h2>
                <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3">
                    @foreach($gallery as $url)
                        <img src="{{ $url }}" alt="{{ $destination->name }} — photo {{ $loop->iteration }}" loading="lazy" class="aspect-[4/3] w-full rounded-xl object-cover">
                    @endforeach
                </div>
            @endif

            @if($destination->how_to_reach)
                <h2 class="mt-10 text-2xl font-extrabold text-pine-950">How to reach</h2>
                <p class="mt-3 leading-relaxed text-stone-700">{{ $destination->how_to_reach }}</p>
            @endif

            @if($destination->latitude && $destination->longitude)
                <div class="mt-6 overflow-hidden rounded-2xl ring-1 ring-stone-200">
                    <iframe title="Map of {{ $destination->name }}" loading="lazy" class="h-72 w-full border-0" referrerpolicy="no-referrer-when-downgrade"
                            src="https://maps.google.com/maps?q={{ $destination->latitude }},{{ $destination->longitude }}&z=14&output=embed"></iframe>
                </div>
            @endif
        </article>

        <aside class="lg:col-span-4">
            <div class="sticky top-24 space-y-6">
                <div class="rounded-2xl bg-white p-6 ring-1 ring-stone-200">
                    <h2 class="text-lg font-extrabold text-pine-950">Quick facts</h2>
                    <dl class="mt-4 space-y-4">
                        @foreach($facts as [$icon, $label, $value])
                            <div class="flex gap-3">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-pine-50 text-pine-700"><i data-lucide="{{ $icon }}" class="h-4 w-4"></i></span>
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">{{ $label }}</dt>
                                    <dd class="text-sm font-medium text-stone-800">{{ $value }}</dd>
                                </div>
                            </div>
                        @endforeach
                    </dl>
                    <p class="mt-4 text-[11px] text-stone-400">Timings and fees are indicative and may change — please check locally.</p>
                </div>

                <div class="rounded-2xl bg-pine-900 p-6 text-white">
                    <h2 class="text-lg font-extrabold">Visit {{ $destination->name }} by cab</h2>
                    <p class="mt-2 text-sm text-white/75">Private taxi with a local driver — pickup from your hotel, airport or station.</p>
                    <button type="button" @click="$dispatch('open-booking', { type: 'local', drop: @js($destination->name) })"
                            class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-saffron-500 px-5 py-3 text-sm font-bold text-pine-950 transition hover:bg-saffron-400">
                        <i data-lucide="car-front" class="h-4 w-4"></i> Book a cab here
                    </button>
                </div>
            </div>
        </aside>
    </div>
</section>

@if($related->isNotEmpty())
<section class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-extrabold text-pine-950">More places nearby</h2>
        <div class="mt-6 grid gap-6 sm:grid-cols-3">
            @foreach($related as $place)
                <a href="{{ route('destinations.show', $place) }}" class="group relative block aspect-[4/3] overflow-hidden rounded-2xl">
                    <img src="{{ $place->image_url }}" alt="{{ $place->name }}" loading="lazy" class="dt-card-img absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-pine-950/85 to-transparent"></div>
                    <div class="absolute bottom-0 p-5 text-white">
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-saffron-300">{{ $place->category }}</p>
                        <h3 class="text-lg font-bold">{{ $place->name }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
