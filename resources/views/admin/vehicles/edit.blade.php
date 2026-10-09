<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Vehicle - {{ $vehicle->name }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col overflow-y-auto min-w-0">

        {{-- TOP HEADER --}}
        <header
            class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between shrink-0 sticky top-0 z-30">

            <div class="flex items-center gap-2 text-xs">
                <span class="text-slate-400">Admin</span>

                <span class="text-slate-300">/</span>

                <a href="{{ route('admin.vehicles.index') }}"
                   class="text-slate-500 hover:text-slate-800 transition-colors">
                    Vehicles
                </a>

                <span class="text-slate-300">/</span>

                <span class="font-bold text-slate-800">
                    Edit Vehicle
                </span>
            </div>

            <div class="flex items-center gap-3">

                <a href="{{ route('home') }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">

                    <i data-lucide="globe" class="w-3.5 h-3.5 text-slate-500"></i>

                    <span>Website</span>
                </a>

                <a href="{{ route('admin.vehicles.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition">

                    <i data-lucide="arrow-left" class="w-4 h-4"></i>

                    Back to Vehicles
                </a>

            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="p-6 space-y-6">

            <section class="space-y-1">

                <h1 class="text-xl font-extrabold text-slate-900">
                    Edit Vehicle: {{ $vehicle->name }}
                </h1>

                <p class="text-sm text-slate-500">
                    Update fleet details, primary image and interior gallery.
                </p>

            </section>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">

                {{-- SUCCESS MESSAGE --}}
                @if(session('success'))
                    <div
                        class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm flex items-center gap-2">

                        <i data-lucide="check-circle"
                           class="w-4 h-4 text-emerald-600"></i>

                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                {{-- VALIDATION ERRORS --}}
                @if($errors->any())
                    <div
                        class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">

                        <div class="font-bold mb-2">
                            Please fix the following errors:
                        </div>

                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>
                @endif

                {{-- VEHICLE UPDATE FORM --}}
                <form
                    action="{{ route('admin.vehicles.update', $vehicle->id) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-6 text-xs">

                    @csrf
                    @method('PUT')

                    {{-- VEHICLE NAME --}}
                    <div>

                        <label class="block font-bold text-gray-700 mb-1">
                            Vehicle Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $vehicle->name) }}"
                            required
                            class="w-full h-11 px-3 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400">

                    </div>

                    {{-- CATEGORY + BADGE --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>

                            <label class="block font-bold text-gray-700 mb-1">
                                Category
                            </label>

                            <input
                                type="text"
                                name="category"
                                value="{{ old('category', $vehicle->category) }}"
                                required
                                placeholder="SUV / Sedan"
                                class="w-full h-11 px-3 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400">

                        </div>

                        <div>

                            <label class="block font-bold text-gray-700 mb-1">
                                Badge (Optional)
                            </label>

                            <input
                                type="text"
                                name="badge"
                                value="{{ old('badge', $vehicle->badge) }}"
                                placeholder="Top Choice"
                                class="w-full h-11 px-3 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400">

                        </div>

                    </div>

                    {{-- BASE FARE + RATE --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>

                            <label class="block font-bold text-gray-700 mb-1">
                                Base Fare (₹)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="base_fare"
                                value="{{ old('base_fare', $vehicle->base_fare) }}"
                                required
                                class="w-full h-11 px-3 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400">

                        </div>

                        <div>

                            <label class="block font-bold text-gray-700 mb-1">
                                Rate / KM (₹)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="rate_per_km"
                                value="{{ old('rate_per_km', $vehicle->rate_per_km) }}"
                                required
                                class="w-full h-11 px-3 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400">

                        </div>

                    </div>

                    {{-- SEATING + LUGGAGE --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>

                            <label class="block font-bold text-gray-700 mb-1">
                                Seating Capacity
                            </label>

                            <input
                                type="number"
                                name="seating_capacity"
                                value="{{ old('seating_capacity', $vehicle->seating_capacity) }}"
                                required
                                class="w-full h-11 px-3 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400">

                        </div>

                        <div>

                            <label class="block font-bold text-gray-700 mb-1">
                                Luggage Bags
                            </label>

                            <input
                                type="number"
                                name="luggage_capacity"
                                value="{{ old('luggage_capacity', $vehicle->luggage_capacity) }}"
                                required
                                class="w-full h-11 px-3 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400">

                        </div>

                    </div>

                                        {{-- PRIMARY IMAGE --}}
                    <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 space-y-4">

                        <span class="block font-bold text-gray-700">
                            Primary Display Image (File Upload ya URL)
                        </span>

                        @if($vehicle->image)

                            <div class="flex items-center space-x-3">

                                <img
                                    src="{{ $vehicle->image }}"
                                    class="w-20 h-14 rounded-lg object-cover border border-slate-200 bg-white"
                                    alt="Current Image">

                                <span class="text-[11px] text-gray-500">
                                    Current active primary photo
                                </span>

                            </div>

                        @endif

                        {{-- FILE UPLOAD --}}
                        <div>

                            <label class="block text-gray-600 mb-1 font-semibold">
                                Option 1: Upload from Computer
                            </label>

                            <input
                                type="file"
                                name="image_file"
                                accept="image/*"
                                class="w-full p-2.5 rounded-lg border border-slate-200 text-sm bg-white">

                        </div>

                        <div class="text-center font-bold text-gray-400">
                            --- OR ---
                        </div>

                        {{-- IMAGE URL --}}
                        <div>

                            <label class="block text-gray-600 mb-1 font-semibold">
                                Option 2: Direct Image URL
                            </label>

                            <input
                                type="url"
                                name="image"
                                value="{{ old('image', $vehicle->image) }}"
                                placeholder="https://..."
                                class="w-full h-11 px-3 rounded-lg border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400">

                        </div>

                    </div>

                    {{-- GALLERY --}}
                    <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 space-y-4">

                        <span class="block font-bold text-gray-700">
                            Interior & Additional Photos (Multiple Files)
                        </span>

                        <div>

                            <label class="block text-gray-600 mb-1 font-semibold">
                                Select 3–4 Interior Photos
                            </label>

                            <input
                                type="file"
                                name="gallery[]"
                                multiple
                                accept="image/*"
                                class="w-full p-2.5 rounded-lg border border-slate-200 text-sm bg-white">

                            <span class="text-[10px] text-gray-400 mt-1 block">
                                Tip: Keyboard par
                                <kbd class="px-1 py-0.5 bg-gray-200 rounded text-gray-700">
                                    Ctrl
                                </kbd>
                                dabakar ek sath multiple interior images select karein.
                            </span>

                        </div>

                        {{-- EXISTING GALLERY --}}
                        @if(is_array($vehicle->gallery) && count($vehicle->gallery) > 0)

                            <div class="pt-2 border-t border-gray-200">

                                <span class="text-xs font-semibold text-gray-700 block mb-2">
                                    Currently Uploaded Photos
                                    ({{ count($vehicle->gallery) }}):
                                </span>

                                <div class="grid grid-cols-3 sm:grid-cols-4 gap-2.5">

                                    @foreach($vehicle->gallery as $galleryImg)

                                        <div
                                            class="relative group rounded-lg overflow-hidden border border-gray-300 bg-white h-20 shadow-sm">

                                            <img
                                                src="{{ $galleryImg }}"
                                                class="w-full h-full object-cover"
                                                alt="Gallery Image">

                                            <button
                                                type="button"
                                                onclick="confirmDeleteGalleryPhoto(
                                                    '{{ $vehicle->id }}',
                                                    '{{ addslashes($galleryImg) }}'
                                                )"
                                                title="Delete this interior photo"
                                                class="absolute top-1 right-1 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 shadow transition">

                                                <svg
                                                    class="w-3 h-3"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24">

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2.5"
                                                        d="M6 18L18 6M6 6l12 12">
                                                    </path>

                                                </svg>

                                            </button>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        @endif

                    </div>

                    {{-- ACTIONS --}}
                    <div class="pt-4 flex justify-end space-x-3">

                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="px-4 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">

                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="px-5 py-2.5 rounded-lg bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition shadow-sm">

                            Save Changes
                        </button>

                    </div>

                </form>

            </div>

        </main>

    </div>

    {{-- HIDDEN DELETE FORM --}}
    <form
        id="delete-single-gallery-form"
        method="POST"
        style="display: none;">

        @csrf
        @method('DELETE')

        <input
            type="hidden"
            name="image_url"
            id="delete-gallery-image-url">

    </form>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

        });

        function confirmDeleteGalleryPhoto(vehicleId, imageUrl) {

            Swal.fire({
                title: 'Delete this photo?',
                text: 'This interior photo will be permanently deleted from the vehicle gallery.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                reverseButtons: true,

                customClass: {
                    popup: 'rounded-2xl border border-gray-200 shadow-xl',

                    confirmButton:
                        'px-4 py-2 rounded-xl text-xs font-semibold',

                    cancelButton:
                        'px-4 py-2 rounded-xl text-xs font-semibold'
                }

            }).then((result) => {

                if (result.isConfirmed) {

                    const form =
                        document.getElementById('delete-single-gallery-form');

                    form.action =
                        `/admin/vehicles/${vehicleId}/gallery`;

                    document.getElementById(
                        'delete-gallery-image-url'
                    ).value = imageUrl;

                    form.submit();
                }

            });

        }
    </script>

</body>

</html>