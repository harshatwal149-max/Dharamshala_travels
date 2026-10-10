@extends('layouts.site')

@use('App\Support\Media')

@php
    $types = $packages->getCollection()->pluck('trip_type')->unique()->sort()->values();
@endphp

@section('content')

@include('partials.page-hero', [
    'eyebrow'  => 'Private tours from Dharamshala',
    'title'    => 'Himachal Tour Packages',
    'subtitle' => 'Hand-planned sightseeing tours, treks and road trips with a dedicated cab and an experienced local driver — customised to your dates and group.',
    'image'    => '/images/dharamshala/kangra-tea-garden.jpg',
    'crumbs'   => ['Tour Packages' => route('tours.index')],
])

{{-- Trust strip --}}
<section class="border-b border-stone-200 bg-white">
    <div class="mx-auto grid max-w-7xl grid-cols-2 gap-4 px-4 py-6 sm:px-6 lg:grid-cols-4 lg:px-8">
        @foreach([
            ['car-front', 'Private cab & driver', 'For your group only'],
            ['map', 'Local route experts', 'Born on these mountain roads'],
            ['sliders-horizontal', 'Fully customisable', 'Change days, stops & hotels'],
            ['phone-call', 'Free enquiry', 'We call back within minutes'],
        ] as [$icon, $label, $sub])
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-pine-50 text-pine-700"><i data-lucide="{{ $icon }}" class="h-5 w-5"></i></span>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-pine-950">{{ $label }}</p>
                    <p class="text-xs text-stone-500">{{ $sub }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- Packages --}}
<section class="bg-cream" x-data="{ filter: 'All' }">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="flex flex-col justify-between gap-5 md:flex-row md:items-end">
            <div>
                <span class="dt-eyebrow">{{ $packages->total() }} {{ \Illuminate\Support\Str::plural('package', $packages->total()) }}</span>
                <h2 class="mt-2 text-2xl font-extrabold text-pine-950 sm:text-3xl">Choose your Himachal experience</h2>
            </div>
            @if($types->count() > 1)
                <div class="dt-scroll-x -mx-4 flex gap-2 overflow-x-auto px-4 md:mx-0 md:px-0">
                    @foreach($types->prepend('All') as $type)
                        <button type="button" @click="filter = @js($type)"
                                :class="filter === @js($type) ? 'bg-pine-900 text-white' : 'bg-white text-stone-600 ring-1 ring-stone-200 hover:ring-pine-300'"
                                class="whitespace-nowrap rounded-full px-4 py-2 text-sm font-semibold transition">{{ $type }}</button>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($packages as $pkg)
                @php
                    $inclusions = array_slice($pkg->inclusion_list, 0, 3);
                @endphp
                <article x-show="filter === 'All' || filter === @js($pkg->trip_type)" x-transition.opacity
                         class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-stone-200 transition hover:-translate-y-1 hover:shadow-xl hover:shadow-pine-900/10">
                    <a href="{{ route('tours.show', $pkg->slug) }}" class="relative block aspect-[16/10] overflow-hidden bg-stone-100">
                        @if($pkg->thumbnail)
                            <img src="{{ Media::url($pkg->thumbnail) }}" alt="{{ $pkg->title }}" loading="lazy"
                                 class="dt-card-img h-full w-full object-cover"
                                 onerror="this.onerror=null; this.src=@js(Media::url('/images/dharamshala/dhauladhar-alpenglow.jpg'))">
                        @else
                            <div class="flex h-full items-center justify-center text-stone-300"><i data-lucide="mountain-snow" class="h-12 w-12"></i></div>
                        @endif
                        <div class="absolute inset-x-0 top-0 flex items-start justify-between p-3">
                            <span class="inline-flex items-center gap-1 rounded-full bg-pine-950/80 px-2.5 py-1 text-[11px] font-semibold text-white backdrop-blur">
                                <i data-lucide="clock" class="h-3 w-3 text-saffron-400"></i>{{ $pkg->duration ?: 'Flexible' }}
                            </span>
                            <span class="rounded-full bg-white/90 px-2.5 py-1 text-[11px] font-bold text-pine-800">{{ $pkg->trip_type }}</span>
                        </div>
                    </a>

                    <div class="flex flex-1 flex-col p-5">
                        <h3 class="text-lg font-bold leading-snug text-pine-950">
                            <a href="{{ route('tours.show', $pkg->slug) }}" class="hover:text-pine-700">{{ $pkg->title }}</a>
                        </h3>
                        @if($pkg->short_desc)
                            <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-stone-600">{{ $pkg->short_desc }}</p>
                        @endif

                        @if($inclusions)
                            <ul class="mt-4 space-y-1.5">
                                @foreach($inclusions as $inc)
                                    <li class="flex items-start gap-2 text-xs text-stone-600">
                                        <i data-lucide="check" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-pine-500"></i>{{ $inc }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="mt-auto grid grid-cols-2 gap-2 pt-5">
                            <a href="{{ route('tours.show', $pkg->slug) }}"
                               class="flex items-center justify-center gap-1 rounded-xl px-3 py-2.5 text-sm font-semibold text-pine-800 ring-1 ring-stone-200 transition hover:bg-stone-50">
                                Itinerary <i data-lucide="chevron-right" class="h-4 w-4"></i>
                            </a>
                            <button type="button" @click="$dispatch('open-booking', { type: 'package', package: {{ $pkg->id }} })"
                                    class="flex items-center justify-center gap-1.5 rounded-xl bg-saffron-500 px-3 py-2.5 text-sm font-bold text-pine-950 transition hover:bg-saffron-400">
                                <i data-lucide="send" class="h-4 w-4"></i> Enquire
                            </button>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-stone-300 bg-white p-12 text-center">
                    <i data-lucide="compass" class="mx-auto h-12 w-12 text-stone-300"></i>
                    <h3 class="mt-3 font-bold text-pine-950">New packages coming soon</h3>
                    <p class="mt-1 text-sm text-stone-500">Our travel desk can plan a custom itinerary for you right now.</p>
                    <button type="button" @click="$dispatch('open-booking', { type: 'package' })" class="mt-5 rounded-xl bg-pine-900 px-5 py-2.5 text-sm font-semibold text-white">Plan a custom tour</button>
                </div>
            @endforelse
        </div>

        @include('partials.pagination', ['paginator' => $packages])
    </div>
