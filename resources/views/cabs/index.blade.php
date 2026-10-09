<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Dynamic SEO & Meta Tags -->
    @include('components.seo', [
        'title' => 'Book Cab in Dharamshala | Verified Fleet & Transparent Rates',
        'description' => 'Book verified sedans, SUVs, and luxury tempo travellers in Dharamshala. Fixed upfront fares, Gaggal Airport transfers, and experienced mountain drivers.'
    ])

    @if(\App\Models\Setting::get('site_favicon'))
        <link rel="icon" type="image/x-icon" href="{{ \App\Models\Setting::get('site_favicon') }}">
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- Global Header -->
    @include('components.header')

    <!-- Hero Header -->
    <section class="bg-gray-900 text-white py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 text-center">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-gray-800 text-emerald-400 border border-gray-700mb-3">
                100% Sanitized & Mountain-Certified Cabs
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Executive Cab Fleet & Bookings</h1>
            <p class="text-gray-400 text-sm max-w-xl mx-auto mt-2">
                Choose the ideal vehicle for your Kangra Valley journey, Gaggal Airport transfers, or high-altitude mountain circuits.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-12 flex-1 w-full" x-data="{ selectedCab: null, bookingModal: false }">

        <!-- Vehicle Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($vehicles as $cab)
                @php
                    $rawImg = $cab->image_url ?? $cab->image ?? $cab->featured_image ?? $cab->vehicle_image ?? null;
                    if (!$rawImg && isset($cab->gallery) && count($cab->gallery) > 0) {
                        $rawImg = is_array($cab->gallery) ? $cab->gallery[0] : ($cab->gallery->first()->image_path ?? null);
                    }

                    $cabImgUrl = null;
                    if ($rawImg) {
                        if (\Illuminate\Support\Str::startsWith($rawImg, ['http://', 'https://'])) {
                            $cabImgUrl = $rawImg;
                        } elseif (\Illuminate\Support\Str::startsWith($rawImg, 'storage/')) {
                            $cabImgUrl = asset($rawImg);
                        } else {
                            $cabImgUrl = asset('storage/' . ltrim($rawImg, '/'));
                        }
                    }
                @endphp

                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between group">
                    <div>
                        <!-- Clickable Vehicle Image Banner -->
                        <a href="{{ route('cabs.show', ['slug' => $cab->slug]) }}" class="block relative h-48 bg-gray-100 overflow-hidden">
                            @if($cabImgUrl)
                                <img src="{{ $cabImgUrl }}" 
                                     alt="{{ $cab->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                                    <i data-lucide="car" class="w-12 h-12"></i>
                                </div>
                            @endif

                            <span class="absolute top-3 right-3 px-2.5 py-1 bg-gray-900/80 backdrop-blur-xs text-white text-[11px] font-bold rounded-lg uppercase tracking-wider">
                                {{ $cab->category ?? 'Sedan / SUV' }}
                            </span>
                        </a>

                        <!-- Details Body -->
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div>
                                    <!-- Clickable Title -->
                                    <a href="{{ route('cabs.show', ['slug' => $cab->slug]) }}" class="text-lg font-bold text-gray-900 hover:text-emerald-700 transition">
                                        {{ $cab->name }}
                                    </a>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $cab->model_year ?? 'Recent Model' }} â€¢ Mountain Certified</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs text-gray-400 block">Starting from</span>
                                    <span class="text-lg font-extrabold text-emerald-700">â‚¹{{ number_format($cab->base_fare ?? 1500)}}</span>
                                </div>
                            </div>

                            <!-- Specs -->
                            <div class="grid grid-cols-3 gap-2 mt-4 pt-4 border-t border-gray-100 text-center text-xs text-gray-600">
                                <div class="p-2 bg-gray-50 rounded-lg">
                                    <i data-lucide="users" class="w-3.5 h-3.5 mx-auto mb-1 text-gray-500"></i>
                                    <span>{{ $cab->seating_capacity ?? 4 }} Seater</span>
                                </div>
                                <div class="p-2 bg-gray-50 rounded-lg">
                                    <i data-lucide="luggage" class="w-3.5 h-3.5 mx-auto mb-1 text-gray-500"></i>
                                    <span>{{ $cab->luggage_capacity ?? 2 }} Bags</span>
                                </div>
                                <div class="p-2 bg-gray-50 rounded-lg">
                                    <i data-lucide="wind" class="w-3.5 h-3.5 mx-auto mb-1 text-gray-500"></i>
                                    <span>AC / Heater</span>
                                </div>
                            </div>

                            @if($cab->description)
                                <p class="text-xs text-gray-500 mt-4 line-clamp-2 leading-relaxed">
                                    {{ $cab->description }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Dual Action Buttons -->
                    <div class="p-6 pt-0 grid grid-cols-2 gap-2">
                        <a href="{{ route('cabs.show', ['slug' => $cab->slug]) }}" 
                           class="py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-xl text-xs transition text-center flex items-center justify-center space-x-1">
                            <span>View Details</span>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                        </a>

                        <button type="button" 
                                @click="selectedCab = { id: {{ $cab->id }}, name: '{{ addslashes($cab->name) }}', fare: {{ $cab->base_fare ?? 1500 }} }; bookingModal = true"
                                class="py-2.5 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-xl text-xs transition flex items-center justify-center space-x-1">
                            <i data-lucide="calendar-check" class="w-3.5 h-3.5 text-emerald-400"></i>
                            <span>Book Now</span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-gray-200">
                    <i data-lucide="car" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                    <h3 class="text-base font-bold text-gray-700">No Cabs Available Right Now</h3>
                    <p class="text-xs text-gray-500 mt-1">Please connect directly with our travel desk for immediate dispatch.</p>
                    <a href="{{ route('contact') }}" class="inline-block mt-4 px-4 py-2 bg-gray-900 text-white rounded-lg text-xs font-semibold">Contact Desk</a>
                </div>
            @endforelse
        </div>

        <!-- Booking Modal Window -->
        <div x-show="bookingModal" 
             style="display: none;" 
             class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
            
            <div @click.away="bookingModal = false" 
                 class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6 sm:p-8 relative">
                
                <button @click="bookingModal = false" type="button" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>

                <div class="mb-5">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Instant Reservation</span>
                    <h3 class="text-xl font-bold text-gray-900">Book <span x-text="selectedCab ? selectedCab.name : 'Cab'"></span></h3>
                    <p class="text-xs text-gray-500 mt-0.5">Base Fare from â‚¹<span x-text="selectedCab ? selectedCab.fare : 0"></span>. Fill details to confirm pickup.</p>
                </div>

                <form action="{{ route('bookings.store') }}" method="POST" class="space-y-3.5 text-xs">
                    @csrf
                    <input type="hidden" name="booking_type" value="cab_hire">
                    <input type="hidden" name="vehicle_id" :value="selectedCab ? selectedCab.id : ''">

                    <div>
                        <label class="block font-semibold mb-1 text-gray-700 uppercase text-[10px]">Your Name *</label>
                        <input type="text" name="customer_name" required placeholder="Full Name" class="w-full p-2.5 bg-gray-50 borderborder-gray-300 rounded-lg outline-hidden focus:ring-2 focus:ring-gray-900 text-xs">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-semibold mb-1 text-gray-700 uppercase text-[10px]">Phone Number *</label>
                            <input type="tel" name="customer_phone" required placeholder="e.g. 98160XXXXX" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg outline-hidden focus:ring-2 focus:ring-gray-900 text-xs">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-gray-700 uppercase text-[10px]">Travel Date *</label>
                            <input type="date" name="travel_date" required min="{{ date('Y-m-d') }}" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg outline-hidden focus:ring-2 focus:ring-gray-900 text-xs">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-semibold mb-1 text-gray-700 uppercase text-[10px]">Pickup Location *</label>
                            <input type="text" name="pickup_location" required placeholder="e.g. Gaggal Airport / Hotel" class="w-fullp-2.5 bg-gray-50 border border-gray-300 rounded-lg outline-hidden focus:ring-2 focus:ring-gray-900 text-xs">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-gray-700 uppercase text-[10px]">Drop Location</label>
                            <input type="text" name="drop_location" placeholder="e.g. McLeodganj / Dalhousie" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg outline-hidden focus:ring-2 focus:ring-gray-900 text-xs">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-3 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-xl text-xs transition shadow-xs flex items-center justify-center space-x-2">
                            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i>
                            <span>Confirm Booking Request</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </main>

    <!-- Global Footer -->
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
                    title: '<span class="text-lg font-bold text-gray-900">Cab Booking Received!</span>',
                    html: '<div class="text-xs text-gray-600 mt-2 space-y-1"><p>Booking Ref: <strong class="text-gray-900 font-mono text-sm">{{ session("booking_code") }}</strong></p><p>Customer: <strong>{{ session("customer_name") }}</strong></p><p>Our fleet coordinator will call to assign driver & vehicle.</p></div>',
                    confirmButtonText: 'Understood, Thanks!',
                    confirmButtonColor: '#111827',
                    customClass: {
                        popup: 'rounded-2xl p-6 shadow-2xl border border-gray-100',
                        confirmButton: 'px-6 py-2 rounded-lg font-semibold text-xs'
                    }
                });
            @endif
        });
    </script>
</body>
</html>