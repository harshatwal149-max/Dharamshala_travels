@extends('layouts.site')

@use('App\Support\Media')
@use('Illuminate\Support\Str')

@php
    $plain = trim(preg_replace('/\s+/', ' ', strip_tags($blog->description ?? '')));
    $readMinutes = max(1, (int) ceil(str_word_count($plain) / 200));
    $heroImage = $blog->image ?: '/images/dharamshala/dhauladhar-alpenglow.jpg';
    $gallery = collect($blog->multiple_images ?? [])->filter()->map(fn ($img) => Media::url($img))->values();
    $shareUrl = urlencode(route('blogs.show', $blog->slug));
    $shareText = urlencode($blog->title);

    /*
     * Turn the plain-text description into blocks:
     * short first lines become headings, "•" / "-" lines become lists.
     */
    $blocks = [];
    $toc = [];
    foreach (preg_split('/\R\s*\R/', trim($blog->description ?? '')) as $chunk) {
        $lines = array_values(array_filter(array_map('trim', preg_split('/\R/', $chunk)), 'strlen'));
        if (!$lines) continue;

        $first = $lines[0];
        $isHeading = count($lines) > 1
            && mb_strlen($first) <= 70
            && !preg_match('/[.!?:,;]$/u', $first);

        if ($isHeading) {
            $id = Str::slug($first) ?: 'section-' . count($toc);
            $toc[] = ['id' => $id, 'label' => preg_replace('/^\d+\.\s*/', '', $first)];
            $blocks[] = ['type' => 'heading', 'text' => $first, 'id' => $id];
            array_shift($lines);
        }

        $bullets = array_filter($lines, fn ($l) => preg_match('/^[•\-\*]\s+/u', $l));
        if ($lines && count($bullets) === count($lines)) {
            $blocks[] = ['type' => 'list', 'items' => array_map(fn ($l) => preg_replace('/^[•\-\*]\s+/u', '', $l), $lines)];
        } elseif ($lines) {
            $blocks[] = ['type' => 'para', 'text' => implode(' ', $lines)];
        }
    }
@endphp

@section('content')

{{-- HERO --}}
<section class="relative isolate overflow-hidden bg-pine-950 text-white">
    <img src="{{ Media::url($heroImage) }}" alt="{{ $blog->title }}" class="absolute inset-0 -z-10 h-full w-full object-cover" fetchpriority="high">
    <div class="absolute inset-0 -z-10 bg-gradient-to-t from-pine-950 via-pine-950/75 to-pine-950/40"></div>

    <div class="mx-auto max-w-7xl px-4 pb-14 pt-16 sm:px-6 sm:pb-20 sm:pt-24 lg:px-8">
        <div class="max-w-4xl">
        <nav aria-label="Breadcrumb" class="flex flex-wrap items-center gap-1.5 text-xs font-medium text-white/70">
            <a href="{{ url('/') }}" class="hover:text-white">Home</a>
            <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
            <a href="{{ route('blogs.public') }}" class="hover:text-white">Blog</a>
            <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
            <span class="line-clamp-1 text-white" aria-current="page">{{ $blog->title }}</span>
        </nav>

        <span class="mt-8 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-saffron-300 backdrop-blur">
            <i data-lucide="book-open" class="h-3.5 w-3.5"></i> Travel Guide
        </span>

        <h1 class="mt-5 text-3xl font-extrabold leading-tight sm:text-5xl">{{ $blog->title }}</h1>

        <div class="mt-6 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-white/75">
            @if($blog->blog_date)
                <span class="flex items-center gap-1.5"><i data-lucide="calendar" class="h-4 w-4 text-saffron-400"></i>
                    <time datetime="{{ $blog->blog_date->toDateString() }}">{{ $blog->blog_date->format('d F Y') }}</time>
                </span>
            @endif
            <span class="flex items-center gap-1.5"><i data-lucide="clock" class="h-4 w-4 text-saffron-400"></i>{{ $readMinutes }} min read</span>
            <span class="flex items-center gap-1.5"><i data-lucide="pen-line" class="h-4 w-4 text-saffron-400"></i>{{ \App\Models\Setting::get('site_title') ?: 'Dharamshala Travels' }}</span>
        </div>
        </div>
    </div>
