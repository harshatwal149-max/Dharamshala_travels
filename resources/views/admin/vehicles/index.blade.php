<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Vehicles Management - {{ \App\Models\Setting::get('site_title', 'Dharamshala Travels') }}
    </title>

    {{-- Dynamic Favicon --}}
    @if(\App\Models\Setting::get('site_favicon'))
        <link rel="icon"
              type="image/x-icon"
              href="{{ \App\Models\Setting::get('site_favicon') }}">
    @endif

    {{-- Inter Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    {{-- Tailwind --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">

    {{-- Vite --}}
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    {{-- Lucide --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- Alpine --}}
    <script defer
            src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        .vehicle-table th {
            white-space: nowrap;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased flex h-screen overflow-hidden">

    {{-- Common Admin Sidebar --}}
    @include('admin.partials.sidebar')


    {{-- Main Content --}}
    <div class="flex-1 flex flex-col overflow-y-auto min-w-0">

        {{-- Top Header --}}
        <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between shrink-0 sticky top-0 z-30">

            <div class="flex items-center gap-2 text-xs">
                <span class="text-slate-400">Admin</span>
                <span class="text-slate-300">/</span>
                <span class="font-bold text-slate-800">Vehicles</span>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                    <i data-lucide="globe" class="w-3.5 h-3.5 text-slate-500"></i>
                    <span>Website</span>
                </a>

                <button type="button"
                        onclick="openVehicleModal()"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Add Vehicle
                </button>
            </div>
        </header>


        {{-- Page Content --}}
        <main class="p-6 space-y-6">

            {{-- Heading --}}
            <section class="space-y-1">
                <h1 class="text-xl font-extrabold text-slate-900">
                    Vehicles Management
                </h1>

                <p class="text-sm text-slate-500">
                    Manage and track all vehicles in your fleet.
                </p>
            </section>


            {{-- Success --}}
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif


            {{-- Errors --}}
            @if($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
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


            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">
                            Total Vehicles
                        </span>
                        <span class="text-2xl font-extrabold text-slate-900">
                            {{ $vehicles->count() }}
                        </span>
                    </div>

                    <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-700">
                        <i data-lucide="car-front" class="w-5 h-5"></i>
                    </div>
                </div>


                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">
                            Active Fleet
                        </span>
                        <span class="text-2xl font-extrabold text-emerald-700">
                            {{ $vehicles->where('is_active', 1)->count() }}
                        </span>
                    </div>

                    <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-700">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                    </div>
                </div>


                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">
                            Categories
                        </span>
                        <span class="text-2xl font-extrabold text-slate-900">
                            {{ $vehicles->pluck('category')->filter()->unique()->count() }}
                        </span>
                    </div>

                    <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700">
                        <i data-lucide="layers" class="w-5 h-5"></i>
                    </div>
                </div>

            </div>


            {{-- Section Heading --}}
            <div>
                <h2 class="text-lg font-extrabold text-slate-900">
                    All Vehicles
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Showing {{ $vehicles->count() }} vehicles in fleet
                </p>
            </div>


            {{-- Vehicles Table --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full text-left border-collapse text-xs vehicle-table">

                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">

                                <th class="py-4 px-5">
                                    Vehicle
                                </th>

                                <th class="py-4 px-5">
                                    Category
                                </th>

                                <th class="py-4 px-5">
                                    Capacity
                                </th>

                                <th class="py-4 px-5">
                                    Fare
                                </th>

                                <th class="py-4 px-5">
                                    Status
                                </th>

                                <th class="py-4 px-5 text-right">
                                    Action
                                </th>

                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse($vehicles as $vehicle)

                                <tr class="hover:bg-slate-50 transition-colors">

                                    {{-- Vehicle --}}
                                    <td class="py-4 px-5">

                                        <div class="flex items-center gap-3 min-w-[260px]">

                                            <div class="w-16 h-12 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden shrink-0">

                                                @if($vehicle->image)
                                                    <img src="{{ $vehicle->image }}"
                                                         alt="{{ $vehicle->name }}"
                                                         class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <i data-lucide="car-front" class="w-5 h-5 text-slate-400"></i>
                                                    </div>
                                                @endif

                                            </div>

                                            <div class="min-w-0">

                                                <div class="font-bold text-slate-900 text-sm truncate">
                                                    {{ $vehicle->name }}
                                                </div>

                                                @if($vehicle->badge)
                                                    <div class="mt-1">
                                                        <span class="inline-flex px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-100 text-[10px] font-bold">
                                                            {{ $vehicle->badge }}
                                                        </span>
                                                    </div>
                                                @endif

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Category --}}
                                    <td class="py-4 px-5">

                                        <div class="font-semibold text-slate-700">
                                            {{ $vehicle->category }}
                                        </div>

                                        @if($vehicle->gallery)
                                            <div class="text-[10px] text-slate-400 mt-1">
                                                {{ count($vehicle->gallery) }} gallery image{{ count($vehicle->gallery) === 1 ? '' : 's' }}
                                            </div>
                                        @endif

                                    </td>


                                    {{-- Capacity --}}
                                    <td class="py-4 px-5">

                                        <div class="font-semibold text-slate-700">
                                            {{ $vehicle->seating_capacity }} Seats
                                        </div>

                                        <div class="text-[11px] text-slate-500 mt-1">
                                            {{ $vehicle->luggage_capacity }} Luggage
                                        </div>

                                    </td>


                                    {{-- Fare --}}
                                    <td class="py-4 px-5">

                                        <div class="font-bold text-slate-900">
                                            ₹{{ number_format($vehicle->base_fare, 2) }}
                                        </div>

                                        <div class="text-[11px] text-slate-500 mt-1">
                                            ₹{{ number_format($vehicle->rate_per_km, 2) }}/km
                                        </div>

                                    </td>


                                    {{-- Status --}}
                                    <td class="py-4 px-5">

                                        @if($vehicle->is_active)
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100 font-bold text-[11px]">
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg bg-slate-100 text-slate-600 border border-slate-200 font-bold text-[11px]">
                                                Inactive
                                            </span>
                                        @endif

                                    </td>


                                    {{-- Actions --}}
                                    <td class="py-4 px-5 text-right">

                                        <div class="flex items-center justify-end gap-2">

                                            <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}"
                                               class="px-3.5 py-2 rounded-lg border border-slate-200 bg-white text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                                                Edit
                                            </a>


                                            <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}"
                                                  method="POST"
                                                  class="delete-vehicle-form inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="px-3.5 py-2 rounded-lg border border-red-200 bg-red-50 text-red-600 text-xs font-semibold hover:bg-red-100 transition">
                                                    Delete
                                                </button>
                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center py-16">

                                        <div class="flex flex-col items-center justify-center">

                                            <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center mb-3">
                                                <i data-lucide="car-front" class="w-6 h-6 text-slate-400"></i>
                                            </div>

                                            <div class="font-bold text-slate-700">
                                                No vehicles found.
                                            </div>

                                            <div class="text-xs text-slate-400 mt-1">
                                                Add your first vehicle to the fleet.
                                            </div>

                                            <button type="button"
                                                    onclick="openVehicleModal()"
                                                    class="mt-4 px-4 py-2 rounded-lg bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800">
                                                Add Vehicle
                                            </button>

                                        </div>

                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </main>

    </div>


    {{-- =========================================================
         ADD VEHICLE MODAL
    ========================================================== --}}
    <div id="vehicleModal"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900 bg-opacity-50 p-4 overflow-y-auto">

        <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl border border-slate-200 my-8">

            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-200">

                <div>
                    <h2 class="text-lg font-extrabold text-slate-900">
                        Add Vehicle
                    </h2>

                    <p class="text-xs text-slate-500 mt-1">
                        Add a new vehicle to your fleet.
                    </p>
                </div>

                <button type="button"
                        onclick="closeVehicleModal()"
                        class="w-9 h-9 rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 flex items-center justify-center">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>

            </div>


            <form action="{{ route('admin.vehicles.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="p-6 space-y-5">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- Name --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Vehicle Name *
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               placeholder="Maruti Suzuki Dzire"
                               class="w-full h-11 px-3 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400">
                    </div>


                    {{-- Category --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Category *
                        </label>

                        <input type="text"
                               name="category"
                               value="{{ old('category') }}"
                               required
                               placeholder="Sedan / SUV"
                               class="w-full h-11 px-3 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400">
                    </div>


                    {{-- Badge --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Badge
                        </label>

                        <input type="text"
                               name="badge"
                               value="{{ old('badge') }}"
                               placeholder="Top Choice"
                               class="w-full h-11 px-3 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400">
                    </div>


                    {{-- Base Fare --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Base Fare *
                        </label>

                        <input type="number"
                               name="base_fare"
                               value="{{ old('base_fare') }}"
                               required
                               min="0"
                               step="0.01"
                               placeholder="1600"
                               class="w-full h-11 px-3 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400">
                    </div>


                    {{-- Rate Per KM --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Rate Per KM *
                        </label>

                        <input type="number"
                               name="rate_per_km"
                               value="{{ old('rate_per_km') }}"
                               required
                               min="0"
                               step="0.01"
                               placeholder="18"
                               class="w-full h-11 px-3 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400">
                    </div>


                    {{-- Seating --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Seating Capacity *
                        </label>

                        <input type="number"
                               name="seating_capacity"
                               value="{{ old('seating_capacity') }}"
                               required
                               min="1"
                               placeholder="4"
                               class="w-full h-11 px-3 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400">
                    </div>


                    {{-- Luggage --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Luggage Capacity *
                        </label>

                        <input type="number"
                               name="luggage_capacity"
                               value="{{ old('luggage_capacity') }}"
                               required
                               min="0"
                               placeholder="2"
                               class="w-full h-11 px-3 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400">
                    </div>

                </div>


                {{-- Main Image --}}
                <div class="border-t border-slate-100 pt-5">

                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                        Main Image URL
                    </label>

                    <input type="url"
                           name="image"
                           value="{{ old('image') }}"
                           placeholder="https://example.com/vehicle.jpg"
                           class="w-full h-11 px-3 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400">

                    <p class="text-[11px] text-slate-400 mt-1">
                        Or upload a local image below.
                    </p>

                </div>


                {{-- Main Image Upload --}}
                <div>

                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                        Upload Main Image
                    </label>

                    <input type="file"
                           name="image_file"
                           accept=".jpg,.jpeg,.png,.webp"
                           class="w-full p-2.5 rounded-lg border border-slate-200 text-sm bg-white">

                </div>


                {{-- Gallery --}}
                <div>

                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                        Gallery Images
                    </label>

                    <input type="file"
                           name="gallery[]"
                           multiple
                           accept=".jpg,.jpeg,.png,.webp"
                           class="w-full p-2.5 rounded-lg border border-slate-200 text-sm bg-white">

                    <p class="text-[11px] text-slate-400 mt-1">
                        You can select multiple interior/gallery images.
                    </p>

                </div>


                {{-- Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">

                    <button type="button"
                            onclick="closeVehicleModal()"
                            class="px-4 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-700 text-xs font-semibold hover:bg-slate-50">
                        Cancel
                    </button>

                    <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800">
                        Save Vehicle
                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- Scripts --}}
    <script>
        function openVehicleModal() {
            const modal = document.getElementById('vehicleModal');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }

        function closeVehicleModal() {
            const modal = document.getElementById('vehicleModal');

            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.addEventListener('DOMContentLoaded', function () {

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            document.querySelectorAll('.delete-vehicle-form').forEach(function (form) {

                form.addEventListener('submit', function (event) {

                    event.preventDefault();

                    Swal.fire({
                        title: 'Delete Vehicle?',
                        text: 'This vehicle will be permanently removed from the fleet.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Delete',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,
                        customClass: {
                            popup: 'rounded-2xl'
                        }
                    }).then(function (result) {

                        if (result.isConfirmed) {
                            form.submit();
                        }

                    });

                });

            });

            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: @json(session('success')),
                    timer: 2200,
                    showConfirmButton: false
                });
            @endif

        });
    </script>

</body>
</html>
