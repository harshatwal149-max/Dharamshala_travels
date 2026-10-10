@extends('layouts.site')

@section('content')

@include('partials.page-hero', [
    'eyebrow'  => $route->distance_km . ' km • ' . $route->duration,
    'title'    => $route->from_city . ' to ' . $route->to_city . ' Taxi',
    'subtitle' => $route->short_desc,
    'image'    => $route->image,
    'crumbs'   => ['Taxi Routes' => route('taxi-routes.index'), $route->title => route('taxi-routes.show', $route)],
])

@php
    $bookType = str_contains($route->from_city, 'Airport') ? 'airport' : 'outstation';
@endphp

<section class="bg-cream">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-12 lg:px-8 lg:py-16">
        <div class="lg:col-span-8">
            <h2 class="text-2xl font-extrabold text-pine-950">Choose your cab</h2>
            <div class="mt-5 grid gap-4 sm:grid-cols-3">
                @foreach([
                    ['car-front', 'Sedan', 'Swift Dzire / Etios', '4 passengers • 2–3 bags'],
                    ['car', 'SUV', 'Toyota Innova Crysta', '6 passengers • 4 bags'],
                    ['bus', 'Tempo Traveller', 'Force 12-Seater', '12 passengers • group luggage'],
                ] as [$icon, $label, $models, $capacity])
                    <div class="flex flex-col rounded-2xl bg-white p-5 ring-1 ring-stone-200">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-pine-50 text-pine-700"><i data-lucide="{{ $icon }}" class="h-5 w-5"></i></span>
                        <p class="mt-4 text-lg font-extrabold text-pine-950">{{ $label }}</p>
                        <p class="text-sm text-stone-600">{{ $models }}</p>
                        <p class="mt-1 text-xs text-stone-500">{{ $capacity }}</p>
                        <button type="button" @click="$dispatch('open-booking', { type: @js($bookType), pickup: @js($route->from_city), drop: @js($route->to_city) })"
                                class="mt-5 rounded-xl bg-pine-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-pine-800">Book {{ $label }}</button>
                    </div>
                @endforeach
            </div>

            <h2 class="mt-12 text-2xl font-extrabold text-pine-950">About the journey</h2>
            <div class="dt-prose mt-4 text-stone-700">
                @foreach(preg_split('/\n\s*\n/', trim($route->description)) as $para)
                    <p>{{ $para }}</p>
                @endforeach
            </div>

            @if(!empty($route->highlights))
                <ul class="mt-6 grid gap-3 sm:grid-cols-3">
                    @foreach($route->highlights as $h)
                        <li class="flex items-start gap-2.5 rounded-xl bg-white p-4 text-sm text-stone-700 ring-1 ring-stone-200">
                            <i data-lucide="map-pin" class="mt-0.5 h-4 w-4 shrink-0 text-saffron-600"></i>{{ $h }}
                        </li>
                    @endforeach
                </ul>
            @endif

            <h2 class="mt-12 text-2xl font-extrabold text-pine-950">Frequently asked questions</h2>
            <div class="mt-5">
                @include('partials.faq-list', ['faqs' => $faqs])
            </div>
        </div>

        <aside class="lg:col-span-4">
            <div class="sticky top-24 space-y-6">
                <div class="rounded-2xl bg-pine-900 p-6 text-white">
                    <h2 class="text-lg font-extrabold">Every trip includes</h2>
                    <ul class="mt-4 space-y-3 text-sm text-white/85">
                        @foreach(['Clean AC cab & experienced hill driver', 'Fuel and driver allowance', 'Doorstep pickup & drop', 'Booking confirmed by phone'] as $inc)
                            <li class="flex items-start gap-2.5"><i data-lucide="check" class="mt-0.5 h-4 w-4 shrink-0 text-saffron-400"></i>{{ $inc }}</li>
                        @endforeach
                    </ul>
                    <button type="button" @click="$dispatch('open-booking', { type: @js($bookType), pickup: @js($route->from_city), drop: @js($route->to_city) })"
                            class="mt-6 flex w-full items-center justify-center gap-2 rounded-xl bg-saffron-500 px-5 py-3 text-sm font-bold text-pine-950 transition hover:bg-saffron-400">
                        <i data-lucide="calendar-check" class="h-4 w-4"></i> Book this route
                    </button>
                </div>

                @if($otherRoutes->isNotEmpty())
                    <div class="rounded-2xl bg-white p-6 ring-1 ring-stone-200">
                        <h2 class="text-lg font-extrabold text-pine-950">Other popular routes</h2>
                        <ul class="mt-4 divide-y divide-stone-100">
                            @foreach($otherRoutes as $r)
                                <li>
                                    <a href="{{ route('taxi-routes.show', $r) }}" class="flex items-center justify-between gap-3 py-3 text-sm hover:text-pine-700">
                                        <span class="font-medium">{{ $r->from_city }} → {{ $r->to_city }}</span>
                                        <i data-lucide="chevron-right" class="h-4 w-4 shrink-0 text-pine-500"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </aside>
    </div>
</section>

@endsection
