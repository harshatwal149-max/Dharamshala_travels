{{--
    Site header — self-contained (own CSS + vanilla JS) so it renders identically
    on pages using Vite/Tailwind 4 and on older pages using the Tailwind 2 CDN.
--}}
@php
    $siteLogo = \App\Support\Media::url(\App\Models\Setting::get('site_logo'));
    $siteTitle = \App\Models\Setting::get('site_title') ?: 'Dharamshala Travels';
    $headerPhone = \App\Models\Setting::get('contact_phone') ?: '+91 98765 43210';
    $headerPhoneHref = preg_replace('/[^0-9+]/', '', $headerPhone);

    $topBarText = \App\Models\Setting::get('top_bar_text');
    $topBarPhone = \App\Models\Setting::get('top_bar_phone') ?: $headerPhone;
    $topBarLocation = \App\Models\Setting::get('top_bar_location');

    $navItems = [
        ['Home',         url('/'),                      request()->is('/')],
        ['Book Cab',     route('cabs.index'),           request()->routeIs('cabs.*', 'vehicles.*')],
        ['Tour Packages',route('tours.index'),          request()->routeIs('tours.*', 'packages.*')],
        ['Destinations', route('destinations.index'),   request()->routeIs('destinations.*')],
        ['Taxi Routes',  route('taxi-routes.index'),    request()->routeIs('taxi-routes.*', 'airport-taxi')],
        ['Blog',         route('blogs.public'),         request()->routeIs('blogs.*')],
        ['Contact',      route('contact'),              request()->routeIs('contact')],
    ];

    $icons = [
        'phone' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/>',
        'pin'   => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
        'spark' => '<path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>',
        'cal'   => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/><path d="m9 16 2 2 4-4"/>',
        'menu'  => '<path d="M4 6h16M4 12h16M4 18h16"/>',
        'close' => '<path d="M18 6 6 18M6 6l12 12"/>',
        'mount' => '<path d="m8 3 4 8 5-5 5 15H2L8 3z"/>',
    ];
    $svg = fn ($name, $size = 16) => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.$icons[$name].'</svg>';
@endphp

{{-- Fonts (some legacy pages do not load them) --}}
@once
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700;800&display=swap">
@endonce

{{-- Top bar (scrolls away) --}}
@if($topBarText || $topBarPhone || $topBarLocation)
<div class="dth-topbar">
    <div class="dth-container dth-topbar-inner">
        @if($topBarText)
            <p class="dth-topbar-text">{!! $svg('spark', 14) !!}<span>{{ $topBarText }}</span></p>
        @endif
        <div class="dth-topbar-meta">
            @if($topBarPhone)
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $topBarPhone) }}">{!! $svg('phone', 13) !!}{{ $topBarPhone }}</a>
            @endif
            @if($topBarLocation)
                <span>{!! $svg('pin', 13) !!}{{ $topBarLocation }}</span>
            @endif
        </div>
    </div>
</div>
@endif

{{-- Main header (sticky) --}}
<header class="dth" id="dth" data-open="false">
    <div class="dth-container dth-bar">

        <a href="{{ url('/') }}" class="dth-brand" aria-label="{{ $siteTitle }} — home">
            @if($siteLogo)
                <img src="{{ $siteLogo }}" alt="{{ $siteTitle }}" class="dth-logo"
                     onerror="this.remove(); document.querySelectorAll('.dth-mark').forEach(function (m) { m.style.display = 'flex'; });">
            @endif
            <span class="dth-mark" @if($siteLogo) style="display:none" @endif>{!! $svg('mount', 22) !!}</span>
            <span class="dth-brand-text">
                <span class="dth-brand-name">{{ $siteTitle }}</span>
                <span class="dth-brand-tag">Taxi & Tours • Himachal</span>
            </span>
        </a>

        <nav class="dth-nav" aria-label="Main">
            @foreach($navItems as [$label, $href, $active])
                <a href="{{ $href }}" @class(['dth-link', 'is-active' => $active]) @if($active) aria-current="page" @endif>{{ $label }}</a>
            @endforeach
        </nav>

        <div class="dth-actions">
            <a href="tel:{{ $headerPhoneHref }}" class="dth-phone">
                <span class="dth-phone-icon">{!! $svg('phone', 15) !!}</span>
                <span><span class="dth-phone-label">Call us 24/7</span>{{ $headerPhone }}</span>
            </a>
            <a href="{{ route('cabs.index') }}" class="dth-cta" data-dth-book>
                {!! $svg('cal', 16) !!}<span>Book a Cab</span>
            </a>
            <button type="button" class="dth-burger" aria-controls="dth-mobile" aria-expanded="false" aria-label="Open menu" data-dth-toggle>
                <span class="dth-i-open">{!! $svg('menu', 22) !!}</span>
                <span class="dth-i-close">{!! $svg('close', 22) !!}</span>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div class="dth-mobile" id="dth-mobile">
        <nav class="dth-container" aria-label="Mobile">
            @foreach($navItems as [$label, $href, $active])
                <a href="{{ $href }}" @class(['dth-mlink', 'is-active' => $active])>{{ $label }}</a>
            @endforeach
            <div class="dth-mactions">
                <a href="tel:{{ $headerPhoneHref }}" class="dth-mbtn dth-mbtn-outline">{!! $svg('phone', 16) !!}Call {{ $headerPhone }}</a>
                <a href="{{ route('cabs.index') }}" class="dth-mbtn dth-mbtn-solid" data-dth-book>{!! $svg('cal', 16) !!}Book a Cab</a>
            </div>
        </nav>
    </div>