</section>

{{-- Custom tour --}}
<section class="bg-white">
    <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-14 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-20">
        <div class="grid grid-cols-2 gap-3">
            <img src="{{ Media::url('/images/dharamshala/khajjiar.jpg') }}" alt="Khajjiar meadow near Dalhousie" loading="lazy" class="aspect-[4/5] w-full rounded-2xl object-cover">
            <div class="grid gap-3">
                <img src="{{ Media::url('/images/dharamshala/bir-paragliding.jpg') }}" alt="Paragliding at Bir Billing" loading="lazy" class="aspect-[4/3] w-full rounded-2xl object-cover">
                <img src="{{ Media::url('/images/dharamshala/namgyal-temple.jpg') }}" alt="Namgyal Monastery, McLeodganj" loading="lazy" class="aspect-[4/3] w-full rounded-2xl object-cover">
            </div>
        </div>
        <div>
            <span class="dt-eyebrow">Tailor-made trips</span>
            <h2 class="mt-3 text-3xl font-extrabold text-pine-950 sm:text-4xl">Make your own tour package</h2>
            <p class="mt-4 text-stone-600">We invite you to “make your own” tour package as you like — tell us your dates, group size and the places you want to see, and we will get back with the driving and tour details.</p>
            <p class="mt-3 text-stone-600">Be sure of our best price policy: as a registered union we follow proper guidelines on tour costs. There is no middle-man and hence no commission. We can provide a taxi for every trip.</p>
            <ul class="mt-6 grid gap-3 sm:grid-cols-2">
                @foreach(['Best price policy', 'No middle-man, no commission', 'Registered taxi union', 'Honeymoon, family & pilgrimage trips'] as $idea)
                    <li class="flex items-center gap-2.5 text-sm font-medium text-stone-700"><i data-lucide="check-circle-2" class="h-4 w-4 text-pine-500"></i>{{ $idea }}</li>
                @endforeach
            </ul>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <button type="button" @click="$dispatch('open-booking', { type: 'package' })"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-saffron-500 px-6 py-3.5 text-sm font-bold text-pine-950 transition hover:bg-saffron-400">
                    <i data-lucide="sparkles" class="h-4 w-4"></i> Plan my custom tour
                </button>
                <a href="{{ route('destinations.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3.5 text-sm font-semibold text-pine-800 ring-1 ring-stone-200 transition hover:bg-stone-50">
                    Explore destinations
                </a>
            </div>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="bg-cream">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-12 lg:px-8 lg:py-20">
        <div class="lg:col-span-4">
            <span class="dt-eyebrow">FAQ</span>
            <h2 class="mt-3 text-3xl font-extrabold text-pine-950">Tour package questions</h2>
            <p class="mt-3 text-stone-600">Anything else? <a href="{{ route('contact') }}" class="font-semibold text-pine-700 underline underline-offset-4">Talk to our travel desk</a>.</p>
        </div>
        <div class="lg:col-span-8">
            @include('partials.faq-list', ['faqs' => $faqs])
        </div>
    </div>
</section>

@endsection
