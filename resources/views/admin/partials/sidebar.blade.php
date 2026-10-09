<aside class="w-64 h-screen bg-white border-r border-slate-200 flex flex-col shrink-0 overflow-hidden">

    <div>

        {{-- Sidebar Header --}}
        <div class="h-16 flex items-center px-5 border-b border-slate-200">

            @php
                $panelLogo = \App\Models\Setting::get('site_logo');
                $siteTitle = \App\Models\Setting::get('site_title', 'Dharamshala Travels');

                $pendingBookings = \App\Models\Booking::where('status', 'pending')->count();
                $activeFleet = \App\Models\Vehicle::where('is_active', 1)->count();
                $totalPackages = \App\Models\Package::count();
                $unreadEnquiryCount = \App\Models\Enquiry::where('status', 'unread')->count();
                $totalBlogs = \App\Models\Blog::count();
            @endphp

            {{-- Logo / Brand --}}
            <a
                href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 w-full min-w-0"
            >

                <div class="w-9 h-9 rounded-lg bg-white flex items-center justify-center shrink-0 overflow-hidden">

                    @if($panelLogo)

                        <img
                            src="{{ $panelLogo }}"
                            alt="{{ $siteTitle }}"
                            class="w-full h-full object-contain"
                        >

                    @else

                        <i
                            data-lucide="mountain-snow"
                            class="w-6 h-6 text-emerald-600"
                        ></i>

                    @endif

                </div>


                <div class="min-w-0 flex-1">

                    <span class="text-sm font-bold text-slate-900 block truncate uppercase">
                        {{ $siteTitle }}
                    </span>

                    <span class="text-[10px] text-slate-500 font-semibold uppercase tracking-wide block truncate">
                        CAB & TOUR OPERATIONS
                    </span>

                </div>

            </a>

        </div>


        {{-- Navigation --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-7">


            {{-- MAIN --}}
            <div>

                <span class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-3">
                    Main
                </span>


                <nav class="space-y-1">


                    {{-- Dashboard --}}
                    <a
                        href="{{ route('admin.dashboard') }}"
                        data-sidebar-menu="dashboard"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-semibold
                        {{ request()->routeIs('admin.dashboard')
                            ? 'bg-slate-100 text-slate-900'
                            : 'text-slate-800 hover:bg-slate-50' }}"
                    >

                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>

                        <span>Dashboard</span>

                    </a>


                    {{-- Bookings --}}
                    <a
                        href="{{ route('admin.bookings.index') }}"
                        data-sidebar-menu="bookings"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-xs font-semibold
                        {{ request()->routeIs('admin.bookings.*')
                            ? 'bg-slate-100 text-slate-900'
                            : 'text-slate-800 hover:bg-slate-50' }}"
                    >

                        <div class="flex items-center gap-3">

                            <i data-lucide="inbox" class="w-4 h-4"></i>

                            <span>Bookings</span>

                        </div>

                        <span class="text-[10px] text-slate-500">
                            {{ $pendingBookings }}
                        </span>

                    </a>


                    {{-- Inquiries --}}
                    <a
                        href="{{ route('admin.inquiries.index') }}"
                        data-sidebar-menu="inquiries"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-xs font-semibold
                        {{ request()->routeIs('admin.inquiries.*')
                            ? 'bg-slate-100 text-slate-900'
                            : 'text-slate-800 hover:bg-slate-50' }}"
                    >

                        <div class="flex items-center gap-3">

                            <i data-lucide="mail-question" class="w-4 h-4"></i>

                            <span>Inquiries</span>

                        </div>


                        @if($unreadEnquiryCount > 0)

                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500 text-white">
                                {{ $unreadEnquiryCount }}
                            </span>

                        @endif

                    </a>


                    {{-- Blogs --}}
                    <a
                        href="{{ route('admin.blogs.index') }}"
                        data-sidebar-menu="blogs"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-xs font-semibold
                        {{ request()->routeIs('admin.blogs.*')
                            ? 'bg-slate-100 text-slate-900'
                            : 'text-slate-800 hover:bg-slate-50' }}"
                    >

                        <div class="flex items-center gap-3">

                            <i data-lucide="newspaper" class="w-4 h-4"></i>

                            <span>Blogs</span>

                        </div>

                        <span class="text-[10px] text-slate-500">
                            {{ $totalBlogs }}
                        </span>

                    </a>


                </nav>

            </div>


            {{-- FLEET & TOURS --}}
            <div>

                <span class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-3">
                    Fleet & Tours
                </span>


                <nav class="space-y-1">


                    {{-- All Vehicles --}}
                    <a
                        href="{{ route('admin.vehicles.index') }}"
                        data-sidebar-menu="vehicles"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-semibold
                        {{ request()->routeIs('admin.vehicles.*')
                            ? 'bg-slate-100 text-slate-900'
                            : 'text-slate-800 hover:bg-slate-50' }}"
                    >

                        <i data-lucide="car" class="w-4 h-4"></i>

                        <span>All Vehicles</span>

                        <span class="ml-auto text-[10px] text-slate-500">
                            {{ $activeFleet }}
                        </span>

                    </a>


                    {{-- Tour Circuits --}}
                    <a
                        href="{{ route('admin.tours.index') }}"
                        data-sidebar-menu="packages"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-semibold
                        {{ request()->routeIs('admin.tours.*') || request()->routeIs('admin.packages.*')
                            ? 'bg-slate-100 text-slate-900'
                            : 'text-slate-800 hover:bg-slate-50' }}"
                    >

                        <i data-lucide="map" class="w-4 h-4"></i>

                        <span>Tour Circuits</span>

                        <span class="ml-auto text-[10px] text-slate-500">
                            {{ $totalPackages }}
                        </span>

                    </a>


                </nav>

            </div>


            {{-- CONFIGURATION --}}
            <div>

                <span class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-3">
                    Configuration
                </span>


                <nav class="space-y-1">


                    {{-- Hero Banner --}}
                    <a
                        href="{{ route('admin.banner') }}"
                        data-sidebar-menu="banner"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-semibold
                        {{ request()->routeIs('admin.banner')
                            ? 'bg-slate-100 text-slate-900'
                            : 'text-slate-800 hover:bg-slate-50' }}"
                    >

                        <i data-lucide="image" class="w-4 h-4 text-emerald-600"></i>

                        <span>Hero Banner</span>

                    </a>


                    {{-- Top Announcement Bar --}}
                    <a
                        href="{{ route('admin.top-announcement') }}"
                        data-sidebar-menu="top-announcement"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-semibold
                        {{ request()->routeIs('admin.top-announcement.*')
                            ? 'bg-slate-100 text-slate-900'
                            : 'text-slate-800 hover:bg-slate-50' }}"
                    >

                        <i data-lucide="megaphone" class="w-4 h-4 text-emerald-600"></i>

                        <span>Top Announcement Bar</span>

                    </a>


                    {{-- Logo & Favicon --}}
                    <a
                        href="{{ route('admin.logo-favicon') }}"
                        data-sidebar-menu="logo-favicon"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-semibold
                        {{ request()->routeIs('admin.logo-favicon.*')
                            ? 'bg-slate-100 text-slate-900'
                            : 'text-slate-800 hover:bg-slate-50' }}"
                    >

                        <i data-lucide="badge" class="w-4 h-4 text-emerald-600"></i>

                        <span>Logo & Favicon</span>

                    </a>


                    {{-- Basic Contact Information --}}
                    <a
                        href="{{ route('admin.contact-information') }}"
                        data-sidebar-menu="contact-information"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-semibold
                        {{ request()->routeIs('admin.contact-information.*')
                            ? 'bg-slate-100 text-slate-900'
                            : 'text-slate-800 hover:bg-slate-50' }}"
                    >

                        <i data-lucide="phone" class="w-4 h-4 text-emerald-600"></i>

                        <span>Basic Contact Information</span>

                    </a>


                    {{-- Email Desk --}}
                    <a
                        href="{{ route('admin.email-desk') }}"
                        data-sidebar-menu="email-desk"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-semibold
                        {{ request()->routeIs('admin.email-desk.*')
                            ? 'bg-slate-100 text-slate-900'
                            : 'text-slate-800 hover:bg-slate-50' }}"
                    >

                        <i data-lucide="mail" class="w-4 h-4 text-emerald-600"></i>

                        <span>Email Desk</span>

                    </a>


                    {{-- Basic Settings --}}
                    <a
                        href="{{ route('admin.settings') }}"
                        data-sidebar-menu="settings"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-semibold
                        {{ request()->routeIs('admin.settings')
                            ? 'bg-slate-100 text-slate-900'
                            : 'text-slate-800 hover:bg-slate-50' }}"
                    >

                        <i data-lucide="settings" class="w-4 h-4 text-emerald-600"></i>

                        <span>Basic Settings (SEO)</span>

                    </a>


                    {{-- Customer Reviews --}}
                    <a
                        href="{{ route('admin.reviews.index') }}"
                        data-sidebar-menu="reviews"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-semibold
                        {{ request()->routeIs('admin.reviews.*')
                            ? 'bg-slate-100 text-slate-900'
                            : 'text-slate-800 hover:bg-slate-50' }}"
                    >

                        <i data-lucide="message-square" class="w-4 h-4 text-amber-500"></i>

                        <span>Customer Reviews</span>

                    </a>


                </nav>

            </div>


        </div>

    </div>


    {{-- ADMINISTRATOR --}}
    <div class="p-4 border-t border-slate-200 shrink-0 bg-white">

        <div class="flex items-center justify-between mb-3">

            <div class="flex items-center gap-3 min-w-0">

                <div class="w-8 h-8 rounded-full border border-slate-200 flex items-center justify-center text-xs font-bold text-slate-700 shrink-0">
                    AD
                </div>

                <div class="min-w-0">

                    <span class="text-xs font-bold text-slate-800 block">
                        Administrator
                    </span>

                    <span class="text-[10px] text-slate-500 block truncate">
                        {{ auth()->user()->email ?? 'admin@gmail.com' }}
                    </span>

                </div>

            </div>


            <a
                href="{{ route('home') }}"
                target="_blank"
                class="text-slate-700 hover:text-slate-900"
            >

                <i data-lucide="external-link" class="w-4 h-4"></i>

            </a>

        </div>


        {{-- Sign Out --}}
        <form action="{{ route('admin.logout') }}" method="POST">

            @csrf

            <button
                type="submit"
                class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg border border-slate-200 text-xs font-semibold text-slate-800 hover:bg-slate-50"
            >

                <i data-lucide="log-out" class="w-3.5 h-3.5"></i>

                <span>Sign Out</span>

            </button>

        </form>

    </div>

</aside>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        function updateSidebarActiveState() {

            const currentPath = window.location.pathname;

            const menuItems = document.querySelectorAll(
                '[data-sidebar-menu]'
            );


            menuItems.forEach(function (item) {

                item.classList.remove(
                    'bg-slate-100',
                    'text-slate-900'
                );

                item.classList.add(
                    'text-slate-800',
                    'hover:bg-slate-50'
                );

            });


            let activeKey = null;


            if (
                currentPath === '/admin' ||
                currentPath === '/admin/'
            ) {

                activeKey = 'dashboard';

            } else if (
                currentPath.startsWith('/admin/bookings')
            ) {

                activeKey = 'bookings';

            } else if (
                currentPath.startsWith('/admin/inquiries')
            ) {

                activeKey = 'inquiries';

            } else if (
                currentPath.startsWith('/admin/blogs')
            ) {

                activeKey = 'blogs';

            } else if (
                currentPath.startsWith('/admin/vehicles')
            ) {

                activeKey = 'vehicles';

            } else if (
                currentPath.startsWith('/admin/tours') ||
                currentPath.startsWith('/admin/packages')
            ) {

                activeKey = 'packages';

            } else if (
                currentPath === '/admin/banner'
            ) {

                activeKey = 'banner';

            } else if (
                currentPath.startsWith('/admin/top-announcement')
            ) {

                activeKey = 'top-announcement';

            } else if (
                currentPath.startsWith('/admin/logo-favicon')
            ) {

                activeKey = 'logo-favicon';

            } else if (
                currentPath.startsWith('/admin/contact-information')
            ) {

                activeKey = 'contact-information';

            } else if (
                currentPath.startsWith('/admin/email-desk')
            ) {

                activeKey = 'email-desk';

            } else if (
                currentPath.startsWith('/admin/settings')
            ) {

                activeKey = 'settings';

            } else if (
                currentPath.startsWith('/admin/reviews')
            ) {

                activeKey = 'reviews';

            }


            if (activeKey) {

                const activeItem = document.querySelector(
                    '[data-sidebar-menu="' + activeKey + '"]'
                );


                if (activeItem) {

                    activeItem.classList.remove(
                        'text-slate-800',
                        'hover:bg-slate-50'
                    );

                    activeItem.classList.add(
                        'bg-slate-100',
                        'text-slate-900'
                    );

                }

            }

        }


        updateSidebarActiveState();

    });
</script>