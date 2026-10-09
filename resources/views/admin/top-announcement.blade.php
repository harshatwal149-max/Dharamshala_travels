<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Top Announcement Bar | Admin</title>

    @if(\App\Models\Setting::get('site_favicon'))
        <link
            rel="icon"
            type="image/x-icon"
            href="{{ \App\Models\Setting::get('site_favicon') }}"
        >
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>

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

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>


<body class="bg-slate-100 text-slate-800 antialiased flex h-screen overflow-hidden">


    {{-- SIDEBAR --}}

    @include('admin.partials.sidebar')


    {{-- MAIN AREA --}}

    <div class="flex-1 flex flex-col overflow-y-auto min-w-0">


        {{-- HEADER --}}

        <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between shrink-0 sticky top-0 z-30">

            <div class="flex items-center gap-2 text-xs">

                <span class="text-slate-400">
                    Admin
                </span>

                <span class="text-slate-300">
                    /
                </span>

                <span class="font-bold text-slate-800">
                    Top Announcement Bar
                </span>

            </div>


            <a
                href="{{ route('admin.dashboard') }}"
                class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50"
            >
                ← Back to Dashboard
            </a>

        </header>


        {{-- CONTENT --}}

        <main class="flex-1 p-6 overflow-y-auto">

            <div class="max-w-4xl space-y-6">


                {{-- SUCCESS MESSAGE --}}

                @if(session('success'))

                    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs flex items-center gap-2">

                        <i
                            data-lucide="check-circle"
                            class="w-4 h-4 text-emerald-600"
                        ></i>

                        <span>
                            {{ session('success') }}
                        </span>

                    </div>

                @endif


                {{-- ERROR MESSAGE --}}

                @if($errors->any())

                    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs">

                        <div class="font-bold mb-2">
                            Please fix the following errors:
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


                {{-- FORM START --}}

                <form
                    action="{{ route('admin.top-announcement.update') }}"
                    method="POST"
                >

                    @csrf


                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-6">


                        {{-- TITLE --}}

                        <div>

                            <h1 class="text-base font-extrabold text-slate-900">
                                Top Announcement Bar
                            </h1>

                            <p class="text-xs text-slate-500 mt-1">
                                Manage the announcement text, phone number and location displayed in the website's top bar.
                            </p>

                        </div>


                        {{-- ANNOUNCEMENT TEXT --}}

                        <div>

                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Announcement Text
                            </label>


                            <div class="relative">

                                <i
                                    data-lucide="megaphone"
                                    class="absolute left-3 top-3.5 w-4 h-4 text-slate-400"
                                ></i>


                                <textarea
                                    name="top_bar_text"
                                    rows="3"
                                    maxlength="255"
                                    placeholder="Gaggal Airport (DHM) & Himachal Tour Chauffeur Network"
                                    class="w-full pl-10 pr-3 py-3 bg-white border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none"
                                >{{ old('top_bar_text', $announcement['top_bar_text'] ?? '') }}</textarea>

                            </div>


                            <p class="text-[11px] text-slate-400 mt-1">
                                Main message shown in the website's top announcement bar.
                            </p>

                        </div>

                                                {{-- PHONE NUMBER --}}

                        <div>

                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Phone Number
                            </label>


                            <div class="relative">

                                <i
                                    data-lucide="phone"
                                    class="absolute left-3 top-3 w-4 h-4 text-slate-400"
                                ></i>


                                <input
                                    type="text"
                                    name="top_bar_phone"
                                    value="{{ old('top_bar_phone', $announcement['top_bar_phone'] ?? '') }}"
                                    maxlength="50"
                                    placeholder="+91 98765 43210"
                                    class="w-full pl-10 pr-3 py-3 bg-white border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                >

                            </div>


                            <p class="text-[11px] text-slate-400 mt-1">
                                Phone number displayed on the right side of the top bar.
                            </p>

                        </div>


                        {{-- LOCATION --}}

                        <div>

                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Location
                            </label>


                            <div class="relative">

                                <i
                                    data-lucide="map-pin"
                                    class="absolute left-3 top-3 w-4 h-4 text-slate-400"
                                ></i>


                                <input
                                    type="text"
                                    name="top_bar_location"
                                    value="{{ old('top_bar_location', $announcement['top_bar_location'] ?? '') }}"
                                    maxlength="100"
                                    placeholder="Dharamshala, HP"
                                    class="w-full pl-10 pr-3 py-3 bg-white border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                >

                            </div>


                            <p class="text-[11px] text-slate-400 mt-1">
                                Location displayed beside the phone number.
                            </p>

                        </div>


                        {{-- PREVIEW --}}

                        <div>

                            <label class="block text-xs font-bold text-slate-700 mb-2">
                                Preview
                            </label>

                        </div>
                                                {{-- SAVE BUTTON --}}

                        <div class="pt-2 border-t border-slate-100 flex items-center justify-end">

                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-xs font-bold rounded-lg shadow-sm transition"
                            >

                                <i
                                    data-lucide="save"
                                    class="w-4 h-4"
                                ></i>

                                Save Announcement

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </main>

    </div>


    {{-- LUCIDE ICONS --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            if (window.lucide) {
                lucide.createIcons();
            }

        });
    </script>

</body>

</html>