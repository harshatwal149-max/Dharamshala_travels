<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer Reviews - {{ \App\Models\Setting::get('site_title', 'Dharamshala Travels') }}</title>

    @if(\App\Models\Setting::get('site_favicon'))
    <link rel="icon" type="image/x-icon" href="{{ \App\Models\Setting::get('site_favicon') }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }

        #adminMainContent { min-width: 0; width: 100%; }
        #adminTopHeader {
            min-height: 4rem;
            height: auto;
            gap: .75rem;
            flex-wrap: wrap;
            padding-top: .75rem;
            padding-bottom: .75rem;
        }
        #adminPageContent { min-width: 0; }
        .reviews-table { min-width: 850px; }
        .reviews-table th { white-space: nowrap; }
        .reviews-table td { overflow-wrap: anywhere; vertical-align: top; }
        .review-comment { min-width: 180px; max-width: 360px; white-space: normal; line-height: 1.55; }
        .review-customer { min-width: 130px; }
        .review-actions { min-width: 145px; white-space: nowrap; }
        .review-photo { width: 2.75rem; height: 2.75rem; object-fit: cover; }

        @media (max-width: 767px) {
            body.admin-reviews-page {
                height: auto;
                min-height: 100vh;
                overflow-x: hidden;
                overflow-y: auto;
            }
            #adminMainContent { min-height: 100vh; overflow-x: hidden; }
            #adminTopHeader { padding-left: 1rem; padding-right: 1rem; align-items: flex-start; }
            #adminTopHeader > a { margin-left: auto; max-width: 100%; text-align: center; }
            #adminPageContent { padding: 1rem; }
            .reviews-table th, .reviews-table td { padding: .75rem; }
        }

        @media (max-width: 420px) {
            #adminTopHeader { align-items: stretch; }
            #adminTopHeader > a { margin-left: 0; align-self: flex-start; }
            #adminPageContent { padding: .75rem; }
        }
    </style>
</head>

<body class="admin-reviews-page bg-slate-100 text-slate-800 antialiased flex h-screen overflow-hidden">

    {{-- COMMON ADMIN SIDEBAR --}}
    @include('admin.partials.sidebar')
    <div id="adminSidebarOverlay" class="hidden fixed inset-0 bg-slate-950 bg-opacity-50 z-40 md:hidden" aria-hidden="true"></div>

    {{-- MAIN CONTENT --}}
    <div id="adminMainContent" class="flex-1 flex flex-col overflow-y-auto min-w-0">

        {{-- Header --}}
        <header id="adminTopHeader" class="min-h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between shrink-0 sticky top-0 z-30">
            <div class="flex items-center gap-2 text-xs min-w-0">
                <span class="text-slate-400">Admin</span>
                <span class="text-slate-300">/</span>
                <span class="font-bold text-slate-800">Customer Reviews</span>
            </div>

            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center justify-center px-3 py-2 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                <span aria-hidden="true" class="mr-1">←</span> Back to Dashboard
            </a>
        </header>

        {{-- Page Content --}}
        <main id="adminPageContent" class="p-6 space-y-6 min-w-0">

            @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs flex items-start gap-2" role="status">
                <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                <span class="min-w-0">{{ session('success') }}</span>
            </div>
            @endif

            {{-- Reviews Table --}}
            <section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden" aria-label="Customer reviews">
                <div class="overflow-x-auto">
                    <table class="reviews-table w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                                <th scope="col" class="py-3.5 px-4">Customer</th>
                                <th scope="col" class="py-3.5 px-4">Rating</th>
                                <th scope="col" class="py-3.5 px-4">Review / Comment</th>
                                <th scope="col" class="py-3.5 px-4">Trip Photo</th>
                                <th scope="col" class="py-3.5 px-4">Status</th>
                                <th scope="col" class="py-3.5 px-4 text-right">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse($reviews as $review)
                            <tr class="hover:bg-slate-50 transition-colors">
                                {{-- Customer --}}
                                <td class="review-customer py-3.5 px-4 font-bold text-slate-900">
                                    <span>{{ $review->customer_name }}</span>
                                    <span class="block mt-1 text-[10px] text-slate-400 font-normal">
                                        {{ $review->created_at ? $review->created_at->format('d M, Y') : '' }}
                                    </span>
                                </td>

                                {{-- Rating --}}
                                <td class="py-3.5 px-4 text-amber-500 font-bold whitespace-nowrap" aria-label="Rating {{ $review->rating }} out of 5">
                                    {{ str_repeat('★', max(0, min(5, (int) $review->rating))) }}{{ str_repeat('☆', 5 - max(0, min(5, (int) $review->rating))) }}
                                </td>

                                {{-- Comment --}}
                                <td class="py-3.5 px-4 text-slate-600">
                                    <div class="review-comment">{{ $review->comment }}</div>
                                </td>

                                {{-- Image --}}
                                <td class="py-3.5 px-4">
                                    @if($review->image)
                                    <a href="{{ asset('storage/' . $review->image) }}" target="_blank" rel="noopener noreferrer" aria-label="Open trip photo for {{ $review->customer_name }}">
                                        <img src="{{ asset('storage/' . $review->image) }}" alt="Trip photo uploaded by {{ $review->customer_name }}" loading="lazy" class="review-photo rounded-lg border border-slate-200">
                                    </a>
                                    @else
                                    <span class="text-slate-400 text-[10px]">No image</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex px-2 py-1 rounded-full text-[10px] font-bold whitespace-nowrap {{ $review->is_approved ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $review->is_approved ? 'Approved' : 'Pending' }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="review-actions py-3.5 px-4 text-right">
                                    <div class="inline-flex items-center justify-end gap-2">
                                        <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST" class="inline-flex">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center px-2.5 py-2 text-[11px] font-semibold rounded-lg bg-slate-900 text-white hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-1 transition-colors">
                                                {{ $review->is_approved ? 'Unapprove' : 'Approve' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="inline-flex" onsubmit="return confirm('Delete this review?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" aria-label="Delete review by {{ $review->customer_name }}" title="Delete review"
                                                class="inline-flex items-center justify-center p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-300 transition-colors">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 px-4 text-slate-400">No customer reviews yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    {{-- Initialize icons and mobile sidebar overlay --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            const sidebarOverlay = document.getElementById('adminSidebarOverlay');
            const closeMobileSidebar = function () {
                document.body.classList.remove('admin-sidebar-mobile-open');
                if (sidebarOverlay) sidebarOverlay.classList.add('hidden');
            };

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeMobileSidebar);
            }

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') closeMobileSidebar();
            });
        });
    </script>

</body>
</html>
