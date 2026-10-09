<!DOCTYPE html>

<html lang="en" class="scroll-smooth">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <title>{{ $package->title }} | Dharamshala Travels</title>

    <meta name="title" content="{{ $package->title }} | Dharamshala Travels">

    <meta name="description" content="{{ $package->short_desc }}">

    <link rel="canonical" href="{{ url()->current() }}">



    @if(\App\Models\Setting::get('site_favicon'))

    <link rel="icon" type="image/x-icon" href="{{ \App\Models\Setting::get('site_favicon') }}">

    @endif



    <meta property="og:type" content="website">

    <meta property="og:title" content="{{ $package->title }} - Dharamshala Travels">

    <meta property="og:description" content="{{ $package->short_desc }}">

    <meta property="og:image" content="{{ $package->thumbnail }}">



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

            <a href="{{ route('tours.index') }}" class="hover:text-gray-900">Tours</a>

            <span>/</span>

            <span class="text-gray-900 font-semibold">{{ $package->title }}</span>

        </nav>



        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left 2 Cols: Tour Package Details -->

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm">

                    @php
                    $galleryImages = collect([
                    $package->thumbnail,
                    $package->image_2,
                    $package->image_3,
                    $package->image_4,
                    $package->image_5,
                    ])->filter()->values();
                    @endphp

                    <div x-data="{ activeImage: @js($galleryImages->first()) }">
                        <div class="relative h-72 sm:h-96 w-full bg-gray-100 overflow-hidden">
                            <template x-if="activeImage">
                                <img :src="activeImage" alt="{{ $package->title }}" class="w-full h-full object-cover transition duration-300">
                            </template>
                            <span class="absolute top-4 left-4 bg-gray-900 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md z-10">
                                {{ $package->duration }}
                            </span>
                            @if($galleryImages->count() > 1)
                            <span class="absolute top-4 right-4 bg-black bg-opacity-60 text-white text-[11px] font-semibold px-3 py-1.5 rounded-full z-10">
                                <span x-text="[
                                        @foreach($galleryImages as $image)
                                            @js($image){{ $loop->last ? '' : ',' }}
                                        @endforeach
                                    ].indexOf(activeImage) + 1"></span>
                                / {{ $galleryImages->count() }}
                            </span>
                            @endif
                        </div>

                        @if($galleryImages->count() > 1)
                        <div class="p-3 bg-white border-t border-gray-100">
                            <div class="grid grid-cols-4 sm:grid-cols-5 gap-2">
                                @foreach($galleryImages as $index => $image)
                                <button type="button" @click="activeImage = @js($image)" class="relative h-16 sm:h-20 rounded-lg overflow-hidden border-2 focus:outline-none transition" :class="activeImage === @js($image) ? 'border-emerald-600 ring-2 ring-emerald-100' : 'border-transparent hover:border-gray-300'">
                                    <img src="{{ $image }}" alt="{{ $package->title }} image {{ $index + 1 }}" class="w-full h-full object-cover">
                                    @if($index === 0)
                                    <span class="absolute bottom-1 left-1 bg-black bg-opacity-60 text-white text-[9px] px-1.5 py-0.5 rounded">Main</span>
                                    @endif
                                </button>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>



                    <div class="p-6">

                        <div class="flex flex-wrap items-center justify-between gap-4 mb-4">

                            <div>

                                <span class="text-xs font-bold uppercase tracking-wider text-green-800 bg-green-100 px-2.5 py-1 rounded-md">

                                    Curated Tour Package

                                </span>

                                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-2">{{ $package->title }}</h1>

                            </div>

                            <div class="text-right">

                                <span class="text-xs text-gray-500 block uppercase font-medium">Starting Tariff</span>

                                <span class="text-2xl font-extrabold text-gray-900">₹{{ number_format($package->starting_price, 0) }}</span>

                                <span class="text-xs text-gray-500 block">per vehicle tour</span>

                            </div>

                        </div>



                        <div class="py-4 border-t border-b border-gray-100 my-6">

                            <h3 class="text-sm font-bold text-gray-900 mb-2">Tour Overview</h3>

                            <p class="text-xs text-gray-600 leading-relaxed">{{ $package->short_desc }}</p>

                        </div>



                        <!-- Safe Itinerary Details Handling (Array / JSON / String) -->

                        <?php if (!empty($package->itinerary)): ?>

                            <div class="mb-6">

                                <h3 class="text-sm font-bold text-gray-900 mb-3">Planned Itinerary & Highlights</h3>

                                <div class="text-xs text-gray-700 leading-relaxed bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-2">

                                    <?php

                                    $itineraryData = is_string($package->itinerary)

                                        ? (json_decode($package->itinerary, true) ?? $package->itinerary)

                                        : $package->itinerary;

                                    ?>



                                    <?php if (is_array($itineraryData)): ?>

                                        <?php foreach ($itineraryData as $key => $item): ?>

                                            <div class="flex items-start space-x-2 py-1 border-b border-gray-200 last:border-b-0">

                                                <span class="font-bold text-gray-900 shrink-0">

                                                    <?php echo is_numeric($key) ? 'Day ' . ($key + 1) . ':' : ucfirst($key) . ':'; ?>

                                                </span>

                                                <span>

                                                    <?php echo is_array($item) ? htmlspecialchars(implode(', ', $item)) : htmlspecialchars($item); ?>

                                                </span>

                                            </div>

                                        <?php endforeach; ?>

                                    <?php else: ?>

                                        <div class="whitespace-pre-line"><?php echo htmlspecialchars($itineraryData); ?></div>

                                    <?php endif; ?>

                                </div>

                            </div>

                        <?php endif; ?>



                        <!-- Inclusions -->

                        <h3 class="text-sm font-bold text-gray-900 mb-3">What's Included</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs text-gray-700">

                            <?php

                            $inclusionsList = is_array($package->inclusions)

                                ? $package->inclusions

                                : (json_decode($package->inclusions, true) ?? []);

                            ?>

                            <?php if (is_array($inclusionsList) && count($inclusionsList) > 0): ?>

                                <?php foreach ($inclusionsList as $inc): ?>

                                    <div class="flex items-center space-x-2">

                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>

                                        <span><?php echo is_array($inc) ? htmlspecialchars(json_encode($inc)) : htmlspecialchars($inc); ?></span>

                                    </div>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <div class="flex items-center space-x-2"><i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i><span>Dedicated Hill Chauffeur</span></div>

                                <div class="flex items-center space-x-2"><i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i><span>Fuel, Tolls & State Tax Included</span></div>

                                <div class="flex items-center space-x-2"><i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i><span>Customized Sightseeing Stops</span></div>

                                <div class="flex items-center space-x-2"><i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i><span>Clean & Sanitized Vehicle</span></div>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </div>



            <!-- Right 1 Col: Direct Booking Box -->

            <div class="space-y-6">

                <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg sticky top-24">

                    <h3 class="text-base font-bold text-gray-900 mb-1">Book This Tour</h3>

                    <p class="text-xs text-gray-500 mb-5">Pay zero advance. Free cancellation up to 24 hrs.</p>



                    <form action="{{ route('bookings.store') }}" method="POST" class="space-y-3.5 text-xs">

                        @csrf

                        <input type="hidden" name="booking_type" value="tour_package">

                        <input type="hidden" name="package_id" value="{{ $package->id }}">



                        <div>

                            <label class="block font-semibold mb-1 text-gray-700">Preferred Cab Type</label>

                            <select name="vehicle_id" class="w-full p-2.5 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-gray-900 bg-white">

                                <option value="">Select Vehicle (Optional)</option>

                                <?php if (isset($vehicles) && count($vehicles) > 0): ?>

                                    <?php foreach ($vehicles as $veh): ?>

                                        <option value="{{ $veh->id }}">{{ $veh->name }} ({{ $veh->category }} - {{$veh->seating_capacity }} Seater)</option>

                                    <?php endforeach; ?>

                                <?php endif; ?>

                            </select>

                        </div>



                        <div>

                            <label class="block font-semibold mb-1 text-gray-700">Your Full Name</label>

                            <input type="text" name="customer_name" required placeholder="e.g. Amit Verma" class="w-full p-2.5 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-gray-900">

                        </div>



                        <div>

                            <label class="block font-semibold mb-1 text-gray-700">Contact Number</label>

                            <input type="tel" name="customer_phone" required placeholder="e.g. 98160XXXXX" class="w-full p-2.5 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-gray-900">

                        </div>



                        <div>

                            <label class="block font-semibold mb-1 text-gray-700">Travel Start Date</label>

                            <input type="date" name="travel_date" required value="{{ date('Y-m-d') }}" class="w-full p-2.5 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-gray-900">

                        </div>



                        <div>

                            <label class="block font-semibold mb-1 text-gray-700">Pickup Location</label>

                            <input type="text" name="pickup_location" required placeholder="e.g. Hotel in Dharamshala / Gaggal Airport" class="w-full p-2.5 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-gray-900">

                        </div>



                        <button type="submit" class="w-full py-3 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-lg text-xs transition mt-2 shadow-sm">

                            Confirm Tour Reservation

                        </button>

                    </form>



                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">

                        <span>Need Assistance?</span>

                        <a href="tel:+919876543210" class="font-bold text-gray-900">+91 98765 43210</a>

                    </div>

                </div>

            </div>

        </div>



        <!-- Tour Feedback & Review Form (With Photo Upload) -->

        <div class="mt-14 max-w-xl mx-auto bg-white rounded-2xl p-6 sm:p-8 border border-gray-200 shadow-sm" x-data="{ photoName: null, photoPreview: null }">

            <h3 class="text-base font-bold text-gray-900 mb-1">Leave a Review</h3>

            <p class="text-xs text-gray-500 mb-5">Share your feedback about this tour package and experience.</p>



            <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">

                @csrf

                <input type="hidden" name="package_id" value="{{ $package->id }}">



                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div>

                        <label class="block font-semibold mb-1 text-gray-700 uppercase text-[10px]">Your Name</label>

                        <input type="text" name="customer_name" required placeholder="e.g. Rahul Sharma" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-gray-900 text-xs">

                    </div>

                    <div>

                        <label class="block font-semibold mb-1 text-gray-700 uppercase text-[10px]">Rating</label>

                        <select name="rating" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-gray-900 text-xs">

                            <option value="5">★★★★★ (5/5 Excellent)</option>

                            <option value="4">★★★★☆ (4/5 Very Good)</option>

                            <option value="3">★★★☆☆ (3/5 Average)</option>

                            <option value="2">★★☆☆☆ (2/5 Below Average)</option>

                            <option value="1">★☆☆☆☆ (1/5 Poor)</option>

                        </select>

                    </div>

                </div>



                <div>

                    <label class="block font-semibold mb-1 text-gray-700 uppercase text-[10px]">Your Feedback</label>

                    <textarea name="comment" rows="3" required placeholder="Describe your travel experience..." class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-gray-900 text-xs"></textarea>

                </div>



                <!-- Add Trip Photo / Avatar Upload -->

                <div>

                    <label class="block font-semibold mb-1 text-gray-700 uppercase text-[10px]">

                        Add Trip Photo / Avatar <span class="text-gray-400 font-normal lowercase">(optional)</span>

                    </label>



                    <div class="flex items-center space-x-3">

                        <label class="cursor-pointer inline-flex items-center space-x-2 px-3.5 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-xl text-xs font-semibold border border-gray-300 transition">

                            <i data-lucide="image" class="w-4 h-4 text-emerald-600"></i>

                            <span x-text="photoName ? 'Change Photo' : 'Upload Image'"></span>

                            <input type="file"

                                name="image"

                                accept="image/*"

                                class="hidden"

                                @change="photoName = $event.target.files[0] ?$event.target.files[0].name : null; if($event.target.files[0]){ const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL($event.target.files[0]); } else { photoPreview = null; }">

                        </label>



                        <!-- Live Preview Thumbnail -->

                        <template x-if="photoPreview">

                            <div class="relative w-10 h-10 rounded-lg overflow-hidden border border-emerald-500 shadow-xs shrink-0">

                                <img :src="photoPreview" class="w-full h-full object-cover">

                            </div>

                        </template>

                        <span x-show="photoName" x-text="photoName" class="text-[11px] text-gray-500 truncate max-w-xs"></span>

                    </div>

                </div>



                <button type="submit" class="w-full py-3 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-lg transition shadow-sm text-xs">

                    Submit Review

                </button>

            </form>

        </div>



        <!-- Related Tours -->

        <?php if (isset($relatedPackages) && count($relatedPackages) > 0): ?>

            <div class="mt-14">

                <h3 class="text-lg font-bold text-gray-900 mb-4">Other Recommended Tours</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <?php foreach ($relatedPackages as $relPkg): ?>

                        <a href="{{ route('tours.show', ['slug' => $relPkg->slug]) }}" class="bg-white rounded-xl overflow-hidden border border-gray-200 p-4 block hover:shadow-md transition">

                            <img src="{{ $relPkg->thumbnail }}" alt="{{ $relPkg->title }}" class="w-full h-36 object-cover rounded-lg mb-3">

                            <span class="text-xs text-gray-500 block mb-1">{{ $relPkg->duration }}</span>

                            <h4 class="font-bold text-gray-900 text-sm mb-2">{{ $relPkg->title }}</h4>

                            <span class="text-xs font-bold text-green-700">From ₹{{ number_format($relPkg->starting_price, 0) }}</span>

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

                                html: \ `

                        <div class="mt-2 text-center text-xs text-gray-600 space-y-3">

                            <p class="text-sm font-medium text-gray-700">Aapki tour package reservation request safaltapoorvak receive ho gayi hai.</p>



                            <div class="bg-gray-50 border border-dashed border-gray-300 rounded-xl p-3 inline-block">

                                <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider block">Booking Reference ID</span>

                                <span class="text-base font-black text-gray-900 tracking-widest">{{ session("booking_code") }}</span>

                            </div>



                            <div class="bg-green-50 text-green-900 rounded-xl p-3 text-xs leading-relaxed text-left flex items-start space-x-2 border border-green-100">

                                <span class="text-green-600 font-bold text-sm">✓</span>

                                <div>

                                    <span class="font-bold">Zero Advance Required</span>

                                    <p class="text-[11px] text-green-800 mt-0.5">Start Date: <strong>{{ session('travel_date') }}</strong>. Hamara tour coordinator aapse sampark karega.</p>

                                </div>

                            </div>

                        </div>

                    \`,

                    confirmButtonText: 'Great, Understood!',

                    confirmButtonColor: '#111827',

                    customClass: {

                        popup: 'rounded-3xl p-6 shadow-2xl border border-gray-100',

                        confirmButton: 'px-6 py-2.5 rounded-xl font-semibold text-xs'

                    }

                });

            @endif



            @if(session('review_success') || session('success'))

                Swal.fire({

                    icon: 'success',

                    iconColor: '#10b981',

                    title: '<span class="text-lg font-bold text-gray-900">Review Submitted!</span>',

                    text: "{{ session('review_success') ?? session('success') }}",

                    confirmButtonText: 'Awesome',

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