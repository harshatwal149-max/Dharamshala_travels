@extends('layouts.site')

@section('content')

@include('partials.page-hero', [
    'eyebrow'  => 'Outstation & airport cabs',
    'title'    => 'Taxi Routes from Dharamshala',
    'subtitle' => 'Airport transfers and outstation cabs to Manali, Shimla, Dalhousie, Amritsar, Chandigarh, Delhi and more — with experienced hill drivers.',
    'image'    => '/images/dharamshala/five-towns-triund.jpg',
    'crumbs'   => ['Taxi Routes' => route('taxi-routes.index')],
])

<section class="bg-cream">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">

        {{-- Route cards --}}
        <h2 class="text-2xl font-extrabold text-pine-950 sm:text-3xl">Popular routes</h2>
        <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($routes as $r)
                <a href="{{ route('taxi-routes.show', $r) }}" class="group flex flex-col overflow-hidden rounded-2xl bg-white ring-1 ring-stone-200 transition hover:shadow-xl hover:shadow-pine-900/5">
                    <div class="relative aspect-[16/9] overflow-hidden bg-stone-100">
                        <img src="{{ $r->image_url }}" alt="{{ $r->title }}" loading="lazy" class="dt-card-img h-full w-full object-cover">
                        <span class="absolute bottom-3 left-3 rounded-full bg-pine-950/80 px-3 py-1 text-xs font-semibold text-white backdrop-blur">{{ $r->distance_km }} km • {{ $r->duration }}</span>
                    </div>
                    <div class="flex flex-1 flex-col p-5">
                        <h3 class="text-lg font-bold text-pine-950">{{ $r->from_city }} to {{ $r->to_city }}</h3>
                        <p class="mt-2 line-clamp-2 flex-1 text-sm text-stone-600">{{ $r->short_desc }}</p>
                        <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-pine-700">Route guide <i data-lucide="arrow-right" class="h-4 w-4"></i></span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

@include('partials.cta-band', [
    'heading' => 'Going somewhere else?',
    'text'    => 'We cover every corner of Himachal and neighbouring Punjab. Send your route and dates for a custom quote.',
    'type'    => 'outstation',
    'pickup'  => 'Dharamshala',
    'button'  => 'Get a custom quote',
])

@endsection
