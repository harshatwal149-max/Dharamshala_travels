<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Inquiries Management - {{ \App\Models\Setting::get('site_title', 'Dharamshala Travels') }}
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

        .inquiry-table th {
            white-space: nowrap;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased flex h-screen overflow-hidden">

    {{-- =========================================================
         COMMON ADMIN SIDEBAR
    ========================================================== --}}
    @include('admin.partials.sidebar')


    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}
    <div class="flex-1 flex flex-col overflow-y-auto min-w-0">

        {{-- =====================================================
             TOP HEADER
        ====================================================== --}}
        <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between shrink-0 sticky top-0 z-30">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-xs">
                <span class="text-slate-400">Admin</span>
                <span class="text-slate-300">/</span>
                <span class="font-bold text-slate-800">Inquiries</span>
            </div>

            {{-- Website --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                    <i data-lucide="globe" class="w-3.5 h-3.5 text-slate-500"></i>
                    <span>Website</span>
                </a>
            </div>
        </header>


        {{-- =====================================================
             PAGE CONTENT
        ====================================================== --}}
        <main class="p-6 space-y-6">

            {{-- Page Heading --}}
            <section class="space-y-1">
                <h1 class="text-xl font-extrabold text-slate-900">
                    Inquiries Management
                </h1>

                <p class="text-sm text-slate-500">
                    Manage and track all customer inquiries.
                </p>
            </section>


            {{-- =================================================
                 SEARCH / FILTER CARD
            ================================================== --}}
            <form method="GET"
                action="{{ route('admin.inquiries.index') }}"
                class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">

                    {{-- Search --}}
                    <div class="lg:col-span-9">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Search Inquiries
                        </label>

                        <input type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search customer name, phone, email or subject..."
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 bg-white text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400">
                    </div>

                    {{-- Status --}}
                    <div class="lg:col-span-3">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Inquiry Status
                        </label>

                        <select name="status"
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400">
                            <option value="">All Statuses</option>
                            <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>
                                New
                            </option>
                            <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>
                                Read
                            </option>
                            <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>
                                Replied
                            </option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-4">
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition">
                        Search
                    </button>

                    <a href="{{ route('admin.inquiries.index') }}"
                        class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Reset
                    </a>
                </div>
            </form>


            {{-- =================================================
                 INQUIRIES HEADING
            ================================================== --}}
            <div>
                <h2 class="text-lg font-extrabold text-slate-900">
                    All Inquiries
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Showing {{ $enquiries->count() }} of {{ method_exists($enquiries, 'total') ? $enquiries->total() : $enquiries->count() }} inquiries
                </p>
            </div>


            {{-- Success --}}
            @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm flex items-center gap-2">
                <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif


            {{-- Validation Errors --}}
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


            {{-- =================================================
                 TABLE
            ================================================== --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full text-left border-collapse text-xs inquiry-table">

                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">

                                <th class="py-4 px-5">
                                    Customer
                                </th>

                                <th class="py-4 px-5">
                                    Contact
                                </th>

                                <th class="py-4 px-5">
                                    Subject
                                </th>

                                <th class="py-4 px-5 min-w-[280px]">
                                    Message
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

                            @forelse($enquiries as $inquiry)

                            @php
                            $inquiryStatus = $inquiry->status ?? 'new';
                            @endphp

                            <tr class="hover:bg-slate-50 transition-colors">

                                {{-- Customer --}}
                                <td class="py-4 px-5 align-top">

                                    <div class="font-bold text-slate-900 text-sm">
                                        {{ $inquiry->name }}
                                    </div>

                                    <div class="text-[11px] text-slate-400 mt-1">
                                        {{ $inquiry->created_at
                                                ? $inquiry->created_at->format('d M, Y · h:i A')
                                                : '' }}
                                    </div>

                                </td>


                                {{-- Contact --}}
                                <td class="py-4 px-5 align-top">

                                    <div class="font-medium text-slate-800">
                                        {{ $inquiry->phone ?: '—' }}
                                    </div>

                                    <div class="text-[11px] text-slate-500 mt-1">
                                        {{ $inquiry->email ?: '—' }}
                                    </div>

                                </td>


                                {{-- Subject --}}
                                <td class="py-4 px-5 align-top">

                                    <div class="font-semibold text-slate-700">
                                        {{ $inquiry->subject ?? 'General Enquiry' }}
                                    </div>

                                </td>


                                {{-- Message --}}
                                <td class="py-4 px-5 align-top">

                                    <div class="text-slate-600 leading-5 max-w-md">
                                        {{ \Illuminate\Support\Str::limit($inquiry->message ?? '', 120) }}
                                    </div>

                                </td>


                                {{-- Status --}}
                                <td class="py-4 px-5 align-top">

                                    @if($inquiryStatus === 'new')
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100 font-bold text-[11px]">
                                        New
                                    </span>
                                    @elseif($inquiryStatus === 'read')
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-50 text-blue-700 border border-blue-100 font-bold text-[11px]">
                                        Read
                                    </span>
                                    @elseif($inquiryStatus === 'replied')
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-purple-50 text-purple-700 border border-purple-100 font-bold text-[11px]">
                                        Replied
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-slate-100 text-slate-600 border border-slate-200 font-bold text-[11px]">
                                        {{ ucfirst($inquiryStatus) }}
                                    </span>
                                    @endif

                                </td>


                                {{-- Action --}}
                                <td class="py-4 px-5 text-right align-top">

                                    <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}"
                                        method="POST"
                                        class="inline delete-inquiry-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="px-3.5 py-2 rounded-lg border border-red-200 bg-red-50 text-red-600 text-xs font-semibold hover:bg-red-100 transition">
                                            Delete
                                        </button>

                                    </form>

                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="6" class="text-center py-16">

                                    <div class="flex flex-col items-center justify-center">

                                        <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center mb-3">
                                            <i data-lucide="inbox" class="w-6 h-6 text-slate-400"></i>
                                        </div>

                                        <div class="font-bold text-slate-700">
                                            No customer inquiries found.
                                        </div>

                                        <div class="text-xs text-slate-400 mt-1">
                                            New inquiries will appear here.
                                        </div>

                                    </div>

                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                @if(method_exists($enquiries, 'links'))
                <div class="px-5 py-4 border-t border-slate-100">
                    {{ $enquiries->withQueryString()->links() }}
                </div>
                @endif

            </div>

        </main>

    </div>


    {{-- =========================================================
         SCRIPTS
    ========================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            document.querySelectorAll('.delete-inquiry-form').forEach(function(form) {

                form.addEventListener('submit', function(event) {

                    event.preventDefault();

                    Swal.fire({
                        title: 'Delete Inquiry?',
                        text: 'This inquiry will be permanently deleted.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Delete',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,
                        customClass: {
                            popup: 'rounded-2xl'
                        }
                    }).then(function(result) {

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