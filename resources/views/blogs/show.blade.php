<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    {{-- SEO --}}
    @include('components.seo', [

    'title' => $blog->title . ' | Dharamshala Travels',

    'description' => \Illuminate\Support\Str::limit(
    strip_tags($blog->description ?? ''),
    160
    ),

    'image' => $blog->image ?? null

    ])


    {{-- Favicon --}}
    @if(\App\Models\Setting::get('site_favicon'))

    <link
        rel="icon"
        type="image/x-icon"
        href="{{ \App\Models\Setting::get('site_favicon') }}">

    @endif


    {{-- Vite / Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-50 text-slate-900">

    {{-- HEADER --}}
    @include('components.header')


    {{-- HERO --}}
    <section class="bg-[#09263d]">

        <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">

            <a
                href="{{ route('blogs.public') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-white/70 transition hover:text-white">
                ← Back to Blogs
            </a>

            <div class="mt-8 max-w-4xl">

                <span class="inline-flex rounded-full bg-cyan-400/10 px-4 py-2 text-xs font-bold uppercase tracking-wider text-cyan-300">
                    Travel Story
                </span>

                <h1 class="mt-5 text-4xl font-black leading-tight text-white md:text-5xl lg:text-6xl">
                    {{ $blog->title }}
                </h1>

                @if($blog->blog_date)

                <p class="mt-5 text-sm text-white/60">
                    Published on
                    {{ \Carbon\Carbon::parse($blog->blog_date)->format('d F Y') }}
                </p>

                @endif

            </div>

        </div>

    </section>


    {{-- MAIN CONTENT --}}
    <main class="mx-auto max-w-6xl px-6 py-12 lg:px-8">


        {{-- MAIN BLOG IMAGE --}}
        @if(!empty($blog->image))

        <div class="mb-12 overflow-hidden rounded-3xl bg-white shadow-xl ring-1 ring-slate-200">

            <img
                src="{{ $blog->image }}"
                alt="{{ $blog->title }}"
                class="max-h-[700px] w-full object-cover">

        </div>

        @endif


        {{-- BLOG DESCRIPTION --}}
        <article class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-slate-200 md:p-10">

            <div class="mb-8 border-b border-slate-200 pb-6">

                <p class="text-sm font-bold uppercase tracking-[0.2em] text-blue-600">
                    Travel Guide
                </p>

                <h2 class="mt-2 text-3xl font-black text-slate-900">
                    {{ $blog->title }}
                </h2>

                @if($blog->blog_date)

                <p class="mt-3 text-sm text-slate-400">
                    {{ \Carbon\Carbon::parse($blog->blog_date)->format('d F Y') }}
                </p>

                @endif

            </div>


            @if(!empty($blog->description))

            <div class="whitespace-pre-line text-base leading-8 text-slate-600 md:text-lg">
                {{ $blog->description }}
            </div>

            @else

            <p class="text-slate-500">
                No description available for this blog.
            </p>

            @endif

        </article>


        {{-- GALLERY --}}
        @php

        $gallery = $blog->multiple_images;

        if (is_string($gallery)) {
        $gallery = json_decode($gallery, true);
        }

        if (!is_array($gallery)) {
        $gallery = [];
        }

        @endphp


        @if(count($gallery) > 0)

        <section class="mt-16">

            <div class="mb-8">

                <p class="text-sm font-bold uppercase tracking-[0.2em] text-blue-600">
                    Photo Gallery
                </p>

                <h2 class="mt-2 text-3xl font-black text-slate-900">
                    More From This Story
                </h2>

                <p class="mt-3 text-slate-500">
                    Explore all the photos from this travel story.
                </p>

            </div>


            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @foreach($gallery as $index => $image)

                @if(!empty($image))

                <button
                    type="button"
                    onclick="openBlogImage(@js($image))"
                    class="group relative overflow-hidden rounded-2xl bg-slate-200 shadow-sm ring-1 ring-slate-200">

                    <img
                        src="{{ $image }}"
                        alt="{{ $blog->title }} - Image {{ $index + 1 }}"
                        class="h-72 w-full object-cover transition duration-500 group-hover:scale-110"
                        loading="lazy">

                    <div class="absolute inset-0 flex items-center justify-center bg-black/0 transition duration-300 group-hover:bg-black/30">

                        <span class="rounded-full bg-white px-5 py-3 text-sm font-bold text-slate-900 opacity-0 shadow-lg transition duration-300 group-hover:opacity-100">
                            View Image
                        </span>

                    </div>

                </button>

                @endif

                @endforeach

            </div>

        </section>

        @endif


        {{-- BACK BUTTON --}}
        <div class="mt-16 text-center">

            <a
                href="{{ route('blogs.public') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-[#09263d] px-7 py-3.5 text-sm font-bold text-white transition hover:bg-[#123c59]">
                ← Back to All Blogs
            </a>

        </div>

    </main>


    {{-- IMAGE LIGHTBOX --}}
    <div
        id="blogImageModal"
        class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/90 p-5"
        onclick="closeBlogImage()">

        <button
            type="button"
            onclick="closeBlogImage()"
            class="absolute right-6 top-6 flex h-12 w-12 items-center justify-center rounded-full bg-white/10 text-3xl text-white backdrop-blur transition hover:bg-white/20">
            ×
        </button>


        <img
            id="blogModalImage"
            src=""
            alt="Blog Gallery Image"
            class="max-h-[90vh] max-w-[95vw] rounded-2xl object-contain shadow-2xl"
            onclick="event.stopPropagation()">

    </div>


    {{-- LIGHTBOX SCRIPT --}}
    <script>
        function openBlogImage(imageUrl) {
            const modal = document.getElementById('blogImageModal');
            const image = document.getElementById('blogModalImage');

            image.src = imageUrl;

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.body.style.overflow = 'hidden';
        }


        function closeBlogImage() {
            const modal = document.getElementById('blogImageModal');
            const image = document.getElementById('blogModalImage');

            modal.classList.add('hidden');
            modal.classList.remove('flex');

            image.src = '';

            document.body.style.overflow = '';
        }


        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeBlogImage();
            }
        });
    </script>


    {{-- FOOTER --}}
    @include('components.footer')

</body>

</html>