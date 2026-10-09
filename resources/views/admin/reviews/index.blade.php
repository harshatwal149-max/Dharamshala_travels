<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Customer Reviews - {{ \App\Models\Setting::get('site_title', 'Dharamshala Travels') }}
    </title>

    @if(\App\Models\Setting::get('site_favicon'))
    <link rel="icon"
        type="image/x-icon"
        href="{{ \App\Models\Setting::get('site_favicon') }}">
    @endif

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Tailwind CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- Alpine.js --}}
    <script defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased flex h-screen overflow-hidden">

    {{-- ONE COMMON ADMIN SIDEBAR --}}
    @include('admin.partials.sidebar')


    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col overflow-y-auto min-w-0">

        {{-- Header --}}
        <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between shrink-0 sticky top-0 z-30">

            <div class="flex items-center gap-2 text-xs">

                <span class="text-slate-400">
                    Admin
                </span>

                <span class="text-slate-300">
                    /
                </span>

                <span class="font-bold text-slate-800">
                    Customer Reviews
                </span>

            </div>

            <a href="{{ route('admin.dashboard') }}"
                class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">

                ← Back to Dashboard

            </a>

        </header>


        {{-- Page Content --}}
        <main class="p-6 space-y-6">

            {{-- Success Message --}}
            @if(session('success'))

            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs flex items-center gap-2">

                <i data-lucide="check-circle"
                    class="w-4 h-4 text-emerald-600"></i>

                <span>
                    {{ session('success') }}
                </span>

            </div>

            @endif


            {{-- Reviews Table --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full text-left border-collapse text-xs">

                        <thead>

                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">

                                <th class="py-3.5 px-4">
                                    Customer
                                </th>

                                <th class="py-3.5 px-4">
                                    Rating
                                </th>

                                <th class="py-3.5 px-4">
                                    Review / Comment
                                </th>

                                <th class="py-3.5 px-4">
                                    Trip Photo
                                </th>

                                <th class="py-3.5 px-4">
                                    Status
                                </th>

                                <th class="py-3.5 px-4 text-right">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">

                            @forelse($reviews as $review)

                            <tr class="hover:bg-slate-50 transition-colors">

                                {{-- Customer --}}
                                <td class="py-3.5 px-4 font-bold text-slate-900">

                                    {{ $review->customer_name }}

                                    <span class="block text-[10px] text-slate-400 font-normal">
                                        {{ $review->created_at ? $review->created_at->format('d M, Y') : '' }}
                                    </span>

                                </td>


                                {{-- Rating --}}
                                <td class="py-3.5 px-4 text-amber-500 font-bold">

                                    {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}

                                </td>


                                {{-- Comment --}}
                                <td class="py-3.5 px-4 max-w-sm text-slate-600">

                                    {{ $review->comment }}

                                </td>


                                {{-- Image --}}
                                <td class="py-3.5 px-4">

                                    @if($review->image)

                                    <a href="{{ asset('storage/' . $review->image) }}"
                                        target="_blank">

                                        <img src="{{ asset('storage/' . $review->image) }}"
                                            class="w-10 h-10 object-cover rounded-lg border border-slate-200">

                                    </a>

                                    @else

                                    <span class="text-slate-400 text-[10px]">
                                        No image
                                    </span>

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="py-3.5 px-4">

                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold
                                            {{ $review->is_approved
                                                ? 'bg-emerald-100 text-emerald-800'
                                                : 'bg-amber-100 text-amber-800' }}">

                                        {{ $review->is_approved ? 'Approved' : 'Pending' }}

                                    </span>

                                </td>


                                {{-- Actions --}}
                                <td class="py-3.5 px-4 text-right space-x-2">

                                    {{-- Approve / Unapprove --}}
                                    <form action="{{ route('admin.reviews.update', $review->id) }}"
                                        method="POST"
                                        class="inline">

                                        @csrf
                                        @method('PUT')

                                        <button type="submit"
                                            class="px-2.5 py-1 text-[11px] font-semibold rounded bg-slate-900 text-white hover:bg-slate-800">

                                            {{ $review->is_approved ? 'Unapprove' : 'Approve' }}

                                        </button>

                                    </form>


                                    {{-- Delete --}}
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Delete this review?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="p-1 text-slate-400 hover:text-red-600 rounded">

                                            <i data-lucide="trash-2"
                                                class="w-4 h-4"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center py-10 text-slate-400">

                                    No customer reviews yet.

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </main>

    </div>


    {{-- Initialize Lucide --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

        });
    </script>

</body>

</html>