<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Hero Banners - {{ \App\Models\Setting::get('site_title', 'Dharamshala Travels') }}
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://unpkg.com/lucide@latest"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Responsive admin layout */
        #adminMainContent {
            flex: 1 1 0%;
            min-width: 0;
            width: 100%;
        }

        #adminTopHeader {
            min-height: 4rem;
            height: auto;
            gap: 0.75rem;
            flex-wrap: wrap;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        #adminPageContent {
            width: 100%;
            min-width: 0;
        }

        .hero-banner-card,
        .hero-banner-card * {
            min-width: 0;
        }

        .hero-banner-card h4,
        .hero-banner-card p,
        .hero-banner-meta {
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .hero-banner-meta span {
            max-width: 100%;
        }

        .hero-banner-meta span:last-child {
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .hero-banner-image {
            display: block;
            width: 100%;
            max-width: 100%;
            object-fit: cover;
        }

        #heroBannerForm input[type="text"],
        #heroBannerForm textarea,
        #heroBannerForm input[type="file"] {
            max-width: 100%;
            min-width: 0;
        }

        @media (max-width: 767px) {
            body.admin-hero-banners-page {
                min-height: 100vh;
                overflow-x: hidden;
            }

            #adminMainContent {
                min-height: 100vh;
                overflow-x: hidden;
            }

            #adminTopHeader {
                align-items: flex-start;
                padding-left: 1rem;
                padding-right: 1rem;
            }

            #adminTopHeader > a {
                max-width: 100%;
                justify-content: center;
                white-space: normal;
            }

            #adminPageContent {
                padding: 1rem;
                gap: 1rem;
            }

            .hero-banner-section-heading {
                padding: 1rem;
            }

            #heroBannerForm {
                padding: 1rem;
            }

            #heroBannerForm .hero-banner-submit-row {
                justify-content: stretch;
            }

            #heroBannerForm .hero-banner-submit-row button {
                width: 100%;
                justify-content: center;
            }

            .hero-banner-card-content {
                padding: 1rem;
            }

            .hero-banner-image {
                height: auto;
                min-height: 0;
                max-height: 16rem;
                aspect-ratio: 16 / 9;
            }

            .hero-banner-actions {
                align-items: stretch;
            }

            .hero-banner-actions form,
            .hero-banner-actions button {
                max-width: 100%;
            }
        }

        @media (max-width: 420px) {
            #adminTopHeader {
                gap: 0.5rem;
            }

            #adminTopHeader h1 {
                font-size: 1rem;
                line-height: 1.4;
            }

            #adminTopHeader > a {
                width: 100%;
            }

            #adminPageContent h2 {
                font-size: 1.25rem;
                line-height: 1.5rem;
            }

            .hero-banner-meta {
                align-items: stretch;
                flex-direction: column;
            }

            .hero-banner-meta span {
                width: 100%;
            }
        }

        html {
            -webkit-text-size-adjust: 100%;
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        img {
            max-width: 100%;
        }

        button, input, textarea {
            font: inherit;
        }

        #adminPageContent > section,
        #adminPageContent > div,
        .hero-banner-card,
        .hero-banner-card > div,
        .hero-banner-card-content {
            min-width: 0;
        }

        #heroBannerForm input,
        #heroBannerForm textarea {
            display: block;
            width: 100%;
        }

        .hero-banner-card {
            width: 100%;
        }

        .hero-banner-card .hero-banner-image {
            min-height: 0;
            height: 100%;
            max-height: 420px;
        }

        .hero-banner-actions form {
            margin: 0;
        }

        .hero-banner-actions button {
            min-height: 42px;
        }

        @media (min-width: 768px) {
            #adminTopHeader {
                flex-wrap: nowrap;
            }
        }

        @media (max-width: 767px) {
            body.admin-hero-banners-page {
                display: flex;
                align-items: stretch;
            }

            #adminMainContent {
                width: 100%;
                max-width: 100%;
            }

            #adminTopHeader {
                position: sticky;
                top: 0;
                z-index: 30;
            }

            #adminTopHeader > div {
                width: 100%;
            }

            #adminTopHeader > a {
                width: 100%;
            }

            #adminPageContent {
                margin-left: 0;
                margin-right: 0;
                max-width: 100%;
            }

            .hero-banner-card > div {
                grid-template-columns: minmax(0, 1fr);
            }

            .hero-banner-card > div > div:first-child {
                min-width: 0;
            }

            .hero-banner-card .hero-banner-image {
                width: 100%;
                height: auto;
                aspect-ratio: 16 / 9;
                max-height: 280px;
                min-height: 0;
            }

            .hero-banner-card-content {
                padding: 1rem;
            }

            .hero-banner-card-content .flex.items-start.justify-between {
                align-items: flex-start;
            }

            .hero-banner-actions {
                display: flex;
                flex-direction: column;
                align-items: stretch;
            }

            .hero-banner-actions form,
            .hero-banner-actions form button {
                width: 100%;
            }

            #heroBannerForm input[type="file"] {
                padding: .65rem;
                font-size: .8125rem;
            }
        }

        @media (max-width: 420px) {
            #adminPageContent {
                padding: .75rem;
            }

            .hero-banner-section-heading {
                padding: .875rem;
            }

            .hero-banner-section-heading > div {
                align-items: flex-start;
            }

            #heroBannerForm {
                padding: .875rem;
            }

            .hero-banner-meta span {
                white-space: normal;
            }

            .hero-banner-card-content h4 {
                font-size: 1.05rem;
                line-height: 1.5rem;
            }
        }

    </style>
