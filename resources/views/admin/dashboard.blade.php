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

        /* One consistent sidebar state: hidden on mobile until the menu is tapped. */
        #adminSidebar {
            background-color: #ffffff !important;
            transition: transform 250ms ease, width 250ms ease, margin 250ms ease;
        }

        body.admin-sidebar-collapsed #adminSidebar {
            transform: translateX(-100%);
            width: 0 !important;
            min-width: 0 !important;
            margin-left: -16rem;
            border-right-width: 0 !important;
        }

        body.admin-sidebar-collapsed #adminSidebarOverlay {
            display: none !important;
        }

        body.admin-sidebar-mobile-open #adminSidebar {
            transform: translateX(0) !important;
            width: min(18rem, 85vw) !important;
            max-width: 85vw !important;
            margin-left: 0 !important;
        }

        @media (max-width: 767px) {
            #adminSidebar {
                position: fixed !important;
                top: 0 !important;
                bottom: 0 !important;
                left: 0 !important;
                right: auto !important;
                height: 100vh !important;
                height: 100dvh !important;
                width: min(18rem, 85vw) !important;
                max-width: 85vw !important;
                margin: 0 !important;
                transform: translateX(-105%) !important;
                z-index: 50 !important;
                overflow: hidden;
                background-color: #ffffff !important;
            }

            body.admin-sidebar-mobile-open #adminSidebar {
                transform: translateX(0) !important;
            }

            body.admin-sidebar-collapsed #adminSidebar {
                transform: translateX(-105%) !important;
                width: min(18rem, 85vw) !important;
                margin: 0 !important;
                border-right-width: 1px !important;
            }

            #adminSidebarOverlay {
                position: fixed;
                inset: 0;
                z-index: 40;
                background: rgba(15, 23, 42, .48);
            }

            body.admin-sidebar-mobile-open {
                overflow: hidden;
            }

            #adminTopHeader {
                position: sticky;
                top: 0;
                width: 100%;
                padding: .65rem .75rem;
                gap: .5rem;
            }

            #adminTopHeader > div:first-child {
                flex: 1 1 auto;
                gap: .5rem;
            }

            #adminTopHeader > div:last-child {
                flex: 0 0 auto;
            }

            #adminTopHeader button#adminSidebarToggle {
                width: 2.5rem;
                height: 2.5rem;
            }

            main {
                width: 100% !important;
                padding: .875rem !important;
                overflow-x: clip;
            }

            main h1 {
                font-size: 1.25rem;
                line-height: 1.6rem;
            }

            main p {
                overflow-wrap: anywhere;
            }

            main .grid {
                grid-template-columns: minmax(0, 1fr) !important;
                width: 100%;
            }

            main .grid > * {
                min-width: 0;
                width: 100%;
            }

            main section.bg-white {
                padding: .875rem !important;
            }

            main a {
                overflow-wrap: anywhere;
            }
        }

        /* Mobile-first admin dashboard layout */
        html, body {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }

        #adminTopHeader,
        main,
        main > section,
        main > div {
            min-width: 0;
            max-width: 100%;
        }

        @media (max-width: 767px) {
            body {
                display: block !important;
                min-height: 100vh;
                min-height: 100dvh;
            }

            /* Sidebar is an overlay on phones, never a flex column beside content. */
            #adminSidebar {
                position: fixed !important;
                top: 0 !important;
                bottom: 0 !important;
                left: 0 !important;
                right: auto !important;
                height: 100vh !important;
                height: 100dvh !important;
                width: min(18rem, 85vw) !important;
                max-width: 85vw !important;
                margin: 0 !important;
                transform: translateX(-105%);
                z-index: 50 !important;
            }

            body.admin-sidebar-mobile-open #adminSidebar {
                transform: translateX(0) !important;
            }

            body.admin-sidebar-collapsed #adminSidebar {
                transform: translateX(-105%) !important;
                width: min(18rem, 85vw) !important;
                margin: 0 !important;
            }

            #adminSidebarOverlay {
                position: fixed;
                inset: 0;
                z-index: 40;
                background: rgba(15, 23, 42, .48);
            }

            #adminTopHeader {
                position: sticky;
                top: 0;
                width: 100%;
                padding: .65rem .75rem;
                gap: .5rem;
            }

            #adminTopHeader > div:first-child {
                flex: 1 1 auto;
                gap: .5rem;
            }

            #adminTopHeader > div:last-child {
                flex: 0 0 auto;
            }

            #adminTopHeader button#adminSidebarToggle {
                width: 2.5rem;
                height: 2.5rem;
            }

            main {
                width: 100% !important;
                padding: .875rem !important;
                overflow-x: clip;
            }

            main h1 {
                font-size: 1.25rem;
                line-height: 1.6rem;
            }

            main p {
                overflow-wrap: anywhere;
            }

            /* Prevent metric/navigation cards from forcing horizontal scrolling. */
            main .grid {
                grid-template-columns: minmax(0, 1fr) !important;
                width: 100%;
            }

            main .grid > * {
                min-width: 0;
                width: 100%;
            }

            main section.bg-white {
                padding: .875rem !important;
            }

            main a {
                overflow-wrap: anywhere;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            #adminSidebar {
                transition: none;
            }
        }
    </style>