</section>

{{-- ARTICLE + SIDEBAR --}}
<section class="bg-cream" x-data="{ lightbox: null }" @keydown.escape.window="lightbox = null">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-12 lg:px-8 lg:py-16">

        <article class="lg:col-span-8">
            <div class="rounded-3xl bg-white p-6 ring-1 ring-stone-200 sm:p-10">
                @forelse($blocks as $block)
                    @if($block['type'] === 'heading')
                        <h2 id="{{ $block['id'] }}" class="scroll-mt-28 text-xl font-extrabold text-pine-950 sm:text-2xl {{ $loop->first ? '' : 'mt-10' }}">{{ $block['text'] }}</h2>
                    @elseif($block['type'] === 'list')
                        <ul class="mt-4 space-y-2.5">
                            @foreach($block['items'] as $item)
                                <li class="flex gap-3 leading-relaxed text-stone-700">
                                    <i data-lucide="check-circle-2" class="mt-1 h-4 w-4 shrink-0 text-pine-500"></i>{{ $item }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="{{ $loop->first ? 'text-lg font-medium text-pine-900' : 'text-stone-700' }} mt-4 leading-8 first:mt-0">{{ $block['text'] }}</p>
                    @endif
                @empty
                    <p class="text-stone-500">No content available for this article yet.</p>
                @endforelse

                {{-- Inline booking prompt --}}
                <div class="mt-12 flex flex-col items-start gap-5 rounded-2xl bg-pine-900 p-6 text-white sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-lg font-extrabold">Planning this trip?</p>
                        <p class="mt-1 text-sm text-white/75">Book a private cab with an experienced local driver.</p>
                    </div>
                    <button type="button" @click="$dispatch('open-booking', { type: 'local' })"
                            class="inline-flex w-full shrink-0 items-center justify-center gap-2 rounded-xl bg-saffron-500 px-5 py-3 text-sm font-bold text-pine-950 transition hover:bg-saffron-400 sm:w-auto">
                        <i data-lucide="calendar-check" class="h-4 w-4"></i> Book a cab
                    </button>
                </div>

                {{-- Share --}}
                <div class="mt-8 flex flex-wrap items-center gap-3 border-t border-stone-100 pt-6">
                    <span class="text-sm font-semibold text-stone-600">Share this guide:</span>
                    <a href="https://wa.me/?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full bg-[#25D366]/10 px-3 py-1.5 text-xs font-semibold text-[#128C7E] hover:bg-[#25D366]/20">
                        <i data-lucide="message-circle" class="h-3.5 w-3.5"></i> WhatsApp
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-100">
                        <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-7.5h2.5l.4-3h-2.9V8.6c0-.9.3-1.5 1.5-1.5h1.6V4.4c-.3 0-1.2-.1-2.3-.1-2.3 0-3.8 1.4-3.8 3.9v2.3H8v3h2.5V21h3z"/></svg> Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ $shareText }}&url={{ $shareUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full bg-stone-100 px-3 py-1.5 text-xs font-semibold text-stone-700 hover:bg-stone-200">
                        <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="currentColor" aria-hidden="true"><path d="M17.8 3h3.1l-6.8 7.7L22 21h-6.2l-4.9-6.4L5.3 21H2.2l7.2-8.3L1.8 3h6.3l4.4 5.9L17.8 3zm-1.1 16.2h1.7L7.3 4.7H5.5l11.2 14.5z"/></svg> X
                    </a>
                </div>
            </div>

            {{-- Gallery --}}
            @if($gallery->isNotEmpty())
                <div class="mt-10">
                    <h2 class="text-2xl font-extrabold text-pine-950">Photo gallery</h2>
                    <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3">
                        @foreach($gallery as $url)
                            <button type="button" @click="lightbox = @js($url)" class="group overflow-hidden rounded-2xl bg-stone-200">
                                <img src="{{ $url }}" alt="{{ $blog->title }} — photo {{ $loop->iteration }}" loading="lazy" class="dt-card-img aspect-[4/3] w-full object-cover">
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        </article>

        <aside class="lg:col-span-4">
            <div class="sticky top-24 space-y-6">
                @if(count($toc) > 1)
                    <nav class="rounded-2xl bg-white p-6 ring-1 ring-stone-200" aria-label="In this article">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-pine-700">In this guide</h2>
                        <ol class="mt-4 space-y-2 text-sm">
                            @foreach($toc as $item)
                                <li><a href="#{{ $item['id'] }}" class="flex gap-2 text-stone-600 hover:text-pine-800"><span class="text-saffron-600">→</span>{{ $item['label'] }}</a></li>
                            @endforeach
                        </ol>
                    </nav>
                @endif

                <div class="overflow-hidden rounded-2xl bg-pine-900 text-white">
                    <img src="{{ Media::url('/images/dharamshala/car-innova-crysta.jpg') }}" alt="Toyota Innova Crysta taxi" loading="lazy" class="h-36 w-full object-cover">
                    <div class="p-6">
                        <h2 class="text-lg font-extrabold">Need a cab in Dharamshala?</h2>
                        <p class="mt-2 text-sm text-white/75">Airport pickups, sightseeing and outstation trips with experienced hill drivers.</p>
                        <button type="button" @click="$dispatch('open-booking', { type: 'airport' })"
                                class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-saffron-500 px-5 py-3 text-sm font-bold text-pine-950 transition hover:bg-saffron-400">
                            <i data-lucide="car-front" class="h-4 w-4"></i> Get a quote
                        </button>
                        <a href="{{ route('taxi-routes.index') }}" class="mt-3 block text-center text-xs font-semibold text-saffron-300 hover:text-saffron-200">See taxi routes →</a>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    {{-- Lightbox --}}
    <div x-show="lightbox" x-cloak x-transition.opacity @click="lightbox = null"
         class="fixed inset-0 z-[70] flex items-center justify-center bg-black/90 p-4" role="dialog" aria-modal="true">
        <button type="button" class="absolute right-5 top-5 rounded-full bg-white/10 p-2 text-white hover:bg-white/20" aria-label="Close">
            <i data-lucide="x" class="h-6 w-6"></i>
        </button>
        <img :src="lightbox" alt="" class="max-h-[88vh] max-w-full rounded-2xl object-contain shadow-2xl" @click.stop>
    </div>
</section>

{{-- RELATED --}}
@if($related->isNotEmpty())
<section class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">
        <div class="flex items-end justify-between gap-4">
            <h2 class="text-2xl font-extrabold text-pine-950 sm:text-3xl">More travel guides</h2>
            <a href="{{ route('blogs.public') }}" class="inline-flex shrink-0 items-center gap-1.5 text-sm font-semibold text-pine-700 hover:text-pine-900">All articles <i data-lucide="arrow-right" class="h-4 w-4"></i></a>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
            @foreach($related as $post)
                <article class="group">
                    <a href="{{ route('blogs.show', $post->slug) }}" class="block aspect-[16/10] overflow-hidden rounded-2xl bg-stone-100">
                        @if($post->image)
                            <img src="{{ Media::url($post->image) }}" alt="{{ $post->title }}" loading="lazy" class="dt-card-img h-full w-full object-cover"
                                 onerror="this.onerror=null; this.src=@js(Media::url('/images/dharamshala/dhauladhar-alpenglow.jpg'))">
                        @else
                            <div class="flex h-full items-center justify-center text-stone-300"><i data-lucide="image" class="h-10 w-10"></i></div>
                        @endif
                    </a>
                    <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-pine-600">{{ $post->blog_date?->format('d M Y') }}</p>
                    <h3 class="mt-1.5 text-lg font-bold leading-snug text-pine-950">
                        <a href="{{ route('blogs.show', $post->slug) }}" class="hover:text-pine-700">{{ $post->title }}</a>
                    </h3>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
