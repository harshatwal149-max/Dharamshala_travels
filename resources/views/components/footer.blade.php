@php
$footerLogo = \App\Models\Setting::get('site_logo', '');
$siteTitle = \App\Models\Setting::get('site_title', 'Dharamshala Travels');

$footerDescription = \App\Models\Setting::get(
'footer_description',
'Reliable cab services, airport transfers and Himachal tour packages from Dharamshala. Travel comfortably with experienced local drivers.'
);

$contactPhone = \App\Models\Setting::get('contact_phone', '+91 98765 43210');
$contactEmail = \App\Models\Setting::get('contact_email', 'info@dharamshalatravels.com');
$contactAddress = \App\Models\Setting::get(
'contact_address',
'Main Taxi Stand, Kotwali Bazar, Dharamshala, Himachal Pradesh 176215'
);
$contactHours = \App\Models\Setting::get('contact_hours', 'Available 6:00 AM – 11:00 PM');

$facebook = \App\Models\Setting::get('footer_facebook', '');
$instagram = \App\Models\Setting::get('footer_instagram', '');
$youtube = \App\Models\Setting::get('footer_youtube', '');
$whatsapp = \App\Models\Setting::get('footer_whatsapp', '');
$mapUrl = \App\Models\Setting::get('footer_map_url', '');

$phoneHref = preg_replace('/[^0-9+]/', '', $contactPhone);
$whatsappHref = preg_replace('/[^0-9]/', '', $whatsapp ?: $contactPhone);
@endphp

