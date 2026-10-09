<!DOCTYPE html>

<html lang="en">



<head>



       
    <meta charset="UTF-8">



       
    <meta name="viewport" content="width=device-width, initial-scale=1.0">



        <title>

                Basic Settings - {{ \App\Models\Setting::get('site_title', 'Dharamshala Travels') }}

            </title>



        @if(\App\Models\Setting::get('site_favicon'))

           
    <link

                    rel="icon"

                    type="image/x-icon"

                    href="{{ \App\Models\Setting::get('site_favicon') }}"

               >

        @endif



       
    <link rel="preconnect" href="https://fonts.googleapis.com">



       
    <link

                rel="preconnect"

                href="https://fonts.gstatic.com"

                crossorigin

           >



       
    <link

                href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"

                rel="stylesheet"

           >



        @vite(['resources/css/app.css', 'resources/js/app.js'])



        <script src="https://unpkg.com/lucide@latest"></script>



        <script

                defer

                src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js">
    </script>



        <style>
        body {

            font-family: 'Inter', sans-serif;

        }
    </style>



</head>



<body class="bg-slate-100 text-slate-800 antialiased flex h-screen overflow-hidden">



        @include('admin.partials.sidebar')



        <div class="flex-1 flex flex-col overflow-y-auto min-w-0">



                <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between shrink-0 sticky top-0 z-30">



                        <div class="flex items-center gap-2 text-xs">



                                <span class="text-slate-400">

                                        Admin

                                    </span>



                                <span class="text-slate-300">

                                        /

                                    </span>



                                <span class="font-bold text-slate-800">

                                        Basic Settings

                                    </span>



                            </div>



                        <a

                                href="{{ route('admin.dashboard') }}"

                                class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors"

                           >

                                ← Back to Dashboard

                            </a>



                    </header>



                <main class="p-6 max-w-5xl space-y-6">



                        @if(session('success'))



                            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs flex items-center gap-2">



                                    <i

                                            data-lucide="check-circle"

                                            class="w-4 h-4 text-emerald-600">

                                        </i>



                                    <span>

                                            {{ session('success') }}

                                        </span>



                                </div>



                        @endif





                        @if($errors->any())



                            <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-xs">



                                    <div class="font-bold mb-2">

                                            Please fix the following:

                                        </div>



                                    <ul class="list-disc pl-5 space-y-1">



                                            @foreach($errors->all() as $error)



                                                <li>

                                                        {{ $error }}

                                                    </li>



                                            @endforeach



                                        </ul>



                                </div>



                        @endif





                        <form

                                action="{{ route('admin.settings.update') }}"

                                method="POST"

                                class="space-y-6 text-xs"

                           >



                                @csrf





                                {{-- BUSINESS INFORMATION --}}

                                <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm">



                                        <h3 class="text-sm font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3">

                                                Business Information

                                            </h3>



                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">



                                                <div>



                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                Company Title

                                                            </label>



                                                        <input

                                                                type="text"

                                                                name="site_title"

                                                                value="{{ old('site_title', \App\Models\Setting::get('site_title', '')) }}"

                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                           >



                                                    </div>





                                                <div>



                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                Phone Number

                                                            </label>



                                                        <input

                                                                type="text"

                                                                name="site_phone"

                                                                value="{{ old('site_phone', \App\Models\Setting::get('site_phone', '+91 98765 43210')) }}"

                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                           >



                                                    </div>





                                                <div>



                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                Official Email

                                                            </label>



                                                        <input

                                                                type="email"

                                                                name="site_email"

                                                                value="{{ old('site_email', \App\Models\Setting::get('site_email', 'info@dharamshalatravels.com')) }}"

                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                           >



                                                    </div>





                                                <div>



                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                Office Address

                                                            </label>



                                                        <input

                                                                type="text"

                                                                name="site_address"

                                                                value="{{ old('site_address', \App\Models\Setting::get('site_address', 'Main Square, McLeodganj')) }}"

                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                           >



                                                    </div>



                                            </div>



                                    </div>





                                {{-- FOOTER SETTINGS --}}

                                <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm">



                                        <div class="flex items-center gap-2 mb-1">



                                                <i data-lucide="panel-bottom" class="w-5 h-5 text-slate-700"></i>



                                                <h3 class="text-sm font-bold text-slate-900">

                                                        Footer Settings

                                                    </h3>



                                            </div>



                                        <p class="text-[11px] text-slate-500 mb-5">

                                                Manage the footer description, social media links, WhatsApp and Google Maps link.

                                            </p>





                                        <div class="space-y-4">



                                                <div>



                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                Footer Description

                                                            </label>



                                                        <textarea

                                                                name="footer_description"

                                                                rows="3"

                                                                placeholder="Write a short description about your travel business..."

                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900 resize-none"

                                                           >{{ old('footer_description', \App\Models\Setting::get('footer_description', 'Reliable cab services, airport transfers and Himachal tour packages from Dharamshala. Travel comfortably with experienced local drivers.')) }}</textarea>



                                                    </div>





                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">



                                                        <div>



                                                                <label class="block font-bold text-slate-700 mb-1">

                                                                        Facebook URL

                                                                    </label>



                                                                <input

                                                                        type="url"

                                                                        name="footer_facebook"

                                                                        value="{{ old('footer_facebook', \App\Models\Setting::get('footer_facebook', '')) }}"

                                                                        placeholder="https://facebook.com/yourpage"

                                                                        class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                   >



                                                            </div>





                                                        <div>



                                                                <label class="block font-bold text-slate-700 mb-1">

                                                                        Instagram URL

                                                                    </label>



                                                                <input

                                                                        type="url"

                                                                        name="footer_instagram"

                                                                        value="{{ old('footer_instagram', \App\Models\Setting::get('footer_instagram', '')) }}"

                                                                        placeholder="https://instagram.com/yourpage"

                                                                        class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                   >



                                                            </div>





                                                        <div>



                                                                <label class="block font-bold text-slate-700 mb-1">

                                                                        YouTube URL

                                                                    </label>



                                                                <input

                                                                        type="url"

                                                                        name="footer_youtube"

                                                                        value="{{ old('footer_youtube', \App\Models\Setting::get('footer_youtube', '')) }}"

                                                                        placeholder="https://youtube.com/@yourchannel"

                                                                        class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                   >



                                                            </div>





                                                        <div>



                                                                <label class="block font-bold text-slate-700 mb-1">

                                                                        WhatsApp Number

                                                                    </label>



                                                                <input

                                                                        type="text"

                                                                        name="footer_whatsapp"

                                                                        value="{{ old('footer_whatsapp', \App\Models\Setting::get('footer_whatsapp', '')) }}"

                                                                        placeholder="+91 98765 43210"

                                                                        class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                   >



                                                            </div>



                                                    </div>





                                                <div>



                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                Google Maps URL

                                                            </label>



                                                        <input

                                                                type="url"

                                                                name="footer_map_url"

                                                                value="{{ old('footer_map_url', \App\Models\Setting::get('footer_map_url', '')) }}"

                                                                placeholder="https://maps.google.com/..."

                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                           >



                                                    </div>



                                            </div>



                                    </div>



                                                {{-- SEO --}}

                                <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm">



                                        <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">



                                                <div>



                                                        <h3 class="text-sm font-bold text-slate-900">

                                                                SEO & Metadata

                                                            </h3>



                                                        <p class="text-[11px] text-slate-500 mt-1">

                                                                Manage search engine, social media and structured data settings.

                                                            </p>



                                                    </div>



                                                <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold">

                                                        SEO

                                                    </span>



                                            </div>





                                        <div class="space-y-6">





                                                {{-- BASIC SEO --}}

                                                <div>



                                                        <h4 class="text-xs font-bold text-slate-900 mb-3">

                                                                Basic SEO

                                                            </h4>



                                                        <div class="space-y-4">



                                                                {{-- Meta Title --}}

                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Meta Title

                                                                            </label>



                                                                        <input

                                                                                type="text"

                                                                                name="meta_title"

                                                                                value="{{ old('meta_title', \App\Models\Setting::get('meta_title', 'Dharamshala Travels | Verified Cabs & Tours')) }}"

                                                                                maxlength="255"

                                                                                placeholder="Dharamshala Travels | Verified Cabs & Tours"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                           >



                                                                    </div>





                                                                {{-- Meta Description --}}

                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Meta Description

                                                                            </label>



                                                                        <textarea

                                                                                name="meta_description"

                                                                                rows="3"

                                                                                maxlength="160"

                                                                                placeholder="Book verified cabs and tour packages in Dharamshala..."

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900 resize-none"

                                                                           >{{ old('meta_description', \App\Models\Setting::get('meta_description', 'Book verified cabs and tour packages in Kangra Valley.')) }}</textarea>



                                                                    </div>





                                                                {{-- Meta Keywords --}}

                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Meta Keywords

                                                                            </label>



                                                                        <textarea

                                                                                name="meta_keywords"

                                                                                rows="2"

                                                                                maxlength="500"

                                                                                placeholder="dharamshala taxi, dharamshala tours, himachal tour packages"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900 resize-none"

                                                                           >{{ old('meta_keywords', \App\Models\Setting::get('meta_keywords', 'taxi in dharamshala, gaggal airport cab, mcleodganj taxi booking, himachal tours')) }}</textarea>



                                                                    </div>





                                                                {{-- Robots --}}

                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Search Engine Robots

                                                                            </label>



                                                                        <select

                                                                                name="meta_robots"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                           >



                                                                                <option

                                                                                        value="index,follow"

                                                                                        {{ old('meta_robots', \App\Models\Setting::get('meta_robots', 'index,follow')) == 'index,follow' ? 'selected' : '' }}

                                                                                   >

                                                                                        Index, Follow

                                                                                    </option>



                                                                                <option

                                                                                        value="index,nofollow"

                                                                                        {{ old('meta_robots', \App\Models\Setting::get('meta_robots', 'index,follow')) == 'index,nofollow' ? 'selected' : '' }}

                                                                                   >

                                                                                        Index, No Follow

                                                                                    </option>



                                                                                <option

                                                                                        value="noindex,follow"

                                                                                        {{ old('meta_robots', \App\Models\Setting::get('meta_robots', 'index,follow')) == 'noindex,follow' ? 'selected' : '' }}

                                                                                   >

                                                                                        No Index, Follow

                                                                                    </option>



                                                                                <option

                                                                                        value="noindex,nofollow"

                                                                                        {{ old('meta_robots', \App\Models\Setting::get('meta_robots', 'index,follow')) == 'noindex,nofollow' ? 'selected' : '' }}

                                                                                   >

                                                                                        No Index, No Follow

                                                                                    </option>



                                                                            </select>



                                                                    </div>



                                                            </div>



                                                    </div>





                                                {{-- OPEN GRAPH --}}

                                                <div class="border-t border-slate-100 pt-5">



                                                        <h4 class="text-xs font-bold text-slate-900 mb-3">

                                                                Open Graph / Facebook

                                                            </h4>



                                                        <div class="space-y-4">



                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Open Graph Title

                                                                            </label>



                                                                        <input

                                                                                type="text"

                                                                                name="og_title"

                                                                                value="{{ old('og_title', \App\Models\Setting::get('og_title', '')) }}"

                                                                                placeholder="Dharamshala Travels"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                           >



                                                                    </div>





                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Open Graph Description

                                                                            </label>



                                                                        <textarea

                                                                                name="og_description"

                                                                                rows="3"

                                                                                maxlength="160"

                                                                                placeholder="Description shown when your website is shared on Facebook..."

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900 resize-none"

                                                                           >{{ old('og_description', \App\Models\Setting::get('og_description', '')) }}</textarea>



                                                                    </div>





                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Open Graph Image URL

                                                                            </label>



                                                                        <input

                                                                                type="url"

                                                                                name="og_image"

                                                                                value="{{ old('og_image', \App\Models\Setting::get('og_image', '')) }}"

                                                                                placeholder="https://example.com/og-image.jpg"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                           >



                                                                    </div>



                                                            </div>



                                                    </div>





                                                {{-- TWITTER --}}

                                                <div class="border-t border-slate-100 pt-5">



                                                        <h4 class="text-xs font-bold text-slate-900 mb-3">

                                                                Twitter / X

                                                            </h4>



                                                        <div class="space-y-4">



                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Twitter Card

                                                                            </label>



                                                                        <select

                                                                                name="twitter_card"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                           >



                                                                                <option

                                                                                        value="summary_large_image"

                                                                                        {{ old('twitter_card', \App\Models\Setting::get('twitter_card', 'summary_large_image')) == 'summary_large_image' ? 'selected' : '' }}

                                                                                   >

                                                                                        Summary Large Image

                                                                                    </option>



                                                                                <option

                                                                                        value="summary"

                                                                                        {{ old('twitter_card', \App\Models\Setting::get('twitter_card', 'summary_large_image')) == 'summary' ? 'selected' : '' }}

                                                                                   >

                                                                                        Summary

                                                                                    </option>



                                                                            </select>



                                                                    </div>





                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Twitter Title

                                                                            </label>



                                                                        <input

                                                                                type="text"

                                                                                name="twitter_title"

                                                                                value="{{ old('twitter_title', \App\Models\Setting::get('twitter_title', '')) }}"

                                                                                placeholder="Dharamshala Travels"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                           >



                                                                    </div>





                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Twitter Description

                                                                            </label>



                                                                        <textarea

                                                                                name="twitter_description"

                                                                                rows="3"

                                                                                maxlength="160"

                                                                                placeholder="Travel across Himachal with Dharamshala Travels"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900 resize-none"

                                                                           >{{ old('twitter_description', \App\Models\Setting::get('twitter_description', '')) }}</textarea>



                                                                    </div>





                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Twitter Image URL

                                                                            </label>



                                                                        <input

                                                                                type="url"

                                                                                name="twitter_image"

                                                                                value="{{ old('twitter_image', \App\Models\Setting::get('twitter_image', '')) }}"

                                                                                placeholder="https://example.com/twitter-image.jpg"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                           >



                                                                    </div>



                                                            </div>



                                                    </div>



                                                                        {{-- LOCAL BUSINESS SEO --}}

                                                <div class="border-t border-slate-100 pt-5">



                                                        <h4 class="text-xs font-bold text-slate-900 mb-3">

                                                                Local Business SEO

                                                            </h4>



                                                        <div class="space-y-4">



                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Business Name

                                                                            </label>



                                                                        <input

                                                                                type="text"

                                                                                name="seo_business_name"

                                                                                value="{{ old('seo_business_name', \App\Models\Setting::get('seo_business_name', 'Dharamshala Travels')) }}"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                           >



                                                                    </div>





                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Business Logo URL

                                                                            </label>



                                                                        <input

                                                                                type="url"

                                                                                name="seo_business_logo"

                                                                                value="{{ old('seo_business_logo', \App\Models\Setting::get('seo_business_logo', '')) }}"

                                                                                placeholder="https://example.com/logo.png"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                           >



                                                                    </div>





                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Business Phone

                                                                            </label>



                                                                        <input

                                                                                type="text"

                                                                                name="seo_business_phone"

                                                                                value="{{ old('seo_business_phone', \App\Models\Setting::get('seo_business_phone', '+91 98765 43210')) }}"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                           >



                                                                    </div>





                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Business Email

                                                                            </label>



                                                                        <input

                                                                                type="email"

                                                                                name="seo_business_email"

                                                                                value="{{ old('seo_business_email', \App\Models\Setting::get('seo_business_email', 'info@dharamshalatravels.com')) }}"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                           >



                                                                    </div>





                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Business Address

                                                                            </label>



                                                                        <input

                                                                                type="text"

                                                                                name="seo_business_address"

                                                                                value="{{ old('seo_business_address', \App\Models\Setting::get('seo_business_address', 'Dharamshala, Himachal Pradesh, India')) }}"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                           >



                                                                    </div>





                                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">



                                                                        <div>



                                                                                <label class="block font-bold text-slate-700 mb-1">

                                                                                        Latitude

                                                                                    </label>



                                                                                <input

                                                                                        type="text"

                                                                                        name="seo_latitude"

                                                                                        value="{{ old('seo_latitude', \App\Models\Setting::get('seo_latitude', '')) }}"

                                                                                        placeholder="32.2190"

                                                                                        class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                                   >



                                                                            </div>





                                                                        <div>



                                                                                <label class="block font-bold text-slate-700 mb-1">

                                                                                        Longitude

                                                                                    </label>



                                                                                <input

                                                                                        type="text"

                                                                                        name="seo_longitude"

                                                                                        value="{{ old('seo_longitude', \App\Models\Setting::get('seo_longitude', '')) }}"

                                                                                        placeholder="76.3234"

                                                                                        class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                                   >



                                                                            </div>



                                                                    </div>





                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Opening Hours

                                                                            </label>



                                                                        <input

                                                                                type="text"

                                                                                name="seo_opening_hours"

                                                                                value="{{ old('seo_opening_hours', \App\Models\Setting::get('seo_opening_hours', 'Mo-Su 06:00-23:00')) }}"

                                                                                placeholder="Mo-Su 06:00-23:00"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                           >



                                                                    </div>





                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Price Range

                                                                            </label>



                                                                        <input

                                                                                type="text"

                                                                                name="seo_price_range"

                                                                                value="{{ old('seo_price_range', \App\Models\Setting::get('seo_price_range', '₹₹')) }}"

                                                                                placeholder="₹₹"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                           >



                                                                    </div>





                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Service Areas

                                                                            </label>



                                                                        <textarea

                                                                                name="seo_service_areas"

                                                                                rows="3"

                                                                                placeholder="Dharamshala, McLeodganj, Kangra, Himachal Pradesh"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900 resize-none"

                                                                           >{{ old('seo_service_areas', \App\Models\Setting::get('seo_service_areas', 'Dharamshala, McLeodganj, Kangra, Himachal Pradesh')) }}</textarea>



                                                                    </div>



                                                            </div>



                                                    </div>





                                                {{-- STRUCTURED DATA --}}

                                                <div class="border-t border-slate-100 pt-5">



                                                        <h4 class="text-xs font-bold text-slate-900 mb-3">

                                                                Structured Data / Schema

                                                            </h4>



                                                        <input

                                                                type="hidden"

                                                                name="seo_schema_enabled"

                                                                value="0"

                                                           >



                                                        <label class="flex items-center gap-3 cursor-pointer">



                                                                <input

                                                                        type="checkbox"

                                                                        name="seo_schema_enabled"

                                                                        value="1"

                                                                        {{ old('seo_schema_enabled', \App\Models\Setting::get('seo_schema_enabled', '1')) == '1' ? 'checked' : '' }}

                                                                        class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"

                                                                   >



                                                                <span class="font-semibold text-slate-700">

                                                                        Enable Schema / Structured Data

                                                                    </span>



                                                            </label>



                                                    </div>





                                                {{-- GOOGLE --}}

                                                <div class="border-t border-slate-100 pt-5">



                                                        <h4 class="text-xs font-bold text-slate-900 mb-3">

                                                                Google SEO Tools

                                                            </h4>



                                                        <div class="space-y-4">



                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Google Search Console Verification

                                                                            </label>



                                                                        <input

                                                                                type="text"

                                                                                name="google_site_verification"

                                                                                value="{{ old('google_site_verification', \App\Models\Setting::get('google_site_verification', '')) }}"

                                                                                placeholder="Google verification code"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                           >



                                                                    </div>





                                                                <div>



                                                                        <label class="block font-bold text-slate-700 mb-1">

                                                                                Google Analytics ID

                                                                            </label>



                                                                        <input

                                                                                type="text"

                                                                                name="google_analytics_id"

                                                                                value="{{ old('google_analytics_id', \App\Models\Setting::get('google_analytics_id', '')) }}"

                                                                                placeholder="G-XXXXXXXXXX"

                                                                                class="w-full p-2.5 border border-slate-300 rounded-lg outline-none focus:ring-1 focus:ring-slate-900"

                                                                           >



                                                                    </div>



                                                            </div>



                                                    </div>





                                            </div>



                                    </div>





                                {{-- SAVE --}}

                                <div class="flex justify-end pb-6">



                                        <button

                                                type="submit"

                                                class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold px-6 py-2.5 rounded-lg transition"

                                           >



                                                <i

                                                        data-lucide="save"

                                                        class="w-4 h-4">

                                                    </i>



                                                Save Settings



                                            </button>



                                    </div>





                            </form>



                    </main>



            </div>





        <script>
        document.addEventListener('DOMContentLoaded', function() {



            if (typeof lucide !== 'undefined') {

                lucide.createIcons();

            }



        });
    </script>



</body>



</html>