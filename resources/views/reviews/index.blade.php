<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Dynamic SEO & Meta Tags -->
    @include('components.seo', [
        'title' => 'Customer Reviews & Feedback | Dharamshala Travels',
        'description' => 'Read verified traveler reviews and ratings for cab bookings, airport transfers, and sightseeing tours across Dharamshala, McLeodganj, and Kangra Valley.'
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
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-gray-800 text-emerald-400 border border-gray-700 mb-3">
                Verified Guest Experiences
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Traveler Feedback & Ratings</h1>
            <p class="text-gray-400 text-sm max-w-xl mx-auto mt-2">
                Real stories from travelers exploring Dharamshala, McLeodganj, Dalhousie, and beyond with our fleet.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-12 flex-1 w-full" x-data="{ reviewModal: false, selectedRating: 5 }">

        <!-- Top Bar: Action to Write Review -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8 bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
            <div>
                <h2 class="text-base font-bold text-gray-900">Have you traveled with us recently?</h2>
                <p class="text-xs text-gray-500">Your feedback helps fellow travelers plan their Himalayan mountain journeys.</p>
            </div>
            <button type="button" 
                    @click="reviewModal = true" 
                    class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm transition flex items-center space-x-2 shrink-0">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
                <span>Write a Review</span>
            </button>
        </div>

        <!-- Reviews Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($reviews as $item)
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
                    <div>
                        <!-- Rating Stars -->
                        <div class="flex items-center space-x-1 text-amber-400 mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <i data-lucide="star" class="w-4 h-4 {{ $i <= ($item->rating ?? 5) ? 'fill-current' : 'text-gray-200' }}"></i>
                            @endfor
                            <span class="text-xs font-bold text-gray-700 ml-1.5">{{ $item->rating ?? 5 }}.0</span>
                        </div>

                        <!-- Review Text -->
                        <p class="text-xs text-gray-700 leading-relaxed italic">
                            "{{ $item->comment }}"
                        </p>
                    </div>

                    <!-- Author Details -->
                    <div class="pt-4 mt-4 border-t border-gray-100 flex items-center justify-between">
                        <div class="flex items-center space-x-2.5">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs">
                                {{ strtoupper(substr($item->customer_name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900">{{ $item->customer_name }}</h4>
                                <span class="text-[10px] text-gray-400">{{ $item->customer_location ?? 'Verified Traveler' }}</span>
                            </div>
                        </div>
                        <span class="text-[10px] text-gray-400">{{ $item->created_at ? $item->created_at->format('M Y') : 'Recent' }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-gray-200">
                    <i data-lucide="message-square" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                    <h3 class="text-base font-bold text-gray-700">No Reviews Published Yet</h3>
                    <p class="text-xs text-gray-500 mt-1">Be the first traveler to share your journey experience!</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($reviews->hasPages())
            <div class="mt-10">
                {{ $reviews->links() }}
            </div>
        @endif

        <!-- Submit Review Modal -->
        <div x-show="reviewModal" 
             style="display: none;" 
             class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
            
            <div @click.away="reviewModal = false" 
                 class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 sm:p-8 relative">
                
                <button @click="reviewModal = false" type="button" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>

                <div class="mb-5">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Feedback Form</span>
                    <h3 class="text-xl font-bold text-gray-900">Share Your Experience</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Reviews are moderated before appearing live on the portal.</p>
                </div>

                <form action="{{ route('reviews.store') }}" method="POST" class="space-y-3.5 text-xs">
                    @csrf

                    <div>
                        <label class="block font-semibold mb-1 text-gray-700 uppercase text-[10px]">Your Name *</label>
                        <input type="text" name="customer_name" required placeholder="Full Name" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg outline-hidden focus:ring-2 focus:ring-gray-900 text-xs">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-semibold mb-1 text-gray-700 uppercase text-[10px]">Your City / Location</label>
                            <input type="text" name="customer_location" placeholder="e.g. Chandigarh / Delhi" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg outline-hidden focus:ring-2 focus:ring-gray-900 text-xs">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-gray-700 uppercase text-[10px]">Rating *</label>
                            <select name="rating" required x-model="selectedRating" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg outline-hidden focus:ring-2 focus:ring-gray-900 text-xs">
                                <option value="5">5 Star - Excellent</option>
                                <option value="4">4 Star - Very Good</option>
                                <option value="3">3 Star - Average</option>
                                <option value="2">2 Star - Poor</option>
                                <option value="1">1 Star - Bad</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1 text-gray-700 uppercase text-[10px]">Your Review Comment *</label>
                        <textarea name="comment" rows="4" required placeholder="Tell us about the vehicle condition, punctuality, and chauffeur demeanor..." class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg outline-hidden focus:ring-2 focus:ring-gray-900 text-xs"></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-3 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-xl text-xs transition shadow-xs flex items-center justify-center space-x-2">
                            <i data-lucide="send" class="w-4 h-4 text-emerald-400"></i>
                            <span>Submit Feedback</span>
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

            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    iconColor: '#10b981',
                    title: '<span class="text-lg font-bold text-gray-900">Thank You!</span>',
                    text: '{{ session("success") }}',
                    confirmButtonText: 'Great',
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