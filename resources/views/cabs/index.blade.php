@extends('layouts.site')

@use('App\Support\Media')

@section('content')

@include('partials.page-hero', [
    'eyebrow'  => 'Our fleet',
    'title'    => 'Book a Cab in Dharamshala',
    'subtitle' => 'Clean, air-conditioned cars with experienced hill drivers — for Gaggal Airport transfers, McLeodganj sightseeing and outstation trips across Himachal.',
    'image'    => '/images/dharamshala/dhauladhar-alpenglow.jpg',
    'crumbs'   => ['Book a Cab' => route('cabs.index')],
])

{{-- Trip types --}}
<section class="border-b border-stone-200 bg-white">
    <div class="mx-auto grid max-w-7xl grid-cols-2 gap-3 px-4 py-6 sm:px-6 lg:grid-cols-4 lg:px-8">
        @foreach([
            ['plane-landing', 'Airport transfer', 'airport', 'Gaggal Airport (DHM)'],
            ['map', 'Local sightseeing', 'local', null],
            ['route', 'Outstation trip', 'outstation', 'Dharamshala'],
            ['mountain-snow', 'Tour package', 'package', null],
        ] as [$icon, $label, $type, $pickup])
            <button type="button" @click="$dispatch('open-booking', @js(array_filter(['type' => $type, 'pickup' => $pickup])))"
                    class="group flex items-center gap-3 rounded-2xl p-3 text-left ring-1 ring-stone-200 transition hover:bg-pine-50 hover:ring-pine-300">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-pine-900 text-saffron-400 transition group-hover:bg-saffron-500 group-hover:text-pine-950"><i data-lucide="{{ $icon }}" class="h-5 w-5"></i></span>
                <span class="min-w-0">
                    <span class="block text-sm font-bold text-pine-950">{{ $label }}</span>
                    <span class="block text-xs text-stone-500">Book now →</span>
                </span>
            </button>
        @endforeach
    </div>
</section>

{{-- Fleet --}}
<section class="bg-cream">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="max-w-2xl">
            <span class="dt-eyebrow">{{ $vehicles->count() }} {{ \Illuminate\Support\Str::plural('vehicle', $vehicles->count()) }} available</span>
            <h2 class="mt-2 text-2xl font-extrabold text-pine-950 sm:text-3xl">Choose the right cab for your trip</h2>
            <p class="mt-2 text-stone-600">Every car is serviced for mountain driving and comes with a local driver who knows the hairpins, one-ways and parking spots.</p>
        </div>

        <div class="mt-8 grid gap-6 md:grid-cols-2">
            @forelse($vehicles as $cab)
                @php
                    $features = array_slice(is_array($cab->features) ? $cab->features : (json_decode((string) $cab->features, true) ?: []), 0, 4);
                @endphp
                <article class="group grid overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-stone-200 transition hover:shadow-xl hover:shadow-pine-900/10 sm:grid-cols-5">
                    <a href="{{ route('cabs.show', $cab->slug) }}" class="relative block aspect-[4/3] overflow-hidden bg-stone-100 sm:col-span-2 sm:aspect-auto">
                        @if($cab->image)
                            <img src="{{ Media::url($cab->image) }}" alt="{{ $cab->name }} cab in Dharamshala" loading="lazy"
                                 class="dt-card-img absolute inset-0 h-full w-full object-cover"
                                 onerror="this.onerror=null; this.src=@js(Media::url('/images/dharamshala/car-dzire.jpg'))">
                        @endif
                        @if($cab->badge)
                            <span class="absolute left-3 top-3 rounded-full bg-saffron-500 px-2.5 py-1 text-[11px] font-bold text-pine-950">{{ $cab->badge }}</span>
                        @endif
                    </a>

                    <div class="flex flex-col p-5 sm:col-span-3 sm:p-6">
                        <p class="text-xs font-semibold uppercase tracking-wider text-pine-600">{{ $cab->category }}</p>
                        <h3 class="mt-1 text-xl font-extrabold text-pine-950">
                            <a href="{{ route('cabs.show', $cab->slug) }}" class="hover:text-pine-700">{{ $cab->name }}</a>
                        </h3>

                        <dl class="mt-4 grid grid-cols-3 gap-2 text-center">
                            <div class="rounded-xl bg-stone-50 px-2 py-2.5">
                                <dt class="flex justify-center text-pine-500"><i data-lucide="users" class="h-4 w-4"></i></dt>
                                <dd class="mt-1 text-xs font-semibold text-stone-700">{{ $cab->seating_capacity }} seats</dd>
                            </div>
                            <div class="rounded-xl bg-stone-50 px-2 py-2.5">
                                <dt class="flex justify-center text-pine-500"><i data-lucide="briefcase" class="h-4 w-4"></i></dt>
                                <dd class="mt-1 text-xs font-semibold text-stone-700">{{ $cab->luggage_capacity }} bags</dd>
                            </div>
                            <div class="rounded-xl bg-stone-50 px-2 py-2.5">
                                <dt class="flex justify-center text-pine-500"><i data-lucide="snowflake" class="h-4 w-4"></i></dt>
                                <dd class="mt-1 text-xs font-semibold text-stone-700">AC</dd>
                            </div>
                        </dl>

                        @if($features)
                            <ul class="mt-4 grid gap-1.5 text-sm text-stone-600">
                                @foreach($features as $feature)
                                    <li class="flex items-start gap-2"><i data-lucide="check" class="mt-0.5 h-4 w-4 shrink-0 text-pine-500"></i>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="mt-auto grid grid-cols-2 gap-2 pt-5">
                            <a href="{{ route('cabs.show', $cab->slug) }}" class="flex items-center justify-center gap-1 rounded-xl px-3 py-2.5 text-sm font-semibold text-pine-800 ring-1 ring-stone-200 transition hover:bg-stone-50">
                                Details <i data-lucide="chevron-right" class="h-4 w-4"></i>
                            </a>
                            <button type="button" @click="$dispatch('open-booking', { type: 'outstation', vehicle: {{ $cab->id }} })"
                                    class="flex items-center justify-center gap-1.5 rounded-xl bg-saffron-500 px-3 py-2.5 text-sm font-bold text-pine-950 transition hover:bg-saffron-400">
                                <i data-lucide="calendar-check" class="h-4 w-4"></i> Book
                            </button>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-stone-300 bg-white p-12 text-center">
                    <i data-lucide="car-front" class="mx-auto h-12 w-12 text-stone-300"></i>
                    <h3 class="mt-3 font-bold text-pine-950">Fleet update in progress</h3>
                    <p class="mt-1 text-sm text-stone-500">Call or WhatsApp us and we will arrange a cab for you.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Which cab --}}
