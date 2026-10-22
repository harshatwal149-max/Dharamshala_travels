<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tours Management - {{ \App\Models\Setting::get('site_title', 'Dharamshala Travels') }}</title>

    @if(\App\Models\Setting::get('site_favicon'))
        <link rel="icon" type="image/x-icon" href="{{ \App\Models\Setting::get('site_favicon') }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">

    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * { box-sizing: border-box; }
        html, body { width: 100%; max-width: 100%; }
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .tour-table th { white-space: nowrap; }
        #adminSidebar { transition: width .25s ease, transform .25s ease; }
        #adminMainContent { min-width: 0; width: 100%; }
        #adminSidebarOverlay { display: none; }
        body.admin-sidebar-collapsed #adminSidebar { width: 0 !important; min-width: 0 !important; border: 0 !important; }
        body.admin-sidebar-collapsed #adminMainContent { width: 100%; }
        @media (max-width: 767px) {
            body { height: 100dvh !important; min-height: 100dvh !important; overflow: hidden !important; }
            #adminSidebar { position: fixed !important; inset: 0 auto 0 0 !important; width: min(18rem, 85vw) !important; max-width: 85vw !important; height: 100dvh !important; z-index: 50 !important; transform: translateX(-105%); }
            body.admin-sidebar-mobile-open #adminSidebar { transform: translateX(0); }
            #adminSidebarOverlay { position: fixed; inset: 0; z-index: 40; background: rgba(15, 23, 42, .5); cursor: pointer; }
            body.admin-sidebar-mobile-open #adminSidebarOverlay { display: block; }
            #adminMainContent { width: 100%; height: 100dvh; }
            #adminTopHeader { min-height: 4rem; height: auto; padding: .65rem .85rem; gap: .6rem; flex-wrap: wrap; }
            #adminTopHeader > div:first-child { flex: 1 1 auto; }
            #adminTopHeader > div:last-child { gap: .5rem; flex-wrap: wrap; justify-content: flex-end; }
            #adminTopHeader a { max-width: 100%; }
            #adminMainContent > main { padding: 1rem; }
            .tour-table { min-width: 650px; }
            .tour-table th, .tour-table td { white-space: nowrap; }
            .tour-table td:first-child { white-space: normal; }
            .tour-table td:first-child > div { min-width: 230px; }
            .tour-table th, .tour-table td { padding: .75rem .85rem !important; }
        }
        @media (max-width: 420px) {
            #adminTopHeader > div:last-child a { padding: .5rem .6rem; font-size: 11px; }
            #adminMainContent > main { padding: .75rem; }
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased flex h-screen overflow-hidden">

    @include('admin.partials.sidebar')
    <div id="adminSidebarOverlay" class="hidden" aria-hidden="true"></div>

    <div id="adminMainContent" class="flex-1 flex flex-col overflow-y-auto overflow-x-hidden min-w-0">

        <header id="adminTopHeader" class="min-h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between gap-3 shrink-0 sticky top-0 z-30">
            <div class="flex items-center gap-2 text-xs min-w-0">
                <button id="adminMobileMenuToggle" type="button"
                        class="md:hidden inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 bg-white text-slate-700 shrink-0"
                        aria-label="Open admin menu" aria-expanded="false">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <span class="text-slate-400">Admin</span>
                <span class="text-slate-300">/</span>
                <span class="font-bold text-slate-800">Tours</span>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('home') }}" target="_blank"
                   class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                    <i data-lucide="globe" class="w-3.5 h-3.5 text-slate-500"></i>
                    <span>Website</span>
                </a>

                <a href="{{ route('admin.packages.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Add New Tour
                </a>
            </div>
        </header>

        <main class="p-6 space-y-6 min-w-0">

            <section class="space-y-1">
                <h1 class="text-xl font-extrabold text-slate-900">Tours Management</h1>
                <p class="text-sm text-slate-500">Manage all tour circuits and packages.</p>
            </section>

            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                    <div class="font-bold mb-2">Please fix the following errors:</div>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Total Tours</span>
                        <span class="text-2xl font-extrabold text-slate-900">{{ $packages->count() }}</span>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-700">
                        <i data-lucide="map" class="w-5 h-5"></i>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Active Tours</span>
                        <span class="text-2xl font-extrabold text-emerald-700">
                            {{ $packages->count() }}
                        </span>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-700">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                    </div>
                </div>

            </div>

            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 min-w-0">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900">All Tour Circuits</h2>
                    <p class="text-sm text-slate-500 mt-1">Showing {{ $packages->count() }} tours</p>
                </div>

                <a href="{{ route('admin.packages.create') }}"
                   class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-emerald-700 text-white text-xs font-semibold hover:bg-emerald-800 transition self-start sm:self-auto shrink-0">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    Add New Tour
                </a>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden min-w-0">
                <div class="overflow-x-auto">

                    <table class="w-full text-left border-collapse text-xs tour-table">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                                <th class="py-4 px-5">Tour</th>
                                <th class="py-4 px-5">Duration</th>
                                <th class="py-4 px-5">Status</th>
                                <th class="py-4 px-5 text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse($packages as $package)
                                <tr class="hover:bg-slate-50 transition-colors">

                                    <td class="py-4 px-5">
                                        <div class="flex items-center gap-3 min-w-[280px]">

                                            <div class="w-16 h-12 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden shrink-0">
                                                @if($package->thumbnail)
                                                    <img src="{{ $package->thumbnail }}" alt="{{ $package->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <i data-lucide="map-pin" class="w-5 h-5 text-slate-400"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="min-w-0">
                                                <div class="font-bold text-slate-900 text-sm truncate">{{ $package->title }}</div>

                                            </div>

                                        </div>
                                    </td>

                                    <td class="py-4 px-5">
                                        <div class="font-semibold text-slate-700">{{ $package->duration ?? '—' }}</div>
                                    </td>

                                    <td class="py-4 px-5">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100 font-bold text-[11px]">
                                            Active
                                        </span>
                                    </td>

                                    <td class="py-4 px-5 text-right">
                                        <div class="flex items-center justify-end gap-2">

                                            <a href="{{ route('admin.packages.edit', $package->id) }}"
                                               class="px-3.5 py-2 rounded-lg border border-slate-200 bg-white text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.packages.destroy', $package->id) }}"
                                                  method="POST" class="delete-tour-form inline">
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
                                    <td colspan="4" class="text-center py-16">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center mb-3">
                                                <i data-lucide="map" class="w-6 h-6 text-slate-400"></i>
                                            </div>
                                            <div class="font-bold text-slate-700">No tours found.</div>
                                            <div class="text-xs text-slate-400 mt-1">Add your first tour circuit.</div>

                                            <a href="{{ route('admin.packages.create') }}"
                                               class="mt-4 px-4 py-2 rounded-lg bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800">
                                                Add New Tour
                                            </a>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuToggle = document.getElementById('adminMobileMenuToggle');
            const sidebarOverlay = document.getElementById('adminSidebarOverlay');

            function closeMobileSidebar() {
                document.body.classList.remove('admin-sidebar-mobile-open');
                if (menuToggle) {
                    menuToggle.setAttribute('aria-expanded', 'false');
                    menuToggle.setAttribute('aria-label', 'Open admin menu');
                }
            }

            function toggleMobileSidebar() {
                const isOpen = document.body.classList.toggle('admin-sidebar-mobile-open');
                if (menuToggle) {
                    menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                    menuToggle.setAttribute('aria-label', isOpen ? 'Close admin menu' : 'Open admin menu');
                }
            }

            if (menuToggle) {
                menuToggle.addEventListener('click', toggleMobileSidebar);
            }
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeMobileSidebar);
            }
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') closeMobileSidebar();
            });
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 768) closeMobileSidebar();
            });

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            document.querySelectorAll('.delete-tour-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    Swal.fire({
                        title: 'Delete Tour?',
                        text: 'This tour will be permanently deleted.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Delete',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,
                        customClass: { popup: 'rounded-2xl' }
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