</head>

<body
    class="bg-slate-100 text-slate-800 antialiased flex min-h-screen w-full overflow-x-hidden"
>

    <!-- =========================================================
         COMMON ADMIN SIDEBAR
         ========================================================= -->
    @include('admin.partials.sidebar')


    <!-- =========================================================
         MAIN CONTENT AREA
         ========================================================= -->
    <div class="flex-1 min-w-0 flex flex-col overflow-y-auto">

        <!-- Top Header Bar -->
        <header
            id="adminTopHeader"
            class="min-h-16 h-auto bg-white border-b border-slate-200 px-3 sm:px-6 py-3 flex flex-wrap items-center justify-between gap-3 shrink-0 sticky top-0 z-30"
        >

            <div class="flex min-w-0 items-center gap-2 text-xs">
                <button
                    type="button"
                    id="adminSidebarToggle"
                    class="inline-flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-700 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    aria-label="Toggle admin sidebar"
                    aria-controls="adminSidebar"
                    aria-expanded="false"
                >
                    <i data-lucide="menu" class="h-5 w-5"></i>
                </button>
                <span class="text-slate-400">Admin</span>
                <span class="text-slate-300">/</span>

                <span class="font-bold text-slate-800">
                    Dashboard
                </span>
            </div>


            <div class="flex flex-shrink-0 items-center gap-2 sm:gap-3">

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
        <main class="min-w-0 p-3 sm:p-6 space-y-4 sm:space-y-6">

            <!-- Dashboard Overview -->
            <section class="space-y-1">
                <h1 class="text-lg sm:text-xl font-extrabold text-slate-900">Dashboard Overview</h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Monitor bookings, revenue, fleet, and tour package activity from one place.
                </p>
            </section>

            <!-- Metric Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-5 gap-3 sm:gap-4">

                <!-- Total Bookings -->
                <div class="bg-white p-4 sm:p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between gap-3 min-w-0">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">
                            Total Bookings
                        </span>
                        <span class="text-xl sm:text-2xl font-extrabold text-slate-900">
                            {{ $stats['total_bookings'] }}
                        </span>
                    </div>
                    <div class="w-10 h-10 sm:w-11 sm:h-11 flex-shrink-0 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700">
                        <i data-lucide="calendar" class="w-5 h-5"></i>
                    </div>
                </div>

                <!-- Pending -->
                <div class="bg-white p-4 sm:p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between gap-3 min-w-0">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">
                            Pending Approval
                        </span>
                        <span class="text-xl sm:text-2xl font-extrabold text-slate-800">
                            {{ $stats['pending_bookings'] }}
                        </span>
                    </div>
                    <div class="w-10 h-10 sm:w-11 sm:h-11 flex-shrink-0 rounded-xl bg-amber-50 flex items-center justify-center text-amber-700">
                        <i data-lucide="hourglass" class="w-5 h-5"></i>
                    </div>
                </div>

                <!-- Confirmed -->
                <div class="bg-white p-4 sm:p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between gap-3 min-w-0">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">
                            Confirmed Rides
                        </span>
                        <span class="text-xl sm:text-2xl font-extrabold text-emerald-700">
                            {{ $stats['confirmed_bookings'] }}
                        </span>
                    </div>
                    <div class="w-10 h-10 sm:w-11 sm:h-11 flex-shrink-0 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-700">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                    </div>
                </div>

                <!-- Active Fleet -->
                <div class="bg-white p-4 sm:p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between gap-3 min-w-0">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">
                            Active Fleet
                        </span>
                        <span class="text-xl sm:text-2xl font-extrabold text-slate-900">
                            {{ $stats['active_fleet'] }}
                        </span>
                    </div>
                    <div class="w-10 h-10 sm:w-11 sm:h-11 flex-shrink-0 rounded-xl bg-blue-50 flex items-center justify-center text-blue-700">
                        <i data-lucide="car-front" class="w-5 h-5"></i>
                    </div>
                </div>

                <!-- Tour Packages -->
                <div class="bg-white p-4 sm:p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between gap-3 min-w-0">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">
                            Tour Packages
                        </span>
                        <span class="text-xl sm:text-2xl font-extrabold text-slate-900">
                            {{ $stats['total_packages'] }}
                        </span>
                    </div>
                    <div class="w-10 h-10 sm:w-11 sm:h-11 flex-shrink-0 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-700">
                        <i data-lucide="map" class="w-5 h-5"></i>
                    </div>
                </div>

            </div>

            <!-- Quick Navigation -->
            <section class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 sm:p-5">
                <div class="flex items-center justify-between gap-3 mb-4">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Quick Navigation</h2>
                        <p class="text-xs text-slate-500 mt-1">
                            Open a dedicated management section.
                        </p>
                    </div>
                    <i data-lucide="layout-dashboard" class="w-5 h-5 text-slate-400"></i>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-4 gap-3">

                    <a href="{{ route('admin.bookings.index') }}"
                       class="flex min-w-0 items-center gap-3 p-3 sm:p-4 rounded-lg border border-slate-200 hover:border-slate-400 hover:bg-slate-50 transition">
                        <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                            <i data-lucide="calendar-check" class="w-4 h-4 text-slate-700"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-900">Bookings</div>
                            <div class="text-[11px] text-slate-500">Manage reservations</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.vehicles.index') }}"
                       class="flex min-w-0 items-center gap-3 p-3 sm:p-4 rounded-lg border border-slate-200 hover:border-slate-400 hover:bg-slate-50 transition">
                        <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center">
                            <i data-lucide="car-front" class="w-4 h-4 text-blue-700"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-900">Vehicles</div>
                            <div class="text-[11px] text-slate-500">Manage fleet</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.tours.index') }}"
                       class="flex min-w-0 items-center gap-3 p-3 sm:p-4 rounded-lg border border-slate-200 hover:border-slate-400 hover:bg-slate-50 transition">
                        <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <i data-lucide="map" class="w-4 h-4 text-emerald-700"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-900">Tours</div>
                            <div class="text-[11px] text-slate-500">Manage packages</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.banner') }}"
                       class="flex min-w-0 items-center gap-3 p-3 sm:p-4 rounded-lg border border-slate-200 hover:border-slate-400 hover:bg-slate-50 transition">
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

            // Responsive sidebar toggle: works on desktop and mobile.
            const sidebar = document.getElementById('adminSidebar');
            const sidebarToggle = document.getElementById('adminSidebarToggle');
            const sidebarOverlay = document.getElementById('adminSidebarOverlay');

            if (sidebar && sidebarToggle) {
                const mobileQuery = window.matchMedia('(max-width: 767px)');

                const setSidebarState = (open) => {
                    if (mobileQuery.matches) {
                        document.body.classList.toggle('admin-sidebar-mobile-open', open);
                        document.body.classList.remove('admin-sidebar-collapsed');
                        if (sidebarOverlay) {
                            sidebarOverlay.classList.toggle('hidden', !open);
                        }
                    } else {
                        document.body.classList.toggle('admin-sidebar-collapsed', !open);
                        document.body.classList.remove('admin-sidebar-mobile-open');
                        if (sidebarOverlay) {
                            sidebarOverlay.classList.add('hidden');
                        }
                    }

                    sidebarToggle.setAttribute('aria-expanded', String(open));
                    sidebarToggle.setAttribute(
                        'aria-label',
                        open ? 'Close admin sidebar' : 'Open admin sidebar'
                    );

                    const icon = sidebarToggle.querySelector('[data-lucide]');
                    if (icon) {
                        icon.setAttribute('data-lucide', open ? 'x' : 'menu');
                        if (typeof lucide !== 'undefined') lucide.createIcons();
                    }
                };

                sidebarToggle.addEventListener('click', () => {
                    const isOpen = mobileQuery.matches
                        ? document.body.classList.contains('admin-sidebar-mobile-open')
                        : !document.body.classList.contains('admin-sidebar-collapsed');
                    setSidebarState(!isOpen);
                });

                // Phones: start with the navigation closed on every page load.
                // Desktop: keep the sidebar expanded by default.
                if (mobileQuery.matches) {
                    setSidebarState(false);
                } else {
                    setSidebarState(true);
                }

                if (sidebarOverlay) {
                    sidebarOverlay.addEventListener('click', () => setSidebarState(false));
                }

                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape') setSidebarState(false);
                });

                sidebar.querySelectorAll('a').forEach((link) => {
                    link.addEventListener('click', () => {
                        if (mobileQuery.matches) setSidebarState(false);
                    });
                });

                const handleBreakpointChange = () => {
                    document.body.classList.remove(
                        'admin-sidebar-mobile-open',
                        'admin-sidebar-collapsed'
                    );
                    if (sidebarOverlay) sidebarOverlay.classList.add('hidden');
                    sidebarToggle.setAttribute('aria-expanded', 'true');
                    sidebarToggle.setAttribute('aria-label', 'Close admin sidebar');
                    const icon = sidebarToggle.querySelector('[data-lucide]');
                    if (icon) {
                        icon.setAttribute('data-lucide', 'menu');
                        if (typeof lucide !== 'undefined') lucide.createIcons();
                    }
                };

                if (typeof mobileQuery.addEventListener === 'function') {
                    mobileQuery.addEventListener('change', handleBreakpointChange);
                } else {
                    mobileQuery.addListener(handleBreakpointChange);
                }
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