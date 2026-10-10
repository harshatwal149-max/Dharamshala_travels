@php
    $footerLogo = \App\Support\Media::url(\App\Models\Setting::get('site_logo'));
    $siteTitle = \App\Models\Setting::get('site_title') ?: 'Dharamshala Travels';

    $footerDescription = \App\Models\Setting::get('footer_description')
        ?: 'Reliable cab services, airport transfers and Himachal tour packages from Dharamshala. Travel comfortably with experienced local drivers.';

    $contactPhone = \App\Models\Setting::get('contact_phone') ?: '+91 98765 43210';
    $contactEmail = \App\Models\Setting::get('contact_email') ?: 'info@dharamshalatravels.com';
    $contactAddress = \App\Models\Setting::get('contact_address') ?: 'Main Taxi Stand, Kotwali Bazar, Dharamshala, Himachal Pradesh 176215';
    $contactHours = \App\Models\Setting::get('contact_hours') ?: 'Available 6:00 AM – 11:00 PM';

    $facebook = \App\Models\Setting::get('footer_facebook');
    $instagram = \App\Models\Setting::get('footer_instagram');
    $youtube = \App\Models\Setting::get('footer_youtube');
    $whatsapp = \App\Models\Setting::get('footer_whatsapp');
    $mapUrl = \App\Models\Setting::get('footer_map_url');

    $phoneHref = preg_replace('/[^0-9+]/', '', $contactPhone);
    $whatsappHref = preg_replace('/[^0-9]/', '', $whatsapp ?: $contactPhone);

    $exploreLinks = [
        ['Home', url('/')],
        ['Book a Cab', route('cabs.index')],
        ['Tour Packages', route('tours.index')],
        ['Places to Visit', route('destinations.index')],
        ['Taxi Routes', route('taxi-routes.index')],
        ['Travel Blog', route('blogs.public')],
        ['About Us', route('about')],
        ['Contact Us', route('contact')],
    ];

    $serviceLinks = [
        ['plane', 'Gaggal Airport Taxi', route('airport-taxi')],
        ['car-front', 'Local Cab Service', route('cabs.index')],
        ['map', 'Local Sightseeing', route('destinations.index')],
        ['route', 'Outstation Cabs', route('taxi-routes.index')],
        ['mountain', 'Himachal Tours', route('tours.index')],
        ['headphones', 'Travel Assistance', route('contact')],
    ];

    $socials = array_filter([
        'facebook'  => $facebook,
        'instagram' => $instagram,
        'youtube'   => $youtube,
    ]);
@endphp

