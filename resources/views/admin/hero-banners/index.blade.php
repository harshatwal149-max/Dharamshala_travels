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
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased flex min-h-screen">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- HEADER --}}
        <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between sticky top-0 z-30">

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
        <main class="p-6 space-y-6 max-w-7xl w-full mx-auto">

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

                <div class="px-6 py-5 border-b border-slate-200">
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


                    <div class="flex justify-end mt-6">

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

                <div class="px-6 py-5 border-b border-slate-200">

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


                <div class="p-6">

                    @forelse($banners as $banner)

                        <div class="border border-slate-200 rounded-2xl overflow-hidden mb-5 last:mb-0">

                            <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr]">

                                {{-- IMAGE --}}
                                <div class="bg-slate-900">

                                    <img
                                        src="{{ asset('storage/' . $banner->image) }}"
                                        alt="{{ $banner->title ?: 'Hero Banner' }}"
                                        class="w-full h-56 lg:h-full min-h-[220px] object-cover"
                                    >

                                </div>


                                {{-- CONTENT --}}
                                <div class="p-6">

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
                                    <div class="flex flex-wrap items-center gap-3 mt-5">

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
                                    <div class="flex flex-wrap items-center gap-3 mt-6 pt-5 border-t border-slate-100">

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