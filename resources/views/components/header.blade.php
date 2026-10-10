<header

    x-data="{ mobileMenuOpen: false }"

    class="sticky top-0 z-40 bg-white border-b border-gray-200 shadow-sm">



    @php

    /*

    |--------------------------------------------------------------------------

    | Website Branding

    |--------------------------------------------------------------------------

    */



    $siteLogo = \App\Models\Setting::get('site_logo', '');



    $siteTitle = \App\Models\Setting::get(

    'site_title',

    'Dharamshala Travels'

    );



    /*

    |--------------------------------------------------------------------------

    | Header Contact

    |--------------------------------------------------------------------------

    */



    $headerPhone = \App\Models\Setting::get(

    'contact_phone',

    '+91 98765 43210'

    );



    /*

    |--------------------------------------------------------------------------

    | Top Announcement Bar

    |--------------------------------------------------------------------------

    */



    $topBarText = \App\Models\Setting::get(

    'top_bar_text',

    'Gaggal Airport (DHM) & Himachal Tour Chauffeur Network'

    );



    $topBarPhone = \App\Models\Setting::get(

    'top_bar_phone',

    '+91 98765 43210'

    );



    $topBarLocation = \App\Models\Setting::get(

    'top_bar_location',

    'Dharamshala, HP'

    );

    @endphp





    {{-- =========================================================

         TOP ANNOUNCEMENT BAR

    ========================================================== --}}



    <div class="bg-gray-900 text-gray-400 text-xs border-b border-gray-800">



        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-2">



            <div class="flex flex-col sm:flex-row items-center justify-between gap-2">



                {{-- Announcement --}}

                @if($topBarText)



                <div class="flex items-center gap-1.5 text-center sm:text-left">



                    <i

                        data-lucide="megaphone"

                        class="w-3.5 h-3.5 text-emerald-400 shrink-0"></i>



                    <span class="text-gray-300">

                        {{ $topBarText }}

                    </span>



                </div>



                @endif





                {{-- Phone + Location --}}

                <div class="flex items-center gap-4 shrink-0">



                    @if($topBarPhone)



                    <a

                        href="tel:{{ preg_replace('/[^0-9+]/', '', $topBarPhone) }}"

                        class="flex items-center gap-1.5 text-gray-400 hover:text-white transition">



                        <i

                            data-lucide="phone-call"

                            class="w-3.5 h-3.5 text-emerald-400"></i>



                        <span>

                            {{ $topBarPhone }}

                        </span>



                    </a>



                    @endif





                    @if($topBarPhone && $topBarLocation)



                    <span class="text-gray-700">|</span>



                    @endif





                    @if($topBarLocation)



                    <span class="flex items-center gap-1.5 text-gray-400">



                        <i

                            data-lucide="map-pin"

                            class="w-3.5 h-3.5 text-emerald-400"></i>



                        <span>

                            {{ $topBarLocation }}

                        </span>



                    </span>



                    @endif



                </div>



            </div>



        </div>



    </div>





    {{-- =========================================================

         MAIN HEADER

    ========================================================== --}}



    <div class="max-w-7xl mx-auto px-4 sm:px-6">



        <div class="h-20 flex items-center justify-between gap-6">





            {{-- =====================================================

                 LOGO (ENLARGED & PROMINENT)

            ====================================================== --}}



            <a

                href="{{ url('/') }}"

                class="flex items-center group shrink-0 py-1">



                @if($siteLogo)



                {{-- Logo container ko bada kiya gaya hai taaki logo saaf aur clear dikhe --}}

                <div class="h-16 sm:h-[72px] w-auto max-w-[150px] flex items-center justify-center overflow-hidden">

                    <img

                        src="{{ $siteLogo }}"

                        alt="{{ $siteTitle }}"

                        class="h-full w-auto max-w-full object-contain transition-transform duration-200 group-hover:scale-105"

                        loading="eager">

                </div>



                @else



                <div

                    class="w-12 h-12 rounded-xl bg-gray-900 flex items-center justify-center text-white shrink-0 group-hover:scale-105 transition-transform duration-200 shadow-sm">



                    <i

                        data-lucide="mountain-snow"

                        class="w-7 h-7 text-emerald-400"></i>



                </div>



                @endif





                <div>



                    <span

                        class="text-xl sm:text-2xl font-extrabold tracking-tight text-gray-900 block leading-tight group-hover:text-emerald-700 transition-colors">

                        {{ $siteTitle }}

                    </span>



                    <span

                        class="text-[11px] font-bold tracking-wider text-gray-500 uppercase block mt-0.5">



                    </span>



                </div>



            </a>





            {{-- =====================================================

                 DESKTOP NAVIGATION

            ====================================================== --}}



            <nav

                class="hidden md:flex items-center justify-center gap-8 lg:gap-10 text-sm font-semibold text-gray-700 flex-1">



                {{-- HOME --}}

                <a

                    href="{{ url('/') }}"

                    class="whitespace-nowrap transition-colors {{ request()->is('/') ? 'text-emerald-700 font-bold' : 'hover:text-emerald-700' }}">

                    Home

                </a>





                {{-- BOOK CAB --}}

                <a

                    href="{{ route('cabs.index') }}"

                    class="whitespace-nowrap transition-colors {{ request()->routeIs('cabs.\*') ? 'text-emerald-700 font-bold' : 'hover:text-emerald-700' }}">

                    Book Cab

                </a>





                {{-- TOUR PACKAGES --}}

                <a

                    href="{{ route('tours.index') }}"

                    class="whitespace-nowrap transition-colors {{ request()->routeIs('tours.\*') ? 'text-emerald-700 font-bold' : 'hover:text-emerald-700' }}">

                    Tour Packages

                </a>





                {{-- BLOGS --}}

                <a

                    href="{{ url('/blogs') }}"

                    class="whitespace-nowrap transition-colors {{ request()->is('blogs\*') ? 'text-emerald-700 font-bold' : 'hover:text-emerald-700' }}">

                    Blogs

                </a>





                {{-- CONTACT --}}

                <a

                    href="{{ route('contact') }}"

                    class="whitespace-nowrap transition-colors {{ request()->routeIs('contact') ? 'text-emerald-700 font-bold' : 'hover:text-emerald-700' }}">

                    Contact Us

                </a>



            </nav>





            {{-- =====================================================

                 RIGHT SIDE

            ====================================================== --}}



            <div class="hidden lg:flex items-center gap-3 shrink-0">



                @if($headerPhone)



                <a

                    href="tel:{{ preg_replace('/[^0-9+]/', '', $headerPhone) }}"

                    class="flex items-center gap-1.5 text-xs font-semibold text-gray-600 hover:text-emerald-700 px-2.5 py-1.5 rounded-lg hover:bg-gray-50 transition-colors">



                    <i

                        data-lucide="phone-call"

                        class="w-3.5 h-3.5 text-emerald-600"></i>



                    <span>

                        {{ $headerPhone }}

                    </span>



                </a>



                @endif

                <a
                    href="tel:+919816338442"
                    class="flex items-center gap-1.5 text-xs font-semibold text-gray-600 hover:text-emerald-700 px-2.5 py-1.5 rounded-lg hover:bg-gray-50 transition-colors">
                    <i data-lucide="phone-call" class="w-3.5 h-3.5 text-emerald-600"></i>
                    <span>+91-98163-38442</span>
                </a>

                <a
                    href="tel:+919459264147"
                    class="flex items-center gap-1.5 text-xs font-semibold text-gray-600 hover:text-emerald-700 px-2.5 py-1.5 rounded-lg hover:bg-gray-50 transition-colors">
                    <i data-lucide="phone-call" class="w-3.5 h-3.5 text-emerald-600"></i>
                    <span>+91-9459264147</span>
                </a>





                {{-- ENQUIRY --}}

                <a

                    href="{{ route('contact') }}"

                    class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-bold rounded-xl transition-colors">



                    <i

                        data-lucide="mail-question"

                        class="w-3.5 h-3.5 text-emerald-700"></i>



                    <span>

                        Enquiry

                    </span>



                </a>





                {{-- RESERVE RIDE --}}

                <a

                    href="{{ route('cabs.index') }}"

                    class="inline-block px-4 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-xs font-semibold rounded-xl shadow-sm transition-colors">

                    Reserve Ride

                </a>



            </div>





            {{-- =====================================================

                 MOBILE MENU BUTTON

            ====================================================== --}}



            <div class="flex md:hidden items-center gap-2">



                {{-- Mobile Enquiry --}}

                <a

                    href="{{ route('contact') }}"

                    class="p-2 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-colors"

                    title="Send Enquiry">



                    <i

                        data-lucide="mail-question"

                        class="w-5 h-5"></i>



                </a>





                {{-- Mobile Menu --}}

                <button

                    type="button"

                    @click="mobileMenuOpen = !mobileMenuOpen"

                    class="p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none"

                    aria-label="Toggle Navigation">



                    <i

                        data-lucide="menu"

                        class="w-6 h-6"

                        x-show="!mobileMenuOpen"></i>



                    <i

                        data-lucide="x"

                        class="w-6 h-6"

                        x-show="mobileMenuOpen"

                        style="display: none;"></i>



                </button>



            </div>



        </div>



    </div>





    {{-- =============================================================

         MOBILE NAVIGATION

    ============================================================== --}}



    <div

        x-show="mobileMenuOpen"

        x-transition:enter="transition ease-out duration-150"

        x-transition:enter-start="opacity-0 -translate-y-2"

        x-transition:enter-end="opacity-100 translate-y-0"

        x-transition:leave="transition ease-in duration-100"

        x-transition:leave-start="opacity-100 translate-y-0"

        x-transition:leave-end="opacity-0 -translate-y-2"

        style="display: none;"

        class="md:hidden border-t border-gray-100 bg-white px-4 py-4 shadow-lg">



        <div class="space-y-1">



            {{-- HOME --}}

            <a

                href="{{ url('/') }}"

                @click="mobileMenuOpen = false"

                class="block text-sm font-semibold py-2.5 {{ request()->is('/') ? 'text-emerald-700 font-bold' : 'text-gray-700 hover:text-emerald-700' }}">

                Home

            </a>





            {{-- BOOK CAB --}}

            <a

                href="{{ route('cabs.index') }}"

                @click="mobileMenuOpen = false"

                class="block text-sm font-semibold py-2.5 {{ request()->routeIs('cabs.\*') ? 'text-emerald-700 font-bold' : 'text-gray-700 hover:text-emerald-700' }}">

                Book Cab

            </a>





            {{-- TOUR PACKAGES --}}

            <a

                href="{{ route('tours.index') }}"

                @click="mobileMenuOpen = false"

                class="block text-sm font-semibold py-2.5 {{ request()->routeIs('tours.\*') ? 'text-emerald-700 font-bold' : 'text-gray-700 hover:text-emerald-700' }}">

                Tour Packages

            </a>





            {{-- BLOGS --}}

            <a

                href="{{ url('/blogs') }}"

                @click="mobileMenuOpen = false"

                class="block text-sm font-semibold py-2.5 {{ request()->is('blogs\*') ? 'text-emerald-700 font-bold' : 'text-gray-700 hover:text-emerald-700' }}">

                Blogs

            </a>





            {{-- CONTACT --}}

            <a

                href="{{ route('contact') }}"

                @click="mobileMenuOpen = false"

                class="block text-sm font-semibold py-2.5 {{ request()->routeIs('contact') ? 'text-emerald-700 font-bold' : 'text-gray-700 hover:text-emerald-700' }}">

                Contact Us

            </a>



        </div>





        {{-- =====================================================

             MOBILE CTA

        ====================================================== --}}



        <div class="pt-3 mt-2 grid grid-cols-2 gap-2 border-t border-gray-100">



            <a

                href="{{ route('contact') }}"

                @click="mobileMenuOpen = false"

                class="text-center px-3 py-2.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-xl flex items-center justify-center gap-1">



                <i

                    data-lucide="mail-question"

                    class="w-3.5 h-3.5"></i>



                <span>

                    Enquiry

                </span>



            </a>





            <a

                href="{{ route('cabs.index') }}"

                @click="mobileMenuOpen = false"

                class="text-center px-3 py-2.5 bg-gray-900 text-white text-xs font-semibold rounded-xl">

                Reserve Ride

            </a>



        </div>



    </div>



</header>