<footer class="site-footer">

    {{-- Main --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-10 lg:pt-16">
        <div class="grid grid-cols-2 lg:grid-cols-12 gap-x-6 gap-y-10 lg:gap-8">

            {{-- Brand --}}
            <div class="col-span-2 lg:col-span-4">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                    @if($footerLogo)
                        <img src="{{ $footerLogo }}" alt="{{ $siteTitle }} logo" class="footer-logo-img"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                    @endif
                    <span class="footer-mark" @if($footerLogo) style="display:none" @endif><i data-lucide="mountain-snow"></i></span>
                    <span>
                        <span class="block text-lg font-extrabold text-white leading-tight">{{ $siteTitle }}</span>
                        <span class="block footer-kicker">Cab & Tour Services</span>
                    </span>
                </a>

                <p class="footer-text mt-5 max-w-sm">{{ $footerDescription }}</p>

                <div class="flex flex-wrap items-center gap-2 mt-6">
                    @foreach($socials as $icon => $link)
                        <a href="{{ $link }}" target="_blank" rel="noopener noreferrer" aria-label="{{ ucfirst($icon) }}" class="footer-social">
                            <i data-lucide="{{ $icon }}"></i>
                        </a>
                    @endforeach
                    <a href="https://wa.me/{{ $whatsappHref }}" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp" class="footer-social">
                        <i data-lucide="message-circle"></i>
                    </a>
                    <a href="mailto:{{ $contactEmail }}" aria-label="Email" class="footer-social">
                        <i data-lucide="mail"></i>
                    </a>
                    <a href="tel:{{ $phoneHref }}" aria-label="Call" class="footer-social">
                        <i data-lucide="phone"></i>
                    </a>
                </div>
            </div>

            {{-- Explore --}}
            <nav class="col-span-1 lg:col-span-2" aria-label="Footer">
                <h3 class="footer-heading">Explore</h3>
                <ul class="space-y-2.5 mt-5">
                    @foreach($exploreLinks as [$label, $href])
                        <li><a href="{{ $href }}" class="footer-link">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </nav>

            {{-- Services --}}
            <div class="col-span-1 lg:col-span-3">
                <h3 class="footer-heading">Travel Services</h3>
                <ul class="space-y-2.5 mt-5">
                    @foreach($serviceLinks as [$icon, $label, $href])
                        <li>
                            <a href="{{ $href }}" class="footer-link">
                                <i data-lucide="{{ $icon }}"></i>{{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact --}}
            <div class="col-span-2 lg:col-span-3">
                <h3 class="footer-heading">Contact Us</h3>
                <ul class="space-y-4 mt-5">
                    <li>
                        <a href="tel:{{ $phoneHref }}" class="footer-contact">
                            <span class="footer-icon"><i data-lucide="phone"></i></span>
                            <span>
                                <span class="footer-label">Call / WhatsApp</span>
                                <span class="footer-value">{{ $contactPhone }}</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="mailto:{{ $contactEmail }}" class="footer-contact">
                            <span class="footer-icon"><i data-lucide="mail"></i></span>
                            <span class="min-w-0">
                                <span class="footer-label">Email</span>
                                <span class="footer-value break-all">{{ $contactEmail }}</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <{{ $mapUrl ? 'a' : 'div' }} @if($mapUrl) href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer" @endif class="footer-contact">
                            <span class="footer-icon"><i data-lucide="map-pin"></i></span>
                            <span>
                                <span class="footer-label">Address</span>
                                <span class="footer-text block mt-0.5">{{ $contactAddress }}</span>
                            </span>
                        </{{ $mapUrl ? 'a' : 'div' }}>
                    </li>
                    <li>
                        <div class="footer-contact">
                            <span class="footer-icon"><i data-lucide="clock-3"></i></span>
                            <span>
                                <span class="footer-label">Working Hours</span>
                                <span class="footer-text block mt-0.5">{{ $contactHours }}</span>
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="footer-bottom">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col md:flex-row items-center justify-between gap-3">
            <p class="text-center md:text-left">
                © {{ date('Y') }} <span class="text-white">{{ $siteTitle }}</span>. All rights reserved.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-x-5 gap-y-2">
                <a href="{{ route('photo-credits') }}">Photo Credits</a>
                <a href="{{ url('/sitemap.xml') }}">Sitemap</a>
                @if($mapUrl)
                    <a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer">Location</a>
                @endif
            </div>
        </div>
    </div>
</footer>

<style>
    /* Self-contained so the footer looks the same on pages using Vite (Tailwind 4) and the CDN (Tailwind 2). */
    .site-footer {
        background:
            radial-gradient(120% 80% at 100% 0%, rgba(42, 124, 96, .18) 0%, rgba(10, 31, 26, 0) 60%),
            #0a1f1a;
        color: rgba(255, 255, 255, .72);
        font-size: .875rem;
    }

    body:not(.dt-site) .site-footer { margin-top: 4rem; }

    .site-footer .footer-text { color: rgba(255, 255, 255, .62); line-height: 1.75; }
    .site-footer .footer-kicker { font-size: 10px; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: #f8b84e; margin-top: 2px; }

    .site-footer .footer-logo-img { height: 3.25rem; width: auto; flex-shrink: 0; }

    .site-footer .footer-mark {
        display: flex; align-items: center; justify-content: center;
        width: 2.75rem; height: 2.75rem; border-radius: .75rem;
        background: #f29b20; color: #0a1f1a; flex-shrink: 0;
    }
    .site-footer .footer-mark svg { width: 1.4rem; height: 1.4rem; }

    .site-footer .footer-heading {
        color: #fff; font-weight: 700; font-size: .8rem;
        letter-spacing: .12em; text-transform: uppercase;
        display: flex; align-items: center; gap: .6rem;
    }
    .site-footer .footer-heading::before { content: ""; width: 1.25rem; height: 2px; border-radius: 2px; background: #f29b20; }

    .site-footer .footer-link {
        display: inline-flex; align-items: center; gap: .55rem;
        color: rgba(255, 255, 255, .68); transition: color .2s ease, transform .2s ease;
    }
    .site-footer .footer-link:hover { color: #fcd38a; transform: translateX(3px); }
    .site-footer .footer-link svg { width: 1rem; height: 1rem; color: #46987a; flex-shrink: 0; }

    .site-footer .footer-social {
        display: flex; align-items: center; justify-content: center;
        width: 2.4rem; height: 2.4rem; border-radius: 9999px;
        border: 1px solid rgba(255, 255, 255, .14); color: rgba(255, 255, 255, .75);
        transition: background .2s, color .2s, border-color .2s;
    }
    .site-footer .footer-social:hover { background: #f29b20; border-color: #f29b20; color: #0a1f1a; }
    .site-footer .footer-social svg { width: 1rem; height: 1rem; }

    .site-footer .footer-contact { display: flex; align-items: flex-start; gap: .85rem; }
    .site-footer .footer-icon {
        display: flex; align-items: center; justify-content: center;
        width: 2.4rem; height: 2.4rem; border-radius: .7rem; flex-shrink: 0;
        background: rgba(255, 255, 255, .06); border: 1px solid rgba(255, 255, 255, .08);
    }
    .site-footer .footer-icon svg { width: 1rem; height: 1rem; color: #f8b84e; }
    .site-footer .footer-label { display: block; font-size: 11px; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: rgba(255, 255, 255, .45); }
    .site-footer .footer-value { display: block; margin-top: .15rem; font-weight: 600; color: #fff; transition: color .2s; }
    .site-footer a.footer-contact:hover .footer-value { color: #fcd38a; }

    .site-footer .footer-bottom { border-top: 1px solid rgba(255, 255, 255, .08); font-size: .75rem; color: rgba(255, 255, 255, .5); }
    .site-footer .footer-bottom a { transition: color .2s; }
    .site-footer .footer-bottom a:hover { color: #fff; }
</style>
