<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact Us | {{ \App\Models\Setting::get('site_title', 'Dharamshala Travels') }}</title>
    <meta name="description" content="Get in touch with Dharamshala Travels for customized tour packages, airport cab bookings, and round-the-clock Himachal mountain travel inquiries.">

    @if(\App\Models\Setting::get('site_favicon'))
    <link rel="icon" type="image/x-icon" href="{{ \App\Models\Setting::get('site_favicon') }}">
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>

    @include('components.seo', [
    'title' => 'Contact Us | ' . \App\Models\Setting::get('site_title', 'Dharamshala Travels'),
    'description' => 'Get in touch with Dharamshala Travels for 24/7 cab bookings, Gaggal airport transfers, and custom tour packages.'
])
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- Reusable Global Header -->
    @include('components.header')

    <!-- Hero / Header Title Section -->
    <section class="bg-gray-900 text-white py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 text-center">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-gray-800 text-green-400 border border-gray-700 mb-3">
                24/7 Travel Desk & Assistance
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Get in Touch With Us</h1>
            <p class="text-gray-400 text-sm max-w-xl mx-auto mt-2">
                Have questions about cab fares, custom tour itineraries, or Gaggal Airport transfers? Drop a message or call directly.
            </p>
        </div>
    </section>

    <!-- Main Content: Details + Enquiry Form -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-12 flex-1 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left Column: 100% Dynamic Company Details (from Admin Settings) -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-200 shadow-sm space-y-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">
                            {{ \App\Models\Setting::get('site_title', 'Dharamshala Travels') }}
                        </h2>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ \App\Models\Setting::get('contact_subtitle', 'Official Himachal Pradesh taxi and tour mobility operations center.') }}
                        </p>
                    </div>

                    <div class="space-y-4 pt-4 border-t border-gray-100 text-xs">
                        <!-- Helpline & Hours -->
                        <div class="flex items-start space-x-3">
                            <div class="p-2.5 bg-green-50 text-green-700 rounded-xl shrink-0 mt-0.5">
                                <i data-lucide="phone-call" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block text-xs">Contact Helpline</span>
                                <a href="tel:{{ \App\Models\Setting::get('contact_phone', '+91 98765 43210') }}" class="text-gray-600 hover:text-green-700 transition">
                                    {{ \App\Models\Setting::get('contact_phone', '+91 98765 43210') }}
                                </a>
                                <span class="block text-[10px] text-gray-400 mt-0.5">
                                    {{ \App\Models\Setting::get('contact_hours', 'Available 6:00 AM – 11:00 PM') }}
                                </span>
                            </div>
                        </div>

                        <!-- Email Desk & Response -->
                        <div class="flex items-start space-x-3">
                            <div class="p-2.5 bg-blue-50 text-blue-700 rounded-xl shrink-0 mt-0.5">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block text-xs">Email Desk</span>
                                <a href="mailto:{{ \App\Models\Setting::get('contact_email', 'info@dharamshalatravels.com') }}" class="text-gray-600 hover:text-blue-700 transition">
                                    {{ \App\Models\Setting::get('contact_email', 'info@dharamshalatravels.com') }}
                                </a>
                                <span class="block text-[10px] text-gray-400 mt-0.5">
                                    {{ \App\Models\Setting::get('contact_email_response', 'Response within 2 hours') }}
                                </span>
                            </div>
                        </div>

                        <!-- Office Address -->
                        <div class="flex items-start space-x-3">
                            <div class="p-2.5 bg-yellow-50 text-yellow-700 rounded-xl shrink-0 mt-0.5">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block text-xs">Office Address</span>
                                <p class="text-gray-600 leading-relaxed whitespace-pre-line">
                                    {{ \App\Models\Setting::get('contact_address', 'Main Taxi Stand, Kotwali Bazar, Dharamshala, Himachal Pradesh 176215') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Highlight Box (Guarantee) -->
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 text-xs text-gray-600 space-y-1.5">
                        <div class="flex items-center space-x-1.5 font-bold text-gray-900">
                            <i data-lucide="shield-check" class="w-4 h-4 text-green-600"></i>
                            <span>{{ \App\Models\Setting::get('contact_guarantee_title', 'Transparent Rates Guarantee') }}</span>
                        </div>
                        <p class="text-[11px] text-gray-500 leading-relaxed">
                            {{ \App\Models\Setting::get('contact_guarantee_desc', 'No hidden hill surcharges, permit fees, or toll taxes. Instant dispatch for Gaggal Airport transfers.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Enquiry Form -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-200 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900 mb-1">Send an Enquiry</h2>
                    <p class="text-xs text-gray-500 mb-6">Fill out the form below and our tour manager will coordinate your travel.</p>

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-4 text-xs">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold mb-1 text-gray-700 uppercase text-[10px]">Your Name *</label>
                                <input type="text" name="name" required placeholder="e.g. Rajesh Kumar" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-gray-900 text-xs">
                            </div>
                            <div>
                                <label class="block font-semibold mb-1 text-gray-700 uppercase text-[10px]">Phone Number *</label>
                                <input type="tel" name="phone" required placeholder="e.g. 98160XXXXX" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-gray-900 text-xs">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold mb-1 text-gray-700 uppercase text-[10px]">Email Address (Optional)</label>
                                <input type="email" name="email" placeholder="e.g. rajesh@example.com" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-gray-900 text-xs">
                            </div>
                            <div>
                                <label class="block font-semibold mb-1 text-gray-700 uppercase text-[10px]">Subject / Topic</label>
                                <input type="text" name="subject" placeholder="e.g. Dharamshala to Manali Cab Enquiry" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-gray-900 text-xs">
                            </div>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1 text-gray-700 uppercase text-[10px]">Your Message / Requirement *</label>
                            <textarea name="message" rows="4" required placeholder="Tell us your travel dates, passenger count, pickup point or questions..." class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-gray-900 text-xs"></textarea>
                        </div>

                        <button type="submit" class="w-full py-3 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-lg text-xs transition shadow-sm flex items-center justify-center space-x-2">
                            <i data-lucide="send" class="w-3.5 h-3.5"></i>
                            <span>Send Enquiry Now</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <!-- Reusable Global Footer -->
    @include('components.footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            @if(session('enquiry_success'))
                Swal.fire({
                    icon: 'success',
                    iconColor: '#10b981',
                    title: '<span class="text-lg font-bold text-gray-900">Enquiry Submitted!</span>',
                    text: "{{ session('enquiry_success') }}",
                    confirmButtonText: 'Great, Thanks!',
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