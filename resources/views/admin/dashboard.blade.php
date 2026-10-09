<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Admin Dashboard - {{ \App\Models\Setting::get('site_title', 'Dharamshala Travels') }}
    </title>

    <!-- Dynamic Favicon -->
    @if(\App\Models\Setting::get('site_favicon'))
        <link rel="icon"
              type="image/x-icon"
              href="{{ \App\Models\Setting::get('site_favicon') }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    <!-- Tailwind -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">

    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <!-- Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Alpine -->
    <script defer
            src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- SweetAlert -->
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

<body
    class="bg-slate-100 text-slate-800 antialiased flex h-screen overflow-hidden"
>

    <!-- =========================================================
         COMMON ADMIN SIDEBAR
         ========================================================= -->
    @include('admin.partials.sidebar')


    <!-- =========================================================
         MAIN CONTENT AREA
         ========================================================= -->
    <div class="flex-1 flex flex-col overflow-y-auto">

        <!-- Top Header Bar -->
        <header
            class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between shrink-0 sticky top-0 z-30"
        >

            <div class="flex items-center gap-2 text-xs">
                <span class="text-slate-400">Admin</span>
                <span class="text-slate-300">/</span>

                <span class="font-bold text-slate-800">
                    Dashboard
                </span>
            </div>


            <div class="flex items-center gap-3">

                <!-- Website -->
                <a
                    href="{{ route('home') }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors"
                >
                    <i data-lucide="globe" class="w-3.5 h-3.5 text-slate-500"></i>
                    <span>Website</span>
                </a>

            </div>

        </header>


        <!-- =====================================================
             MAIN BODY
             ===================================================== -->
        <main class="p-6 space-y-6">

            <!-- Dashboard Overview -->
            <section class="space-y-1">
                <h1 class="text-xl font-extrabold text-slate-900">Dashboard Overview</h1>
                <p class="text-sm text-slate-500">
                    Monitor bookings, revenue, fleet, and tour package activity from one place.
                </p>
            </section>

            <!-- Metric Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-6 gap-4">

                <!-- Total Bookings -->
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">
                            Total Bookings
                        </span>
                        <span class="text-2xl font-extrabold text-slate-900">
                            {{ $stats['total_bookings'] }}
                        </span>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700">
                        <i data-lucide="calendar" class="w-5 h-5"></i>
                    </div>
                </div>

                <!-- Pending -->
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">
                            Pending Approval
                        </span>
                        <span class="text-2xl font-extrabold text-slate-800">
                            {{ $stats['pending_bookings'] }}
                        </span>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center text-amber-700">
                        <i data-lucide="hourglass" class="w-5 h-5"></i>
                    </div>
                </div>

                <!-- Confirmed -->
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">
                            Confirmed Rides
                        </span>
                        <span class="text-2xl font-extrabold text-emerald-700">
                            {{ $stats['confirmed_bookings'] }}
                        </span>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-700">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                    </div>
                </div>

                <!-- Revenue -->
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">
                            Estimated Value
                        </span>
                        <span class="text-2xl font-extrabold text-slate-900">
                            ₹{{ number_format($stats['total_revenue'], 0) }}
                        </span>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700">
                        <i data-lucide="wallet" class="w-5 h-5"></i>
                    </div>
                </div>

                <!-- Active Fleet -->
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">
                            Active Fleet
                        </span>
                        <span class="text-2xl font-extrabold text-slate-900">
                            {{ $stats['active_fleet'] }}
                        </span>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-700">
                        <i data-lucide="car-front" class="w-5 h-5"></i>
                    </div>
                </div>

                <!-- Tour Packages -->
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">
                            Tour Packages
                        </span>
                        <span class="text-2xl font-extrabold text-slate-900">
                            {{ $stats['total_packages'] }}
                        </span>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-700">
                        <i data-lucide="map" class="w-5 h-5"></i>
                    </div>
                </div>

            </div>

            <!-- Quick Navigation -->
            <section class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Quick Navigation</h2>
                        <p class="text-xs text-slate-500 mt-1">
                            Open a dedicated management section.
                        </p>
                    </div>
                    <i data-lucide="layout-dashboard" class="w-5 h-5 text-slate-400"></i>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

                    <a href="{{ route('admin.bookings.index') }}"
                       class="flex items-center gap-3 p-4 rounded-lg border border-slate-200 hover:border-slate-400 hover:bg-slate-50 transition">
                        <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                            <i data-lucide="calendar-check" class="w-4 h-4 text-slate-700"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-900">Bookings</div>
                            <div class="text-[11px] text-slate-500">Manage reservations</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.vehicles.index') }}"
                       class="flex items-center gap-3 p-4 rounded-lg border border-slate-200 hover:border-slate-400 hover:bg-slate-50 transition">
                        <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center">
                            <i data-lucide="car-front" class="w-4 h-4 text-blue-700"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-900">Vehicles</div>
                            <div class="text-[11px] text-slate-500">Manage fleet</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.tours.index') }}"
                       class="flex items-center gap-3 p-4 rounded-lg border border-slate-200 hover:border-slate-400 hover:bg-slate-50 transition">
                        <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <i data-lucide="map" class="w-4 h-4 text-emerald-700"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-900">Tours</div>
                            <div class="text-[11px] text-slate-500">Manage packages</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.banner') }}"
                       class="flex items-center gap-3 p-4 rounded-lg border border-slate-200 hover:border-slate-400 hover:bg-slate-50 transition">
                        <div class="w-9 h-9 rounded-lg bg-amber-50 flex items-center justify-center">
                            <i data-lucide="image" class="w-4 h-4 text-amber-700"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-900">Hero Banner</div>
                            <div class="text-[11px] text-slate-500">Manage homepage hero</div>
                        </div>
                    </a>

                </div>
            </section>

        </main>

    </div>


    <!-- =========================================================
         SCRIPTS
         ========================================================= -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // SweetAlert success message
            @if(session('success'))

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    timer: 2500,
                    showConfirmButton: false,
                    background: '#ffffff',
                    customClass: {
                        popup: 'rounded-2xl border border-slate-200 text-slate-900'
                    }
                });

            @endif

        });


    </script>

</body>
</html>