<section class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
        <span class="dt-eyebrow">Quick guide</span>
        <h2 class="mt-3 text-2xl font-extrabold text-pine-950 sm:text-3xl">Which cab is right for you?</h2>
        <div class="mt-8 grid gap-5 md:grid-cols-3">
            @foreach([
                ['car-front', 'Sedan', 'Swift Dzire / Etios', '1–4 passengers', 'Couples, solo travellers and small families on local sightseeing or airport runs.'],
                ['car', 'SUV', 'Toyota Innova Crysta', '5–6 passengers', 'Families with luggage, long outstation drives and the most comfortable ride on hill roads.'],
                ['bus', 'Tempo Traveller', 'Force 12-Seater', '7–12 passengers', 'Groups, family get-togethers and corporate trips travelling together.'],
            ] as [$icon, $label, $models, $pax, $best])
                <div class="rounded-2xl bg-cream p-6 ring-1 ring-stone-200">
                    <div class="flex items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-pine-900 text-saffron-400"><i data-lucide="{{ $icon }}" class="h-5 w-5"></i></span>
                        <div>
                            <h3 class="font-extrabold text-pine-950">{{ $label }}</h3>
                            <p class="text-xs text-stone-500">{{ $models }}</p>
                        </div>
                    </div>
                    <p class="mt-4 inline-flex items-center gap-1.5 rounded-full bg-white px-3 py-1 text-xs font-semibold text-pine-800 ring-1 ring-stone-200"><i data-lucide="users" class="h-3.5 w-3.5"></i>{{ $pax }}</p>
                    <p class="mt-3 text-sm leading-relaxed text-stone-600">{{ $best }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="bg-cream">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-12 lg:px-8 lg:py-20">
        <div class="lg:col-span-4">
            <span class="dt-eyebrow">FAQ</span>
            <h2 class="mt-3 text-3xl font-extrabold text-pine-950">Cab booking questions</h2>
            <p class="mt-3 text-stone-600">See also our <a href="{{ route('airport-taxi') }}" class="font-semibold text-pine-700 underline underline-offset-4">Gaggal Airport taxi</a> and <a href="{{ route('taxi-routes.index') }}" class="font-semibold text-pine-700 underline underline-offset-4">taxi routes</a>.</p>
        </div>
        <div class="lg:col-span-8">
            @include('partials.faq-list', ['faqs' => $faqs])
        </div>
    </div>
</section>

@include('partials.cta-band', [
    'heading' => 'Need a cab today?',
    'text'    => 'Send a booking request in under a minute — our desk confirms by phone.',
    'type'    => 'local',
    'button'  => 'Book a cab now',
])

@endsection
