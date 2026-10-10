{{--
    Inner page hero.
    @include('partials.page-hero', ['title' => ..., 'subtitle' => ..., 'image' => ..., 'eyebrow' => ..., 'crumbs' => [label => url]])
--}}
<section class="relative isolate overflow-hidden bg-pine-950 text-white">
    @if(!empty($image))
        <img src="{{ \App\Support\Media::url($image) }}" alt="{{ $imageAlt ?? $title }}"
             class="absolute inset-0 -z-10 h-full w-full object-cover" fetchpriority="high">
    @endif
    <div class="dt-hero-fade absolute inset-0 -z-10"></div>

    <div class="mx-auto max-w-7xl px-4 pb-14 pt-16 sm:px-6 sm:pb-20 sm:pt-24 lg:px-8">
        <nav aria-label="Breadcrumb" class="mb-6 flex flex-wrap items-center gap-1.5 text-xs font-medium text-white/70">
            <a href="{{ url('/') }}" class="hover:text-white">Home</a>
            @foreach(($crumbs ?? []) as $label => $url)
                <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
                @if($loop->last)
                    <span class="text-white" aria-current="page">{{ $label }}</span>
                @else
                    <a href="{{ $url }}" class="hover:text-white">{{ $label }}</a>
                @endif
            @endforeach
        </nav>

        @if(!empty($eyebrow))
            <span class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-saffron-300 backdrop-blur">
                {{ $eyebrow }}
            </span>
        @endif

        <h1 class="max-w-3xl text-3xl font-extrabold leading-tight sm:text-5xl">{{ $title }}</h1>

        @if(!empty($subtitle))
            <p class="mt-4 max-w-2xl text-base leading-relaxed text-white/80 sm:text-lg">{{ $subtitle }}</p>
        @endif

        {{ $slot ?? '' }}
    </div>
</section>