</header>

<style>
    /* `overflow-x: hidden` on html/body breaks position: sticky; `clip` gives the same result without that. */
    html, body { overflow-x: clip !important; }

    .dth, .dth-topbar { font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif; -webkit-font-smoothing: antialiased; }
    .dth *, .dth-topbar * { box-sizing: border-box; }
    .dth a, .dth-topbar a { text-decoration: none; }
    .dth svg, .dth-topbar svg { display: block; flex-shrink: 0; }

    .dth-container { width: 100%; max-width: 80rem; margin: 0 auto; padding: 0 1rem; }
    @media (min-width: 640px) { .dth-container { padding: 0 1.5rem; } }
    @media (min-width: 1024px) { .dth-container { padding: 0 2rem; } }

    /* Top bar */
    .dth-topbar { background: #0a1f1a; color: rgba(255,255,255,.72); font-size: 12px; line-height: 1.4; }
    .dth-topbar-inner { display: flex; align-items: center; justify-content: space-between; gap: 1rem; min-height: 36px; padding-top: 6px; padding-bottom: 6px; }
    .dth-topbar-text { display: flex; align-items: center; gap: .5rem; margin: 0; min-width: 0; }
    .dth-topbar-text span { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .dth-topbar-text svg, .dth-topbar-meta svg { color: #f8b84e; }
    .dth-topbar-meta { display: flex; align-items: center; gap: 1.25rem; flex-shrink: 0; }
    .dth-topbar-meta a, .dth-topbar-meta span { display: inline-flex; align-items: center; gap: .4rem; color: inherit; white-space: nowrap; }
    .dth-topbar-meta a:hover { color: #fff; }
    @media (max-width: 767px) {
        .dth-topbar-meta span { display: none; }
        .dth-topbar-text { font-size: 11px; }
    }
    @media (max-width: 479px) { .dth-topbar-meta { display: none; } }

    /* Main bar */
    .dth { position: sticky; top: 0; z-index: 50; background: rgba(255,255,255,.96); border-bottom: 1px solid #ece7dd; transition: box-shadow .25s ease, background .25s ease; }
    @supports (backdrop-filter: blur(8px)) { .dth { background: rgba(255,255,255,.88); backdrop-filter: saturate(160%) blur(12px); -webkit-backdrop-filter: saturate(160%) blur(12px); } }
    .dth.is-scrolled { box-shadow: 0 8px 30px -12px rgba(10,31,26,.25); }
    .dth-bar { display: flex; align-items: center; gap: 1.25rem; height: 76px; transition: height .25s ease; }
    .dth.is-scrolled .dth-bar { height: 64px; }

    .dth-brand { display: flex; align-items: center; gap: .7rem; min-width: 0; flex-shrink: 1; color: #0a1f1a; }
    @media (min-width: 1200px) { .dth-brand { flex-shrink: 0; } }
    .dth-logo { height: 50px; width: auto; max-width: 160px; object-fit: contain; flex-shrink: 0; transition: height .25s ease; }
    @media (max-width: 380px) { .dth-logo { height: 42px; } }
    .dth.is-scrolled .dth-logo { height: 40px; }
    .dth-mark { display: flex; align-items: center; justify-content: center; width: 42px; height: 42px; border-radius: 12px; background: #0a1f1a; color: #f8b84e; flex-shrink: 0; }
    .dth-brand-text { display: flex; flex-direction: column; min-width: 0; }
    .dth-brand-name { font-family: "Plus Jakarta Sans", Inter, ui-sans-serif, system-ui, sans-serif; font-size: 1.15rem; font-weight: 800; letter-spacing: -.02em; line-height: 1.15; color: #0a1f1a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .dth-brand-tag { font-size: 10px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #1f644d; white-space: nowrap; }

    .dth-nav { display: none; align-items: center; justify-content: center; gap: .1rem; flex: 1; min-width: 0; }
    .dth-link { position: relative; padding: .55rem .65rem; border-radius: .6rem; font-size: .875rem; font-weight: 600; color: #3f3a33; white-space: nowrap; transition: color .2s, background .2s; }
    .dth-link:hover { color: #0a1f1a; background: #f4efe6; }
    .dth-link.is-active { color: #1a503f; }
    .dth-link.is-active::after { content: ""; position: absolute; left: .7rem; right: .7rem; bottom: .2rem; height: 2px; border-radius: 2px; background: #f29b20; }

    .dth-actions { display: flex; align-items: center; gap: .6rem; margin-left: auto; flex-shrink: 0; }
    .dth-phone { display: none; align-items: center; gap: .6rem; color: #0a1f1a; font-size: .875rem; font-weight: 700; line-height: 1.2; white-space: nowrap; }
    .dth-phone-icon { display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 9999px; background: #eef7f3; color: #1f644d; }
    .dth-phone-label { display: block; font-size: 10px; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: #78716c; }
    .dth-phone:hover .dth-phone-icon { background: #1a503f; color: #fff; }

    .dth-cta { display: none; align-items: center; gap: .5rem; height: 44px; padding: 0 1.1rem; border-radius: .8rem; background: #f29b20; color: #0a1f1a; font-size: .875rem; font-weight: 700; white-space: nowrap; box-shadow: 0 6px 18px -8px rgba(242,155,32,.7); transition: background .2s, transform .2s; }
    .dth-cta:hover { background: #f8b84e; transform: translateY(-1px); }

    .dth-burger { display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; border: 1px solid #ece7dd; border-radius: .8rem; background: #fff; color: #0a1f1a; cursor: pointer; }
    .dth-burger:hover { background: #f4efe6; }
    .dth-i-close { display: none; }
    .dth[data-open="true"] .dth-i-open { display: none; }
    .dth[data-open="true"] .dth-i-close { display: block; }

    .dth-mobile { display: none; border-top: 1px solid #ece7dd; background: #fff; max-height: calc(100vh - 64px); overflow-y: auto; }
    .dth[data-open="true"] .dth-mobile { display: block; }
    .dth-mobile nav { display: flex; flex-direction: column; padding-top: .75rem; padding-bottom: 1.25rem; }
    .dth-mlink { padding: .8rem .75rem; border-radius: .7rem; font-size: 1rem; font-weight: 600; color: #3f3a33; }
    .dth-mlink:hover { background: #f4efe6; }
    .dth-mlink.is-active { background: #eef7f3; color: #1a503f; }
    .dth-mactions { display: grid; gap: .6rem; margin-top: .9rem; }
    .dth-mbtn { display: flex; align-items: center; justify-content: center; gap: .5rem; height: 48px; border-radius: .8rem; font-size: .95rem; font-weight: 700; }
    .dth-mbtn-outline { border: 1px solid #d6cfc2; color: #0a1f1a; }
    .dth-mbtn-solid { background: #f29b20; color: #0a1f1a; }

    @media (min-width: 640px) { .dth-cta { display: inline-flex; } }
    @media (min-width: 1200px) {
        .dth-nav { display: flex; }
        .dth-burger, .dth-mobile, .dth[data-open="true"] .dth-mobile { display: none; }
    }
    @media (min-width: 1536px) { .dth-phone { display: flex; } }
    @media (max-width: 380px) { .dth-brand-tag { display: none; } .dth-brand-name { font-size: 1rem; } }
</style>

<script>
    (function () {
        var header = document.getElementById('dth');
        if (!header || header.dataset.ready) return;
        header.dataset.ready = '1';

        var toggle = header.querySelector('[data-dth-toggle]');

        function setOpen(open) {
            header.dataset.open = open ? 'true' : 'false';
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
        }

        toggle.addEventListener('click', function () { setOpen(header.dataset.open !== 'true'); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') setOpen(false); });
        window.addEventListener('resize', function () { if (window.innerWidth >= 1200) setOpen(false); });

        function onScroll() { header.classList.toggle('is-scrolled', window.scrollY > 8); }
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();

        // Open the booking modal where the page has one; otherwise follow the link to /cabs.
        header.querySelectorAll('[data-dth-book]').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                if (!document.querySelector('[data-booking-modal]')) return;
                e.preventDefault();
                setOpen(false);
                window.dispatchEvent(new CustomEvent('open-booking', { detail: {} }));
            });
        });
    })();
</script>
