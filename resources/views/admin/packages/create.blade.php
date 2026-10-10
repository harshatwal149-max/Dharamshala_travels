<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add New Tour - {{ \App\Models\Setting::get('site_title', 'Dharamshala Travels') }}</title>

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
                    <span>Tours</span>
                    <span>/</span>
                    <span class="text-slate-700 font-semibold">Add New Tour</span>
                </div>

                <h1 class="text-lg font-bold text-slate-900 mt-1">Add New Tour</h1>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ url('/') }}" target="_blank"
                    class="px-4 py-2 rounded-lg bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition">
                    Website
                </a>

                <a href="{{ route('admin.tours.index') }}"
                    class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Back to Tours
                </a>
            </div>

        </header>

        <div class="p-6 space-y-6">

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">

                <div class="pb-5 border-b border-gray-100 mb-6">
                    <h2 class="text-xl font-bold text-gray-900">New Tour Package</h2>
                    <p class="text-xs text-gray-500 mt-1">
                        Tour details, day-wise itinerary, inclusions aur images add karein.
                    </p>
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
                <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-5">

                    @csrf

                    {{-- TOUR TITLE --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Tour Title *</label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                            placeholder="e.g. Shimla & Manali Tour Package"
                            class="w-full p-3 text-sm border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                    </div>

                    {{-- DURATION + PRICE --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Duration *</label>
                            <input type="text" name="duration" value="{{ old('duration') }}" required
                                placeholder="e.g. 6 Days / 5 Nights"
                                class="w-full p-3 text-sm border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Starting Price (₹) *</label>
                            <input type="number" step="0.01" min="0" name="starting_price"
                                value="{{ old('starting_price') }}" required placeholder="e.g. 18500"
                                class="w-full p-3 text-sm border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                        </div>
                    </div>

                    {{-- SHORT DESCRIPTION --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Short Description *</label>
                        <textarea name="short_desc" required rows="3" maxlength="255"
                            placeholder="Tour route & highlights in 1-2 lines (max 255 characters)"
                            class="w-full p-3 text-sm border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 resize-none">{{ old('short_desc') }}</textarea>
                    </div>

                    {{-- ITINERARY --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Day-wise Itinerary</label>
                        <textarea name="itinerary" rows="8"
                            placeholder="Day 1: Arrival Amritsar. Check in at hotel...&#10;Day 2: Golden Temple, Jallianwala Bagh, Wagah Border...&#10;Day 3: Amritsar - Dharamshala (215 km / 5 hrs)..."
                            class="w-full p-3 text-sm border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">{{ old('itinerary') }}</textarea>
                        <p class="text-[11px] text-gray-500 mt-1">Har din ek nayi line mein likhein: <strong>Day 1: ...</strong></p>
                    </div>

                    {{-- INCLUSIONS --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Inclusions</label>
                        <textarea name="inclusions" rows="4"
                            placeholder="Hotel stay with breakfast&#10;Private cab for all transfers & sightseeing&#10;Fuel, tolls, parking & driver allowance"
                            class="w-full p-3 text-sm border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">{{ old('inclusions') }}</textarea>
                        <p class="text-[11px] text-gray-500 mt-1">Ek line mein ek inclusion.</p>
                    </div>

                    {{-- THUMBNAIL --}}
                    <div class="p-5 bg-gray-50 rounded-xl border border-gray-200 space-y-4">
                        <span class="block text-sm font-bold text-gray-700">Tour Thumbnail *</span>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Option 1: Upload from Computer</label>
                            <input type="file" name="thumbnail_file" accept=".jpg,.jpeg,.png,.webp"
                                class="w-full p-2 bg-white border border-gray-300 rounded-lg text-xs">
                            <p class="text-[11px] text-gray-400 mt-1">Max 3MB. JPG, PNG or WEBP.</p>
                        </div>

                        <div class="text-center text-xs font-bold text-gray-400">--- OR ---</div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Option 2: Direct Image URL</label>
                            <input type="url" name="thumbnail" value="{{ old('thumbnail') }}" placeholder="https://..."
                                class="w-full p-3 text-sm border border-gray-300 rounded-lg bg-white outline-none focus:ring-2 focus:ring-emerald-600">
                        </div>
                    </div>

                    {{-- ADDITIONAL TOUR GALLERY --}}
                    <div class="p-5 bg-gray-50 rounded-xl border border-gray-200 space-y-6">
                        <div>
                            <h2 class="text-sm font-bold text-gray-700">Additional Tour Gallery</h2>
                            <p class="text-[11px] text-gray-500 mt-1">
                                Main thumbnail ke alawa maximum 4 additional images add karein (optional).
                            </p>
                        </div>

                        @foreach(['image_2', 'image_3', 'image_4', 'image_5'] as $field)
                            <div class="p-4 bg-white rounded-xl border border-gray-200 space-y-4">
                                <span class="block text-xs font-bold text-gray-700">Gallery Image {{ $loop->iteration }}</span>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Option 1: Upload from Computer</label>
                                    <input type="file" name="{{ $field }}_file" accept=".jpg,.jpeg,.png,.webp"
                                        class="w-full p-2 bg-white border border-gray-300 rounded-lg text-xs">
                                </div>

                                <div class="text-center text-xs font-bold text-gray-400">--- OR ---</div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Option 2: Direct Image URL</label>
                                    <input type="url" name="{{ $field }}" value="{{ old($field) }}" placeholder="https://..."
                                        class="w-full p-3 text-sm border border-gray-300 rounded-lg bg-white outline-none focus:ring-2 focus:ring-emerald-600">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- BUTTONS --}}
                    <div class="pt-4 flex flex-col-reverse sm:flex-row justify-end gap-3">
                        <a href="{{ route('admin.tours.index') }}"
                            class="px-5 py-2.5 border border-gray-300 rounded-xl text-gray-700 text-sm font-semibold hover:bg-gray-50 transition text-center">
                            Cancel
                        </a>

                        <button type="submit"
                            class="px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                            Publish Tour
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
