<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Bookings - {{ \App\Models\Setting::get('site_title', 'Dharamshala Travels') }}
    </title>

    {{-- Dynamic Favicon --}}
    @if(\App\Models\Setting::get('site_favicon'))
        <link rel="icon"
              type="image/x-icon"
              href="{{ \App\Models\Setting::get('site_favicon') }}">
    @endif

    {{-- Same fonts as Dashboard --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    {{-- Same Tailwind as Dashboard --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">

    {{-- Same Vite setup as Dashboard --}}
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
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased flex h-screen overflow-hidden">

    {{-- COMMON ADMIN SIDEBAR --}}
    @include('admin.partials.sidebar')

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col overflow-y-auto">

        {{-- TOP HEADER --}}
        <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between shrink-0 sticky top-0 z-30">

            <div class="flex items-center gap-2 text-xs">
                <span class="text-slate-400">Admin</span>
                <span class="text-slate-300">/</span>
                <span class="font-bold text-slate-800">
                    Bookings
                </span>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                    <i data-lucide="globe" class="w-3.5 h-3.5 text-slate-500"></i>
                    <span>Website</span>
                </a>
            </div>

        </header>

        {{-- MAIN BODY --}}
        <main class="p-6 space-y-6">

            {{-- PAGE HEADING --}}
            <section class="space-y-1">
                <h1 class="text-xl font-extrabold text-slate-900">
                    Bookings Management
                </h1>

                <p class="text-sm text-slate-500">
                    Manage and track all customer bookings.
                </p>
            </section>

            {{-- SUCCESS --}}
            @if(session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ERRORS --}}
            @if($errors->any())
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- SEARCH / FILTER --}}
            <section class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">

                <form method="GET"
                      action="{{ route('admin.bookings.index') }}"
                      class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Search Bookings
                        </label>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search booking code, customer name or phone..."
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Booking Status
                        </label>

                        <select
                            name="status"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                        >
                            <option value="">All Statuses</option>

                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>
                                Confirmed
                            </option>

                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>
                                Completed
                            </option>

                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>
                                Cancelled
                            </option>
                        </select>
                    </div>

                    <div class="md:col-span-3 flex gap-3">
                        <button
                            type="submit"
                            class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition"
                        >
                            Search / Filter
                        </button>

                        <a
                            href="{{ route('admin.bookings.index') }}"
                            class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition"
                        >
                            Reset
                        </a>
                    </div>

                </form>

            </section>

            {{-- BOOKING COUNT --}}
            <section>
                <h2 class="text-lg font-bold text-slate-900">
                    All Bookings
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Showing {{ $bookings->count() }} of {{ $bookings->total() }} bookings
                </p>
            </section>

            {{-- BOOKINGS TABLE --}}
            <section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full text-left">

                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>

                                <th class="px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Booking
                                </th>

                                <th class="px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Customer
                                </th>

                                <th class="px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Vehicle
                                </th>

                                <th class="px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Package
                                </th>

                                <th class="px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Fare
                                </th>

                                <th class="px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Status
                                </th>

                                <th class="px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Action
                                </th>

                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse($bookings as $booking)

                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                        'confirmed' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'completed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                    ];

                                    $statusClass = $statusClasses[$booking->status]
                                        ?? 'bg-slate-100 text-slate-700 border-slate-200';
                                @endphp

                                <tr class="hover:bg-slate-50 transition">

                                    {{-- Booking --}}
                                    <td class="px-5 py-5 align-top">
                                        <div class="font-bold text-slate-900">
                                            {{ $booking->booking_code }}
                                        </div>

                                        @if($booking->created_at)
                                            <div class="text-xs text-slate-500 mt-1">
                                                {{ $booking->created_at->format('d M Y, h:i A') }}
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Customer --}}
                                    <td class="px-5 py-5 align-top">

                                        <div class="font-semibold text-slate-900">
                                            {{ $booking->customer_name }}
                                        </div>

                                        @if($booking->customer_phone)
                                            <div class="text-sm text-slate-500 mt-1">
                                                {{ $booking->customer_phone }}
                                            </div>
                                        @endif

                                        @if(isset($booking->customer_email) && $booking->customer_email)
                                            <div class="text-xs text-slate-400 mt-1">
                                                {{ $booking->customer_email }}
                                            </div>
                                        @endif

                                    </td>

                                    {{-- Vehicle --}}
                                    <td class="px-5 py-5 align-top">

                                        @if($booking->vehicle)

                                            <div class="font-semibold text-slate-800">
                                                {{ $booking->vehicle->name }}
                                            </div>

                                            @if(isset($booking->vehicle->category))
                                                <div class="text-xs text-slate-500 mt-1">
                                                    {{ $booking->vehicle->category }}
                                                </div>
                                            @endif

                                        @else

                                            <span class="text-sm text-slate-400">
                                                —
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Package --}}
                                    <td class="px-5 py-5 align-top">

                                        @if($booking->package)

                                            <div class="font-semibold text-slate-800">
                                                {{ $booking->package->name }}
                                            </div>

                                        @else

                                            <span class="text-sm text-slate-400">
                                                —
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Fare --}}
                                    <td class="px-5 py-5 align-top">

                                        <div class="font-bold text-slate-900">
                                            ₹{{ number_format((float) $booking->estimated_fare, 2) }}
                                        </div>

                                    </td>

                                    {{-- Status --}}
                                    <td class="px-5 py-5 align-top">

                                        <form
                                            method="POST"
                                            action="{{ route('admin.bookings.status', $booking) }}"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <select
                                                name="status"
                                                onchange="this.form.submit()"
                                                class="rounded-lg border px-3 py-2 text-xs font-semibold outline-none {{ $statusClass }}"
                                            >

                                                <option value="pending"
                                                    {{ $booking->status === 'pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>

                                                <option value="confirmed"
                                                    {{ $booking->status === 'confirmed' ? 'selected' : '' }}>
                                                    Confirmed
                                                </option>

                                                <option value="completed"
                                                    {{ $booking->status === 'completed' ? 'selected' : '' }}>
                                                    Completed
                                                </option>

                                                <option value="cancelled"
                                                    {{ $booking->status === 'cancelled' ? 'selected' : '' }}>
                                                    Cancelled
                                                </option>

                                            </select>
                                        </form>

                                    </td>

                                    {{-- Action --}}
                                    <td class="px-5 py-5 align-top">

                                        <form
                                            method="POST"
                                            action="{{ route('admin.bookings.destroy', $booking) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this booking?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-100 transition"
                                            >
                                                Delete
                                            </button>
                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="px-5 py-16 text-center">

                                        <div class="text-4xl mb-3">
                                            📋
                                        </div>

                                        <h3 class="font-bold text-slate-800">
                                            No bookings found
                                        </h3>

                                        <p class="text-sm text-slate-500 mt-1">
                                            Try changing your search or status filter.
                                        </p>

                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Pagination --}}
                @if($bookings->hasPages())
                    <div class="border-t border-slate-200 px-5 py-4">
                        {{ $bookings->links() }}
                    </div>
                @endif

            </section>

        </main>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>

</body>
</html>