<footer class="bg-[#071018] text-gray-300 mt-16 border-t border-white/5">
    {{-- Main Footer --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-14">

            {{-- Brand --}}
            <div>
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
                    @if($footerLogo)
                    <img
                        src="{{ $footerLogo }}"
                        alt="{{ $siteTitle }}"
                        class="h-12 w-auto max-w-[190px] object-contain">
                    @else
                    <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-lg">
                        <i data-lucide="mountain-snow" class="w-6 h-6 text-emerald-600"></i>
                    </div>
                    <div>
                        <div class="text-white font-bold text-base group-hover:text-emerald-400 transition">
                            {{ $siteTitle }}
                        </div>
                        <div class="text-[10px] text-gray-500 mt-0.5 tracking-wide">
                            CAB & TOUR SERVICES
                        </div>
                    </div>
                    @endif
                </a>

                <p class="text-sm text-gray-400 leading-7 mt-5 max-w-sm">
                    {{ $footerDescription }}
                </p>

                <div class="flex flex-wrap items-center gap-2.5 mt-6">
                    @if($facebook)
                    <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer"
                        aria-label="Facebook"
                        class="w-9 h-9 rounded-lg border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/10 hover:border-emerald-500/40 transition">
                        <i data-lucide="facebook" class="w-4 h-4"></i>
                    </a>
                    @endif

                    @if($instagram)
                    <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer"
                        aria-label="Instagram"
                        class="w-9 h-9 rounded-lg border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/10 hover:border-emerald-500/40 transition">
                        <i data-lucide="instagram" class="w-4 h-4"></i>
                    </a>
                    @endif

                    @if($youtube)
                    <a href="{{ $youtube }}" target="_blank" rel="noopener noreferrer"
                        aria-label="YouTube"
                        class="w-9 h-9 rounded-lg border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/10 hover:border-emerald-500/40 transition">
                        <i data-lucide="youtube" class="w-4 h-4"></i>
                    </a>
                    @endif

                    <a href="mailto:{{ $contactEmail }}"
                        aria-label="Email"
                        class="w-9 h-9 rounded-lg border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/10 hover:border-emerald-500/40 transition">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                    </a>

                    <a href="tel:{{ $phoneHref }}"
                        aria-label="Call"
                        class="w-9 h-9 rounded-lg border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/10 hover:border-emerald-500/40 transition">
                        <i data-lucide="phone" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

            {{-- Useful Links --}}
            <div>
                <h3 class="text-white font-bold text-sm">Useful Links</h3>
                <div class="w-8 h-0.5 bg-emerald-500 mt-3 mb-5"></div>

                <ul class="space-y-3 text-sm">
                    <li><a href="{{ url('/') }}" class="footer-link"><i data-lucide="chevron-right"></i>Home</a></li>
                    <li><a href="{{ route('cabs.index') }}" class="footer-link"><i data-lucide="chevron-right"></i>Book a Cab</a></li>
                    <li><a href="{{ route('tours.index') }}" class="footer-link"><i data-lucide="chevron-right"></i>Tour Packages</a></li>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <a href="{{ url('/') }}" class="footer-link">
                                <i data-lucide="chevron-right"></i>
                                Home
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('cabs.index') }}" class="footer-link">
                                <i data-lucide="chevron-right"></i>
                                Book a Cab
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('tours.index') }}" class="footer-link">
                                <i data-lucide="chevron-right"></i>
                                Tour Packages
                            </a>
                        </li>

                    </ul>
                    <li><a href="{{ url('/blogs') }}" class="footer-link"><i data-lucide="chevron-right"></i>Travel Blog</a></li>
                    <li><a href="{{ route('contact') }}" class="footer-link"><i data-lucide="chevron-right"></i>Contact Us</a></li>
                </ul>
            </div>

            {{-- Travel Services --}}
            <div>
                <h3 class="text-white font-bold text-sm">Travel Services</h3>
                <div class="w-8 h-0.5 bg-emerald-500 mt-3 mb-5"></div>

                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('cabs.index') }}" class="footer-link"><i data-lucide="car-front"></i>Local Cab Service</a></li>
                    <li><a href="{{ route('cabs.index') }}" class="footer-link"><i data-lucide="plane"></i>Airport Transfer</a></li>
                    <li><a href="{{ route('cabs.index') }}" class="footer-link"><i data-lucide="route"></i>Outstation Cab</a></li>
                    <li><a href="{{ route('tours.index') }}" class="footer-link"><i data-lucide="mountain"></i>Himachal Tours</a></li>
                    <li><a href="{{ route('tours.index') }}" class="footer-link"><i data-lucide="map"></i>Local Sightseeing</a></li>
                    <li><a href="{{ route('contact') }}" class="footer-link"><i data-lucide="headphones"></i>Travel Assistance</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h3 class="text-white font-bold text-sm">Contact Us</h3>
                <div class="w-8 h-0.5 bg-emerald-500 mt-3 mb-5"></div>

                <div class="space-y-5">
                    <a href="tel:{{ $phoneHref }}" class="flex items-start gap-3 group">
                        <div class="footer-icon"><i data-lucide="phone"></i></div>
                        <div>
                            <div class="footer-label">Call Us</div>
                            <div class="footer-value">{{ $contactPhone }}</div>
                        </div>
                    </a>

                    <a href="mailto:{{ $contactEmail }}" class="flex items-start gap-3 group">
                        <div class="footer-icon"><i data-lucide="mail"></i></div>
                        <div class="min-w-0">
                            <div class="footer-label">Email</div>
                            <div class="footer-value break-all">{{ $contactEmail }}</div>
                        </div>
                    </a>

                    @if($mapUrl)
                    <a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer" class="flex items-start gap-3 group">
                        @else
                        <div class="flex items-start gap-3">
                            @endif
                            <div class="footer-icon"><i data-lucide="map-pin"></i></div>
                            <div>
                                <div class="footer-label">Address</div>
                                <div class="text-sm text-gray-400 leading-relaxed mt-1 group-hover:text-gray-300 transition">
                                    {{ $contactAddress }}
                                </div>
                            </div>
                            @if($mapUrl)
                    </a>
                    @else
                </div>
                @endif

                <div class="flex items-start gap-3">
                    <div class="footer-icon"><i data-lucide="clock-3"></i></div>
                    <div>
                        <div class="footer-label">Working Hours</div>
                        <div class="text-sm text-gray-400 mt-1">{{ $contactHours }}</div>
                    </div>
                </div>

                @if($whatsappHref)
                <a href="https://wa.me/{{ $whatsappHref }}" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-2.5 text-sm font-semibold text-emerald-400 hover:text-emerald-300 transition">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    WhatsApp Us
                </a>
                @endif
            </div>
        </div>
    </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col md:flex-row items-center justify-between gap-3">
            <p class="text-xs text-gray-500 text-center md:text-left">
                © {{ date('Y') }}
                <span class="text-gray-300">{{ $siteTitle }}</span>.
                All rights reserved.
            </p>

            <div class="flex items-center gap-5 text-xs text-gray-500">
                <a href="#" class="hover:text-white transition">Privacy Policy</a>
                <a href="#" class="hover:text-white transition">Terms & Conditions</a>
                @if($mapUrl)
                <a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition">Location</a>
                @endif
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-link {
        display: flex;
        align-items: center;
        gap: .5rem;
        color: rgb(156 163 175);
        transition: color .2s ease, transform .2s ease;
    }

    .footer-link:hover {
        color: rgb(255 255 255);
        transform: translateX(2px);
    }

    .footer-link svg {
        width: .875rem;
        height: .875rem;
        color: rgb(16 185 129);
        flex-shrink: 0;
    }

    .footer-icon {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: .5rem;
        background: rgb(16 185 129 / .10);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .footer-icon svg {
        width: 1rem;
        height: 1rem;
        color: rgb(52 211 153);
    }

    .footer-label {
        font-size: 11px;
        color: rgb(107 114 128);
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .footer-value {
        margin-top: .25rem;
        font-size: .875rem;
        font-weight: 600;
        color: rgb(229 231 235);
        transition: color .2s ease;
    }

    .group:hover .footer-value {
        color: rgb(52 211 153);
    }
</style>