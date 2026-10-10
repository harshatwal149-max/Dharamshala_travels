@extends('layouts.site')

@section('content')

@include('partials.page-hero', [
    'eyebrow'  => 'Sightseeing guide',
    'title'    => 'Places to Visit in Dharamshala & McLeodganj',
    'subtitle' => 'Monasteries, waterfalls, heritage forts and Himalayan treks — with distances, timings and how to get there by taxi.',
    'image'    => '/images/dharamshala/mcleodganj-view.jpg',
    'crumbs'   => ['Destinations' => route('destinations.index')],
])

@php
    $categories = $destinations->pluck('category')->unique()->sort()->values();
@endphp

<section class="bg-cream" x-data="{ filter: 'All' }">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">

        <div class="dt-scroll-x -mx-4 flex gap-2 overflow-x-auto px-4 pb-2 sm:mx-0 sm:flex-wrap sm:px-0">
            @foreach($categories->prepend('All') as $cat)
                <button type="button" @click="filter = @js($cat)"
                        :class="filter === @js($cat) ? 'bg-pine-900 text-white' : 'bg-white text-stone-600 ring-1 ring-stone-200 hover:ring-pine-300'"
                        class="whitespace-nowrap rounded-full px-4 py-2 text-sm font-semibold transition">{{ $cat }}</button>
            @endforeach
        </div>

        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($destinations as $place)
                <article x-show="filter === 'All' || filter === @js($place->category)" x-transition.opacity
                         class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-stone-200 transition hover:shadow-xl hover:shadow-pine-900/5">
                    <a href="{{ route('destinations.show', $place) }}" class="relative block aspect-[16/10] overflow-hidden bg-stone-100">
                        <img src="{{ $place->image_url }}" alt="{{ $place->name }}" loading="lazy" class="dt-card-img h-full w-full object-cover">
                        <span class="absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide text-pine-800">{{ $place->category }}</span>
                    </a>
                    <div class="flex flex-1 flex-col p-5">
                        <h2 class="text-lg font-bold text-pine-950">
                            <a href="{{ route('destinations.show', $place) }}" class="hover:text-pine-700">{{ $place->name }}</a>
                        </h2>
                        @if($place->tagline)
                            <p class="mt-0.5 text-sm font-medium text-saffron-600">{{ $place->tagline }}</p>
                        @endif
                        <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-stone-600">{{ $place->short_desc }}</p>
                        <div class="mt-4 flex items-center justify-between border-t border-stone-100 pt-4 text-xs text-stone-500">
                            <span class="flex items-center gap-1.5"><i data-lucide="navigation" class="h-3.5 w-3.5 text-pine-500"></i>{{ \Illuminate\Support\Str::before($place->distance, '•') }}</span>
                            <a href="{{ route('destinations.show', $place) }}" class="inline-flex items-center gap-1 font-semibold text-pine-700">Guide <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i></a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

@include('partials.cta-band', [
    'heading' => 'See it all in one day',
    'text'    => 'Our full-day local sightseeing tour covers the Dalai Lama Temple, Bhagsu, St. John’s Church, Dal Lake and the HPCA Stadium in a private cab.',
    'type'    => 'local',
])

@endsection
