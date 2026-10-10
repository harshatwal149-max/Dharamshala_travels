<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Tour Package - {{ $package->title }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased flex h-screen overflow-hidden">

    {{-- COMMON ADMIN SIDEBAR --}}
    @include('admin.partials.sidebar')

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col overflow-y-auto min-w-0">

        {{-- TOP HEADER --}}
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between">

            <div>
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <span>Admin</span>
                    <span>/</span>
                    <span>Packages</span>
                    <span>/</span>
                    <span class="text-slate-700 font-semibold">
                        Edit Package
                    </span>
                </div>

                <h1 class="text-lg font-bold text-slate-900 mt-1">
                    Edit Tour Package
                </h1>
            </div>

            <div class="flex items-center gap-2">

                <a href="{{ url('/') }}"
                    target="_blank"
                    class="px-4 py-2 rounded-lg bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition">
                    Website
                </a>

                <a href="{{ url('/admin/tours') }}"
                    class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Back to Packages
                </a>

            </div>

        </header>

        <div class="p-6 space-y-6">

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">

                {{-- HEADER --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-5 border-b border-gray-100 mb-6">

                    <div>

                        <h1 class="text-xl font-bold text-gray-900">
                            Edit Tour: {{ $package->title }}
                        </h1>

                        <p class="text-xs text-gray-500 mt-1">
                            Itinerary pricing aur thumbnail image update karein.
                        </p>

                    </div>

                    <a href="{{ url('/admin/tours') }}"
                        class="inline-flex items-center justify-center text-xs font-semibold px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Back to Packages
                    </a>

                </div>

                {{-- VALIDATION ERRORS --}}
                @if($errors->any())

                <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl">

                    <ul class="text-xs text-red-600 space-y-1">

                        @foreach($errors->all() as $error)

                        <li>• {{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

                @endif

                {{-- FORM --}}
                <form action="{{ route('admin.packages.update', $package->id) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-5">

                    @csrf
                    @method('PUT')

                    {{-- TOUR TITLE --}}
                    <div>

                        <label class="block text-xs font-bold text-gray-700 mb-1.5">
                            Tour Title
                        </label>

                        <input type="text"
                            name="title"
                            value="{{ old('title', $package->title) }}"
                            required
                            class="w-full p-3 text-sm border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">

                    </div>

                    {{-- DURATION + PRICE --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>

                            <label class="block text-xs font-bold text-gray-700 mb-1.5">
                                Duration
                            </label>

                            <input type="text"
                                name="duration"
                                value="{{ old('duration', $package->duration) }}"
                                required
                                placeholder="FullDay / 2 Days"
                                class="w-full p-3 text-sm border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">

                        </div>

                        <div>

                            <label class="block text-xs font-bold text-gray-700 mb-1.5">
                                Starting Price (₹)
                            </label>

                            <input type="number"
                                step="0.01"
                                name="starting_price"
                                value="{{ old('starting_price', $package->starting_price) }}"
                                required
                                class="w-full p-3 text-sm border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">

                        </div>

                    </div>

                    {{-- SHORT DESCRIPTION --}}
                    <div>

                        <label class="block text-xs font-bold text-gray-700 mb-1.5">
                            Short Description
                        </label>

                        <textarea name="short_desc"
                            required
                            rows="4"
                            class="w-full p-3 text-sm border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 resize-none">{{ old('short_desc', $package->short_desc) }}</textarea>

                    </div>

                    @php
                        $itineraryText = is_array($package->itinerary)
                            ? collect($package->itinerary)->map(fn ($text, $day) => (is_numeric($day) ? 'Day ' . ($day + 1) : $day) . ': ' . (is_array($text) ? implode(', ', $text) : $text))->implode("\n")
                            : (string) $package->itinerary;
                    @endphp

                    {{-- ITINERARY --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">
                            Day-wise Itinerary
                        </label>

                        <textarea name="itinerary"
                            rows="8"
                            placeholder="Day 1: ...&#10;Day 2: ..."
                            class="w-full p-3 text-sm border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">{{ old('itinerary', $itineraryText) }}</textarea>

                        <p class="text-[11px] text-gray-500 mt-1">Har din ek nayi line mein likhein: <strong>Day 1: ...</strong></p>
                    </div>

                    {{-- INCLUSIONS --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">
                            Inclusions
                        </label>

                        <textarea name="inclusions"
                            rows="4"
                            class="w-full p-3 text-sm border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">{{ old('inclusions', implode("\n", $package->inclusion_list)) }}</textarea>

                        <p class="text-[11px] text-gray-500 mt-1">Ek line mein ek inclusion.</p>
                    </div>

                    {{-- THUMBNAIL --}}
                    <div class="p-5 bg-gray-50 rounded-xl border border-gray-200 space-y-4">

                        <span class="block text-sm font-bold text-gray-700">
                            Tour Thumbnail
                        </span>

                        {{-- CURRENT IMAGE --}}
                        @if($package->thumbnail)

                        <div class="flex items-center gap-4">

                            <img src="{{ $package->thumbnail }}"
                                class="w-20 h-16 rounded-lg object-cover border border-gray-300"
                                alt="Current Thumbnail">

                            <div>

                                <p class="text-xs font-semibold text-gray-700">
                                    Current Thumbnail
                                </p>

                                <p class="text-[11px] text-gray-500 mt-1">
                                    Current active photo preview
                                </p>

                            </div>

                        </div>

                        @endif

                        {{-- FILE UPLOAD --}}
                        <div>

                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                Option 1: Upload from Computer
                            </label>

                            <input type="file"
                                name="thumbnail_file"
                                accept="image/*"
                                class="w-full p-2 bg-white border border-gray-300 rounded-lg text-xs">

                        </div>

                        <div class="text-center text-xs font-bold text-gray-400">
                            --- OR ---
                        </div>

                        {{-- IMAGE URL --}}
                        <div>

                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                Option 2: Direct Image URL
                            </label>

                            <input type="url"
                                name="thumbnail"
                                value="{{ old('thumbnail', $package->thumbnail) }}"
                                placeholder="https://..."
                                class="w-full p-3 text-sm border border-gray-300 rounded-lg bg-white outline-none focus:ring-2 focus:ring-emerald-600">

                        </div>

                    </div>

                    {{-- ADDITIONAL PACKAGE GALLERY --}}

                    <div class="p-5 bg-gray-50 rounded-xl border border-gray-200 space-y-6">

                        <div>

                            <h2 class="text-sm font-bold text-gray-700">
                                Additional Tour Gallery
                            </h2>

                            <p class="text-[11px] text-gray-500 mt-1">
                                Main thumbnail ke alawa maximum 4 additional images add karein.
                            </p>

                        </div>

                        {{-- IMAGE 2 --}}

                        <div class="p-4 bg-white rounded-xl border border-gray-200 space-y-4">

                            <div class="flex items-center justify-between">

                                <span class="text-xs font-bold text-gray-700">
                                    Gallery Image 1
                                </span>

                                @if($package->image_2)

                                <span class="text-[10px] font-semibold text-emerald-600">
                                    Image Added
                                </span>

                                @endif

                            </div>

                            @if($package->image_2)

                            <img src="{{ $package->image_2 }}"
                                class="w-32 h-20 rounded-lg object-cover border border-gray-300"
                                alt="Gallery Image 1">

                            @endif

                            <div>

                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                    Option 1: Upload from Computer
                                </label>

                                <input type="file"
                                    name="image_2_file"
                                    accept="image/*"
                                    class="w-full p-2 bg-white border border-gray-300 rounded-lg text-xs">

                            </div>

                            <div class="text-center text-xs font-bold text-gray-400">
                                --- OR ---
                            </div>

                            <div>

                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                    Option 2: Direct Image URL
                                </label>

                                <input type="url"
                                    name="image_2"
                                    value="{{ old('image_2', $package->image_2) }}"
                                    placeholder="https://..."
                                    class="w-full p-3 text-sm border border-gray-300 rounded-lg bg-white outline-none focus:ring-2 focus:ring-emerald-600">

                            </div>

                        </div>

                        {{-- IMAGE 3 --}}

                        <div class="p-4 bg-white rounded-xl border border-gray-200 space-y-4">

                            <div class="flex items-center justify-between">

                                <span class="text-xs font-bold text-gray-700">
                                    Gallery Image 2
                                </span>

                                @if($package->image_3)

                                <span class="text-[10px] font-semibold text-emerald-600">
                                    Image Added
                                </span>

                                @endif

                            </div>

                            @if($package->image_3)

                            <img src="{{ $package->image_3 }}"
                                class="w-32 h-20 rounded-lg object-cover border border-gray-300"
                                alt="Gallery Image 2">

                            @endif

                            <div>

                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                    Option 1: Upload from Computer
                                </label>

                                <input type="file"
                                    name="image_3_file"
                                    accept="image/*"
                                    class="w-full p-2 bg-white border border-gray-300 rounded-lg text-xs">

                            </div>

                            <div class="text-center text-xs font-bold text-gray-400">
                                --- OR ---
                            </div>

                            <div>

                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                    Option 2: Direct Image URL
                                </label>

                                <input type="url"
                                    name="image_3"
                                    value="{{ old('image_3', $package->image_3) }}"
                                    placeholder="https://..."
                                    class="w-full p-3 text-sm border border-gray-300 rounded-lg bg-white outline-none focus:ring-2 focus:ring-emerald-600">

                            </div>

                        </div>

                        {{-- IMAGE 4 --}}

                        <div class="p-4 bg-white rounded-xl border border-gray-200 space-y-4">

                            <div class="flex items-center justify-between">

                                <span class="text-xs font-bold text-gray-700">
                                    Gallery Image 3
                                </span>

                                @if($package->image_4)

                                <span class="text-[10px] font-semibold text-emerald-600">
                                    Image Added
                                </span>

                                @endif

                            </div>

                            @if($package->image_4)

                            <img src="{{ $package->image_4 }}"
                                class="w-32 h-20 rounded-lg object-cover border border-gray-300"
                                alt="Gallery Image 3">

                            @endif

                            <div>

                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                    Option 1: Upload from Computer
                                </label>

                                <input type="file"
                                    name="image_4_file"
                                    accept="image/*"
                                    class="w-full p-2 bg-white border border-gray-300 rounded-lg text-xs">

                            </div>

                            <div class="text-center text-xs font-bold text-gray-400">
                                --- OR ---
                            </div>

                            <div>

                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                    Option 2: Direct Image URL
                                </label>

                                <input type="url"
                                    name="image_4"
                                    value="{{ old('image_4', $package->image_4) }}"
                                    placeholder="https://..."
                                    class="w-full p-3 text-sm border border-gray-300 rounded-lg bg-white outline-none focus:ring-2 focus:ring-emerald-600">

                            </div>

                        </div>

                        {{-- IMAGE 5 --}}

                        <div class="p-4 bg-white rounded-xl border border-gray-200 space-y-4">

                            <div class="flex items-center justify-between">

                                <span class="text-xs font-bold text-gray-700">
                                    Gallery Image 4
                                </span>

                                @if($package->image_5)

                                <span class="text-[10px] font-semibold text-emerald-600">
                                    Image Added
                                </span>

                                @endif

                            </div>

                            @if($package->image_5)

                            <img src="{{ $package->image_5 }}"
                                class="w-32 h-20 rounded-lg object-cover border border-gray-300"
                                alt="Gallery Image 4">

                            @endif

                            <div>

                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                    Option 1: Upload from Computer
                                </label>

                                <input type="file"
                                    name="image_5_file"
                                    accept="image/*"
                                    class="w-full p-2 bg-white border border-gray-300 rounded-lg text-xs">

                            </div>

                            <div class="text-center text-xs font-bold text-gray-400">
                                --- OR ---
                            </div>

                            <div>

                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                    Option 2: Direct Image URL
                                </label>

                                <input type="url"
                                    name="image_5"
                                    value="{{ old('image_5', $package->image_5) }}"
                                    placeholder="https://..."
                                    class="w-full p-3 text-sm border border-gray-300 rounded-lg bg-white outline-none focus:ring-2 focus:ring-emerald-600">

                            </div>

                        </div>

                    </div>

                    {{-- BUTTONS --}}

                    <div class="pt-4 flex flex-col-reverse sm:flex-row justify-end gap-3">

                        <a href="{{ url('/admin/tours') }}"
                            class="px-5 py-2.5 border border-gray-300 rounded-xl text-gray-700 text-sm font-semibold hover:bg-gray-50 transition text-center">
                            Cancel
                        </a>

                        <button type="submit"
                            class="px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                            Save Changes
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>

</body>

</html>