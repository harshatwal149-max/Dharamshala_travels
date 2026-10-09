<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Travel Blog | Dharamshala Travels</title>

    <meta
        name="description"
        content="Travel guides, destinations and experiences from Dharamshala Travels."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .blog-card {
            transition: all .35s ease;
        }

        .blog-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 60px rgba(15, 23, 42, .12);
        }

        .blog-card-image {
            transition: transform .6s ease;
        }

        .blog-card:hover .blog-card-image {
            transform: scale(1.06);
        }

        .blog-overlay {
            background: linear-gradient(
                to top,
                rgba(0,0,0,.65),
                rgba(0,0,0,0)
            );
        }
    </style>
</head>

<body class="bg-[#f7f9fc] text-slate-900">

@include('components.header')

{{-- HERO --}}
<section class="relative overflow-hidden bg-[#09263d]">

    <div class="absolute inset-0">
        <div class="absolute -right-40 -top-40 h-[500px] w-[500px] rounded-full bg-cyan-400/10 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 h-[500px] w-[500px] rounded-full bg-blue-500/10 blur-3xl"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-6 py-24 lg:px-8">

        <div class="max-w-3xl">

            <p class="mb-5 text-sm font-semibold uppercase tracking-[.25em] text-cyan-300">
                Dharamshala Travels Journal
            </p>

            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                Discover
                <span class="text-cyan-300">Himachal</span>
                Through Our Stories
            </h1>

            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">
                Explore destinations, travel guides, local experiences and
                inspiration for your next journey through Himachal Pradesh.
            </p>

        </div>

    </div>

</section>


{{-- BLOGS --}}
<section class="py-20">

    <div class="mx-auto max-w-7xl px-6 lg:px-8">

        <div class="mb-12">

            <p class="text-sm font-semibold uppercase tracking-[.2em] text-blue-600">
                Travel Journal
            </p>

            <div class="mt-3 flex flex-col justify-between gap-4 md:flex-row md:items-end">

                <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                    Latest Travel Stories
                </h2>

                <p class="max-w-lg text-sm leading-6 text-slate-500">
                    Read our latest guides and discover the places,
                    experiences and hidden gems of Himachal.
                </p>

            </div>

        </div>


        @if($blogs->count())

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">

                @foreach($blogs as $blog)

                    <a
                        href="{{ route('blogs.show', ['slug' => $blog->slug]) }}"
                        class="blog-card group overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200"
                    >

                        {{-- IMAGE --}}
                        <div class="relative h-[270px] overflow-hidden bg-slate-200">

                            @if($blog->image)

                                <img
                                    src="{{ $blog->image }}"
                                    alt="{{ $blog->title }}"
                                    class="blog-card-image h-full w-full object-cover"
                                    loading="lazy"
                                >

                            @else

                                <div class="flex h-full items-center justify-center bg-slate-800">

                                    <span class="text-sm font-medium text-slate-300">
                                        Dharamshala Travels
                                    </span>

                                </div>

                            @endif


                            <div class="blog-overlay absolute inset-0"></div>


                            @if($blog->blog_date)

                                <div class="absolute left-5 top-5 rounded-xl bg-white px-4 py-2 shadow-lg">

                                    <div class="text-xs font-bold uppercase text-blue-600">
                                        {{ \Carbon\Carbon::parse($blog->blog_date)->format('M') }}
                                    </div>

                                    <div class="text-xl font-bold text-slate-900">
                                        {{ \Carbon\Carbon::parse($blog->blog_date)->format('d') }}
                                    </div>

                                </div>

                            @endif


                            <div class="absolute bottom-5 left-5 right-5">

                                <span class="inline-flex rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-slate-800">
                                    Travel Guide
                                </span>

                            </div>

                        </div>


                        {{-- CONTENT --}}
                        <div class="p-6">

                            @if($blog->blog_date)

                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    {{ \Carbon\Carbon::parse($blog->blog_date)->format('d F Y') }}
                                </p>

                            @endif


                            <h3 class="mt-3 text-xl font-bold leading-7 text-slate-900 transition group-hover:text-blue-700">
                                {{ $blog->title }}
                            </h3>


                            @if($blog->description)

                                <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-600">
                                    {{ strip_tags($blog->description) }}
                                </p>

                            @endif


                            <div class="mt-6 flex items-center justify-between border-t border-slate-100 pt-5">

                                <span class="text-sm font-semibold text-slate-900">
                                    Read Article
                                </span>

                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 transition group-hover:bg-blue-600 group-hover:text-white">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="16"
                                        height="16"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path d="M5 12h14"/>
                                        <path d="m12 5 7 7-7 7"/>
                                    </svg>

                                </span>

                            </div>

                        </div>

                    </a>

                @endforeach

            </div>

        @else

            <div class="rounded-2xl bg-white p-16 text-center shadow-sm ring-1 ring-slate-200">

                <h3 class="text-2xl font-bold text-slate-900">
                    No Travel Stories Yet
                </h3>

                <p class="mt-3 text-slate-500">
                    New blogs will appear here once they are published.
                </p>

            </div>

        @endif

    </div>

</section>


{{-- CTA --}}
<section class="bg-[#09263d]">

    <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">

        <div class="flex flex-col justify-between gap-8 md:flex-row md:items-center">

            <div>

                <p class="text-sm font-semibold uppercase tracking-[.2em] text-cyan-300">
                    Plan Your Trip
                </p>

                <h2 class="mt-3 text-3xl font-bold text-white">
                    Your Himachal journey starts here.
                </h2>

                <p class="mt-3 text-slate-300">
                    Book your cab or explore our curated tour packages.
                </p>

            </div>

            <div class="flex flex-wrap gap-3">

                <a
                    href="{{ route('cabs.index') }}"
                    class="rounded-xl bg-white px-6 py-3 font-semibold text-[#09263d] hover:bg-slate-100"
                >
                    Book a Cab
                </a>

                <a
                    href="{{ route('tours.index') }}"
                    class="rounded-xl border border-white/30 px-6 py-3 font-semibold text-white hover:bg-white/10"
                >
                    Tour Packages
                </a>

            </div>

        </div>

    </div>

</section>


@include('components.footer')

</body>
</html>