</head>

<body class="admin-hero-banners-page bg-slate-100 text-slate-800 antialiased flex min-h-screen">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    {{-- MAIN --}}
    <div id="adminMainContent" class="flex-1 flex flex-col min-w-0">

        {{-- HEADER --}}
        <header id="adminTopHeader" class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between sticky top-0 z-30">

            <div>
                <div class="flex items-center gap-2 text-xs">
                    <span class="text-slate-400">Admin</span>
                    <span class="text-slate-300">/</span>
                    <span class="font-bold text-slate-800">
                        Hero Banners
                    </span>
                </div>

                <h1 class="text-lg font-extrabold text-slate-900 mt-1">
                    Hero Banner Management
                </h1>
            </div>

            <a
                href="{{ route('home') }}"
                target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-300 bg-white text-sm font-semibold text-slate-700 hover:bg-slate-50 transition"
            >
                <i data-lucide="globe" class="w-4 h-4"></i>
                View Website
            </a>

        </header>


        {{-- CONTENT --}}
        <main id="adminPageContent" class="flex-1 min-h-0 overflow-y-auto overscroll-contain p-6 space-y-6 max-w-7xl w-full mx-auto">

            {{-- SUCCESS --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif


            {{-- ERRORS --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-4 rounded-xl text-sm">
                    <div class="font-bold mb-2">
                        Please fix the following:
                    </div>

                    <ul class="list-disc ml-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {{-- PAGE INTRO --}}
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900">
                    Homepage Hero Banners
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Manage the images, headings and content shown in the homepage hero slider.
                </p>
            </div>


            {{-- ADD NEW BANNER --}}
            <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="hero-banner-section-heading px-6 py-5 border-b border-slate-200">
                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i data-lucide="image-plus" class="w-5 h-5"></i>
                        </div>

                        <div>
                            <h3 class="text-base font-extrabold text-slate-900">
                                Add New Hero Banner
                            </h3>

                            <p class="text-xs text-slate-500 mt-1">
                                Upload the banner image and define its homepage content.
                            </p>
                        </div>

                    </div>
                </div>


                <form
                    action="{{ route('admin.hero-banners.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="heroBannerForm"
                    class="p-6"
                >

                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                        {{-- IMAGE --}}
                        <div class="lg:col-span-2">

                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Banner Image *
                            </label>

                            <input
                                type="file"
                                name="image"
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                required
                                class="w-full text-sm border border-slate-300 rounded-xl p-3 bg-white"
                            >

                            <p class="text-xs text-slate-400 mt-2">
                                Recommended: large landscape image, preferably 1600px or wider.
                            </p>

                        </div>


                        {{-- TITLE --}}
                        <div>

                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Banner Title
                            </label>

                            <input
                                type="text"
                                name="title"
                                maxlength="200"
                                placeholder="Explore Dharamshala with Trusted Travel Services"
                                value="{{ old('title') }}"
                                class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-blue-500"
                            >

                        </div>


                        {{-- SUBTITLE --}}
                        <div>

                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Banner Subtitle
                            </label>

                            <textarea
                                name="subtitle"
                                rows="3"
                                maxlength="500"
                                placeholder="Comfortable cab services, airport transfers and memorable Himachal tours."
                                class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                            >{{ old('subtitle') }}</textarea>

                        </div>

                    </div>


                    <div class="hero-banner-submit-row flex justify-end mt-6">

                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-sm font-bold transition"
                        >
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Add Hero Banner
                        </button>

                    </div>

                </form>

            </section>


            {{-- EXISTING BANNERS --}}
            <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="hero-banner-section-heading px-6 py-5 border-b border-slate-200">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                            <i data-lucide="images" class="w-5 h-5"></i>
                        </div>

                        <div>
                            <h3 class="text-base font-extrabold text-slate-900">
                                Existing Hero Banners
                            </h3>

                            <p class="text-xs text-slate-500 mt-1">
                                These banners are used by the homepage hero slider.
                            </p>
                        </div>

                    </div>

                </div>


                <div class="hero-banner-card-content p-6">

                    @forelse($banners as $banner)

                        <div class="hero-banner-card border border-slate-200 rounded-2xl overflow-hidden mb-5 last:mb-0">

                            <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr]">

                                {{-- IMAGE --}}
                                <div class="bg-slate-900">

                                    <img
                                        src="{{ \App\Support\Media::url($banner->image) }}"
                                        alt="{{ $banner->title ?: 'Hero Banner' }}"
                                        class="hero-banner-image w-full h-56 lg:h-full min-h-[220px] object-cover"
                                    >

                                </div>


                                {{-- CONTENT --}}
                                <div class="hero-banner-card-content p-6">

                                    <div class="flex flex-wrap items-start justify-between gap-4">

                                        <div>

                                            <div class="text-xs font-bold uppercase tracking-wider text-blue-600 mb-2">
                                                Hero Banner #{{ $banner->id }}
                                            </div>

                                            <h4 class="text-xl font-extrabold text-slate-900">
                                                {{ $banner->title ?: 'Untitled Banner' }}
                                            </h4>

                                        </div>


                                        {{-- STATUS --}}
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold
                                            {{ $banner->is_active
                                                ? 'bg-green-50 text-green-700 border border-green-200'
                                                : 'bg-slate-100 text-slate-500 border border-slate-200'
                                            }}"
                                        >

                                            <span class="w-2 h-2 rounded-full {{ $banner->is_active ? 'bg-green-500' : 'bg-slate-400' }}"></span>

                                            {{ $banner->is_active ? 'Active' : 'Inactive' }}

                                        </span>

                                    </div>


                                    {{-- SUBTITLE --}}
                                    @if($banner->subtitle)

                                        <p class="text-sm leading-6 text-slate-600 mt-4">
                                            {{ $banner->subtitle }}
                                        </p>

                                    @else

                                        <p class="text-sm text-slate-400 italic mt-4">
                                            No subtitle added.
                                        </p>

                                    @endif


                                    {{-- META --}}
                                    <div class="hero-banner-meta flex flex-wrap items-center gap-3 mt-5">

                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg">

                                            <i data-lucide="arrow-up-down" class="w-3.5 h-3.5"></i>

                                            Sort Order:
                                            {{ $banner->sort_order }}

                                        </span>


                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg">

                                            <i data-lucide="image" class="w-3.5 h-3.5"></i>

                                            {{ basename($banner->image) }}

                                        </span>

                                    </div>


                                    {{-- ACTIONS --}}
                                    <div class="hero-banner-actions flex flex-wrap items-center gap-3 mt-6 pt-5 border-t border-slate-100">

                                        {{-- DELETE --}}
                                        <form
                                            action="{{ route('admin.hero-banners.destroy', $banner->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this hero banner?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 text-sm font-bold transition"
                                            >
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="text-center py-16">

                            <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">

                                <i data-lucide="image-off" class="w-8 h-8 text-slate-400"></i>

                            </div>

                            <h4 class="text-base font-bold text-slate-700">
                                No Hero Banners Yet
                            </h4>

                            <p class="text-sm text-slate-400 mt-1">
                                Add your first banner using the form above.
                            </p>

                        </div>

                    @endforelse

                </div>

            </section>

        </main>

    </div>


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            @if(session('success'))

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: @json(session('success')),
                    timer: 2000,
                    showConfirmButton: false
                });

            @endif

        });

    </script>

</body>

</html>