<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >


    {{-- =========================================================
         SEO
    ========================================================== --}}

    @include('components.seo', [

        'title' =>
            $vehicle->name .
            ' Taxi Booking in Dharamshala | Dharamshala Travels',

        'description' =>
            'Book ' .
            $vehicle->name .
            ' (' .
            $vehicle->category .
            ') for Dharamshala local sightseeing, Gaggal Airport transfers and Himachal tours with an experienced hill driver.',

        'image' => $vehicle->image ?? null

    ])


    {{-- =========================================================
         FAVICON
    ========================================================== --}}

    @if(\App\Models\Setting::get('site_favicon'))

        <link
            rel="icon"
            type="image/x-icon"
            href="{{ \App\Models\Setting::get('site_favicon') }}"
        >

    @endif


    {{-- =========================================================
         VITE / TAILWIND
    ========================================================== --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    {{-- =========================================================
         ICONS
    ========================================================== --}}

    <script src="https://unpkg.com/lucide@latest"></script>


    {{-- =========================================================
         SWEETALERT
    ========================================================== --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    {{-- =========================================================
         ALPINE JS
    ========================================================== --}}

    <script
        defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js">
    </script>


    {{-- =========================================================
         GOOGLE FONTS
    ========================================================== --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >


    <style>

        body {
            font-family: 'Inter', sans-serif;
        }

    </style>

</head>

<body class="bg-gray-50 text-gray-800 antialiased">

    <!-- Reusable Global Header -->
    @include('components.header')


    <!-- Main Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-xs text-gray-500 mb-6">
            <a href="/" class="hover:text-gray-900">Home</a>
            <span>/</span>
            <a href="/#fleet" class="hover:text-gray-900">Cabs</a>
            <span>/</span>
            <span class="text-gray-900 font-semibold">{{ $vehicle->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Cols: Vehicle Image Slider & Specs -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm"
                     x-data="{ 
                         active: 0, 
                         slides: {{ json_encode($vehicle->all_images) }},
                         next() { if(this.slides.length > 1) this.active = (this.active + 1) % this.slides.length },
                         prev() { if(this.slides.length > 1) this.active = (this.active - 1 + this.slides.length) % this.slides.length}
                     }">
                    
                    <!-- Main Slider Viewport -->
                    <div class="relative h-72 sm:h-96 w-full bg-gray-100 flex items-center justify-center overflow-hidden">
                        <template x-for="(img, idx) in slides" :key="idx">
                            <img :src="img" 
                                 x-show="active === idx" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 alt="{{ $vehicle->name }}" 
                                 class="w-full h-full object-contain p-4 absolute inset-0">
                        </template>

                        @if($vehicle->badge)
                        <span class="absolute top-4 left-4 z-10 bg-gray-900 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md">
                            {{ $vehicle->badge }}
                        </span>
                        @endif

                        <!-- Slide Controls -->
                        <template x-if="slides.length > 1">
                            <div>
                                <button type="button" @click="prev()" 
                                        class="absolute left-3 top-1/2 -translate-y-1/2 z-10 w-9 h-9 rounded-full bg-gray-900/60 hover:bg-gray-900 text-white flex items-center justify-center transition shadow">
                                    &#10094;
                                </button>
                                <button type="button" @click="next()" 
                                        class="absolute right-3 top-1/2 -translate-y-1/2 z-10 w-9 h-9 rounded-full bg-gray-900/60 hover:bg-gray-900 text-white flex items-center justify-center transition shadow">
                                    &#10095;
                                </button>
                                <span class="absolute bottom-3 right-3 z-10 bg-gray-900/75 text-white text-[10px] font-bold px-2.5 py-1 rounded-full">
                                    <span x-text="active + 1"></span> / <span x-text="slides.length"></span> Photos
                                </span>
                            </div>
                        </template>
                    </div>

                    <!-- Thumbnails Row -->
                    <template x-if="slides.length > 1">
                        <div class="p-3 bg-gray-50 border-t border-gray-100 flex items-center gap-2 overflow-x-auto">
                            <template x-for="(img, idx) in slides" :key="'thumb-'+idx">
                                <button type="button" @click="active = idx" 
                                        :class="active === idx ? 'ring-2 ring-emerald-600 scale-105' : 'opacity-60 hover:opacity-100'"
                                        class="w-16 h-12 rounded-lg border border-gray-200 overflow-hidden shrink-0 bg-white transition">
                                    <img :src="img" class="w-full h-full object-cover">
                                </button>
                            </template>
                        </div>
                    </template>

                    <div class="p-6">
                        <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-green-800 bg-green-100 px-2.5 py-1 rounded-md">
                                    {{ $vehicle->category }}
                                </span>
                                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-2">{{ $vehicle->name }}</h1>
                            </div>
                        </div>

                        <!-- Capacity Grid -->
                        <div class="grid grid-cols-3 gap-4 py-4 border-t border-b border-gray-100 my-6 text-center">
                            <div class="p-3 rounded-xl bg-gray-50 border border-gray-100">
                                <i data-lucide="users" class="w-5 h-5 text-gray-700 mx-auto mb-1"></i>
                                <span class="text-xs text-gray-500 block font-medium">Capacity</span>
                                <span class="text-sm font-bold text-gray-900">{{ $vehicle->seating_capacity }} Passengers</span>
                            </div>
                            <div class="p-3 rounded-xl bg-gray-50 border border-gray-100">
                                <i data-lucide="briefcase" class="w-5 h-5 text-gray-700 mx-auto mb-1"></i>
                                <span class="text-xs text-gray-500 block font-medium">Luggage</span>
                                <span class="text-sm font-bold text-gray-900">{{ $vehicle->luggage_capacity ?? 2 }} Bags</span>
                            </div>
                            <div class="p-3 rounded-xl bg-gray-50 border border-gray-100">
                                <i data-lucide="snowflake" class="w-5 h-5 text-gray-700 mx-auto mb-1"></i>
                                <span class="text-xs text-gray-500 block font-medium">Comfort</span>
                                <span class="text-sm font-bold text-gray-900">AC & Heater</span>
                            </div>
                        </div>

                        <!-- Key Features -->
                        <h3 class="text-sm font-bold text-gray-900 mb-3">Vehicle Features & Amenities</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs text-gray-700">
                            <div class="flex items-center space-x-2"><i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i><span>Experienced Mountain Chauffeur</span></div>
                            <div class="flex items-center space-x-2"><i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i><span>Sanitized & Clean Cabin</span></div>
                            <div class="flex items-center space-x-2"><i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i><span>Music System & Mobile Charging</span></div>
                            <div class="flex items-center space-x-2"><i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i><span>Commercial Permit & Valid Insurance</span></div>
                            <div class="flex items-center space-x-2"><i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i><span>All Weather Mechanical Fitness</span></div>
                            <div class="flex items-center space-x-2"><i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i><span>Fixed Upfront Mountain Rates</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right 1 Col: Direct Booking Box -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg sticky top-24">
                    <h3 class="text-base font-bold text-gray-900 mb-1">Reserve This Cab</h3>
                    <p class="text-xs text-gray-500 mb-5">Pay nothing right now. Free cancellation.</p>

                    <form action="{{ route('bookings.store') }}" method="POST" class="space-y-3.5 text-xs">
                        @csrf
                        <input type="hidden" name="booking_type" value="direct_cab">
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                        <div>
                            <label class="block font-semibold mb-1 text-gray-700">Your Full Name</label>
                            <input type="text" name="customer_name" required placeholder="e.g. Amit Verma" class="w-full p-2.5 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-gray-900">
                        </div>

                        <div>
                            <label class="block font-semibold mb-1 text-gray-700">Contact Number</label>
                            <input type="tel" name="customer_phone" required placeholder="e.g. 98160XXXXX" class="w-full p-2.5 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-gray-900">
                        </div>

                        <div>
                            <label class="block font-semibold mb-1 text-gray-700">Travel Date</label>
                            <input type="date" name="travel_date" required value="{{ date('Y-m-d') }}" class="w-full p-2.5 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-gray-900">
                        </div>

                        <div>
                            <label class="block font-semibold mb-1 text-gray-700">Pickup Location</label>
                            <input type="text" name="pickup_location" required placeholder="e.g. Gaggal Airport (DHM) / Hotel" class="w-full p-2.5 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-gray-900">
                        </div>

                        <div>
                            <label class="block font-semibold mb-1 text-gray-700">Drop Destination</label>
                            <input type="text" name="drop_location" placeholder="e.g. McLeodganj / Palampur / Bir" class="w-full p-2.5border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-gray-900">
                        </div>

                        <button type="submit" class="w-full py-3 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-lg text-xs transition mt-2 shadow-sm">
                            Confirm Instant Reservation
                        </button>
                    </form>

                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                        <span>Need Help? Call Us</span>
                        <a href="tel:+919876543210" class="font-bold text-gray-900">+91 98765 43210</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Fleet -->
        <?php if (isset($relatedVehicles) && count($relatedVehicles) > 0): ?>
        <div class="mt-14">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Other Vehicles in Fleet</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php foreach ($relatedVehicles as$rel): ?>
                <a href="{{ route('cabs.show', ['slug' => $rel->slug]) }}" class="bg-white rounded-xl overflow-hidden border border-gray-200 p-4block hover:shadow-md transition">
                    <img src="{{ $rel->image }}" alt="{{ $rel->name }}" class="w-full h-36 object-cover rounded-lg mb-3">
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                        <span>{{ $rel->category }}</span>
                        <span>{{ $rel->seating_capacity }} Seater</span>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm mb-2">{{ $rel->name }}</h4>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </main>

    <!-- Reusable Global Footer -->
    @include('components.footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            @if(session('booking_success'))
                Swal.fire({
                    icon: 'success',
                    iconColor: '#10b981',
                    title: '<span class="text-xl font-extrabold text-gray-900">Thank You, {{ session("customer_name") }}!</span>',
                    html: `
                        <div class="mt-2 text-center text-xs text-gray-600 space-y-3">
                            <p class="text-sm font-medium text-gray-700">Aapki cab reservation request safaltapoorvak receive ho gayi hai.</p>
                            
                            <div class="bg-gray-50 border border-dashed border-gray-300 rounded-xl p-3 inline-block">
                                <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider block">Booking Reference ID</span>
                                <span class="text-base font-black text-gray-900 tracking-widest">{{ session("booking_code") }}</span>
                            </div>

                            <div class="bg-green-50 text-green-900 rounded-xl p-3 text-xs leading-relaxed text-left flex items-start space-x-2 border border-green-100">
                                <span class="text-green-600 font-bold text-sm">âœ“</span>
                                <div>
                                    <span class="font-bold">Zero Advance Required</span>
                                    <p class="text-[11px] text-green-800 mt-0.5">Travel Date: <strong>{{ session('travel_date') }}</strong>. Hamara local chauffeur trip coordination ke liye aapse sampark karega.</p>
                                </div>
                            </div>
                        </div>
                    `,
                    confirmButtonText: 'Great, Understood!',
                    confirmButtonColor: '#111827',
                    customClass: {
                        popup: 'rounded-3xl p-6 shadow-2xl border border-gray-100',
                        confirmButton: 'px-6 py-2.5 rounded-xl font-semibold text-xs'
                    }
                });
            @endif
        });
    </script>
</body>
</html>
