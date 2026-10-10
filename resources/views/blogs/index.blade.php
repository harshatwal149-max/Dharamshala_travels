@extends('layouts.site')

@use('App\Support\Media')
@use('Illuminate\Support\Str')

@php
    $fallback = Media::url('/images/dharamshala/dhauladhar-alpenglow.jpg');
    $posts = $blogs->getCollection();
    $featured = $blogs->onFirstPage() ? $posts->first() : null;
    $rest = $featured ? $posts->slice(1) : $posts;
    $excerpt = fn ($b, $len = 150) => Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($b->description ?? ''))), $len);
    $minutes = fn ($b) => max(1, (int) ceil(str_word_count(strip_tags($b->description ?? '')) / 200));
@endphp

@section('content')

@include('partials.page-hero', [
    'eyebrow'  => 'Travel guides',
    'title'    => 'Dharamshala Travel Blog',
    'subtitle' => 'Local tips for planning your trip — places to visit, how to get here, treks, seasons and day trips across the Kangra Valley.',
    'image'    => '/images/dharamshala/mcleodganj-view.jpg',
    'crumbs'   => ['Blog' => route('blogs.public')],
])

<section class="bg-cream" x-data="{ q: '' }">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">

        @if($posts->isNotEmpty())
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <p class="text-sm text-stone-500"><span class="font-semibold text-pine-900">{{ $blogs->total() }}</span> {{ Str::plural('article', $blogs->total()) }}</p>
                <label class="relative block w-full sm:w-80">
                    <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-stone-400"></i>
                    <input type="search" x-model="q" placeholder="Search guides…" class="dt-input pl-9" aria-label="Search articles">
                </label>
            </div>
        @endif

        {{-- Featured --}}
        @if($featured)
            <article x-show="!q || @js(Str::lower($featured->title . ' ' . $excerpt($featured, 400))).includes(q.toLowerCase())"
                     class="group mt-8 grid overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-stone-200 lg:grid-cols-2">
                <a href="{{ route('blogs.show', $featured->slug) }}" class="relative block aspect-[16/10] overflow-hidden bg-stone-200 lg:aspect-auto lg:min-h-[360px]">
                    <img src="{{ Media::url($featured->image) ?: $fallback }}" alt="{{ $featured->title }}" class="dt-card-img absolute inset-0 h-full w-full object-cover"
                         onerror="this.onerror=null; this.src=@js($fallback)">
                    <span class="absolute left-4 top-4 rounded-full bg-saffron-500 px-3 py-1 text-xs font-bold text-pine-950">Latest</span>
                </a>
                <div class="flex flex-col justify-center p-6 sm:p-10">
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs font-semibold uppercase tracking-wide text-pine-600">
                        @if($featured->blog_date)<time datetime="{{ $featured->blog_date->toDateString() }}">{{ $featured->blog_date->format('d M Y') }}</time>@endif
                        <span class="text-stone-400">{{ $minutes($featured) }} min read</span>
                    </div>
                    <h2 class="mt-3 text-2xl font-extrabold leading-tight text-pine-950 sm:text-3xl">
                        <a href="{{ route('blogs.show', $featured->slug) }}" class="hover:text-pine-700">{{ $featured->title }}</a>
                    </h2>
                    <p class="mt-4 leading-relaxed text-stone-600">{{ $excerpt($featured, 260) }}</p>
                    <a href="{{ route('blogs.show', $featured->slug) }}" class="mt-6 inline-flex items-center gap-1.5 text-sm font-bold text-pine-700 hover:text-pine-900">
                        Read the guide <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-1"></i>
                    </a>
                </div>
            </article>
        @endif

        {{-- Grid --}}
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($rest as $blog)
                <article x-show="!q || @js(Str::lower($blog->title . ' ' . $excerpt($blog, 400))).includes(q.toLowerCase())"
                         class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-stone-200 transition hover:-translate-y-1 hover:shadow-xl hover:shadow-pine-900/10">
                    <a href="{{ route('blogs.show', $blog->slug) }}" class="block aspect-[16/10] overflow-hidden bg-stone-200">
                        <img src="{{ Media::url($blog->image) ?: $fallback }}" alt="{{ $blog->title }}" loading="lazy" class="dt-card-img h-full w-full object-cover"
                             onerror="this.onerror=null; this.src=@js($fallback)">
                    </a>
                    <div class="flex flex-1 flex-col p-5">
                        <div class="flex items-center gap-3 text-xs font-semibold uppercase tracking-wide text-pine-600">
                            @if($blog->blog_date)<time datetime="{{ $blog->blog_date->toDateString() }}">{{ $blog->blog_date->format('d M Y') }}</time>@endif
                            <span class="text-stone-400">{{ $minutes($blog) }} min read</span>
                        </div>
                        <h3 class="mt-2 text-lg font-bold leading-snug text-pine-950">
                            <a href="{{ route('blogs.show', $blog->slug) }}" class="hover:text-pine-700">{{ $blog->title }}</a>
                        </h3>
                        <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-stone-600">{{ $excerpt($blog) }}</p>
                        <a href="{{ route('blogs.show', $blog->slug) }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-pine-700">
                            Read more <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        @if($posts->isEmpty())
            <div class="rounded-2xl border border-dashed border-stone-300 bg-white p-12 text-center">
                <i data-lucide="book-open" class="mx-auto h-12 w-12 text-stone-300"></i>
                <h2 class="mt-3 font-bold text-pine-950">New travel guides coming soon</h2>
                <p class="mt-1 text-sm text-stone-500">In the meantime, explore our <a href="{{ route('destinations.index') }}" class="font-semibold text-pine-700 underline">destination guides</a>.</p>
            </div>
        @endif

        @include('partials.pagination', ['paginator' => $blogs])
    </div>
</section>

@include('partials.cta-band', [
    'heading' => 'Planning a trip to Dharamshala?',
    'text'    => 'Airport pickups, sightseeing and outstation cabs with experienced local drivers.',
    'type'    => 'airport',
])

@endsection
