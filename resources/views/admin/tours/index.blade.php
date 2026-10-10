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
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .tour-table th { white-space: nowrap; }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased flex h-screen overflow-hidden">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col overflow-y-auto min-w-0">

        <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between shrink-0 sticky top-0 z-30">
            <div class="flex items-center gap-2 text-xs">
                <span class="text-slate-400">Admin</span>
                <span class="text-slate-300">/</span>
                <span class="font-bold text-slate-800">Tours</span>
            </div>

            <div class="flex items-center gap-3">
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

        <main class="p-6 space-y-6">

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

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

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
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Priced Tours</span>
                        <span class="text-2xl font-extrabold text-emerald-700">
                            {{ $packages->count() }}
                        </span>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-700">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Priced Packages</span>
                        <span class="text-2xl font-extrabold text-slate-900">
                            {{ $packages->sum(fn($package) => (float) $package->starting_price > 0 ? 1 : 0) }}
                        </span>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center text-amber-700">
                        <i data-lucide="star" class="w-5 h-5"></i>
                    </div>
                </div>

            </div>

            <div class="flex items-end justify-between gap-4">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900">All Tour Circuits</h2>
                    <p class="text-sm text-slate-500 mt-1">Showing {{ $packages->count() }} tours</p>
                </div>

                <a href="{{ route('admin.packages.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-emerald-700 text-white text-xs font-semibold hover:bg-emerald-800 transition">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    Add New Tour
                </a>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">

                    <table class="w-full text-left border-collapse text-xs tour-table">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                                <th class="py-4 px-5">Tour</th>
                                <th class="py-4 px-5">Duration</th>
                                <th class="py-4 px-5">Price</th>
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
                                        <div class="font-bold text-slate-900">
                                            ₹{{ number_format((float) ($package->starting_price ?? 0), 2) }}
                                        </div>
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
                                    <td colspan="5" class="text-center py-16">
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
