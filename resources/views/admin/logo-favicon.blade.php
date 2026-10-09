<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Logo & Favicon | Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>

    @if(file_exists(public_path('build/manifest.json')))
        @vite([
            'resources/css/app.css',
            'resources/js/app.js'
        ])
    @endif

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased flex h-screen overflow-hidden">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col overflow-y-auto min-w-0">

        {{-- HEADER --}}
        <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between shrink-0 sticky top-0 z-30">

            <div class="flex items-center gap-2 text-xs">
                <span class="text-slate-400">Admin</span>
                <span class="text-slate-300">/</span>
                <span class="font-bold text-slate-800">Logo & Favicon</span>
            </div>

            <a
                href="{{ route('admin.dashboard') }}"
                class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50">
                ← Back to Dashboard
            </a>

        </header>

        {{-- CONTENT --}}
        <main class="flex-1 p-6 overflow-y-auto">

            <div class="max-w-4xl space-y-6">

                {{-- SUCCESS --}}
                @if(session('success'))
                    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                {{-- ERRORS --}}
                @if($errors->any())
                    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs">

                        <div class="font-bold mb-2">
                            Please fix the following errors:
                        </div>

                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>
                @endif

                {{-- MAIN CARD --}}
                <form
                    action="{{ route('admin.logo-favicon.update') }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-7">

                        <div>
                            <h1 class="text-base font-extrabold text-slate-900">
                                Logo & Favicon
                            </h1>

                            <p class="text-xs text-slate-500 mt-1">
                                Manage the website logo and browser favicon.
                            </p>
                        </div>

                        {{-- LOGO --}}
                        <section class="border border-slate-200 rounded-xl p-5">

                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="image" class="w-4 h-4 text-blue-600"></i>

                                <h2 class="text-sm font-extrabold text-slate-900">
                                    Website Logo
                                </h2>
                            </div>

                            @if(!empty($branding['site_logo']))
                                <div class="mb-5">

                                    <p class="text-[11px] font-semibold text-slate-500 mb-2">
                                        Current Logo
                                    </p>

                                    <div class="w-full h-28 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-center p-4">
                                        <img
                                            src="{{ $branding['site_logo'] }}"
                                            alt="Current Website Logo"
                                            class="max-h-20 max-w-full object-contain">
                                    </div>

                                </div>
                            @endif

                            <div class="space-y-4">

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                        Logo URL
                                    </label>

                                    <input
                                        type="url"
                                        name="site_logo"
                                        value="{{ old('site_logo', $branding['site_logo'] ?? '') }}"
                                        placeholder="https://example.com/logo.png"
                                        class="w-full p-3 bg-white border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                        Upload Logo
                                    </label>

                                    <input
                                        type="file"
                                        name="logo_file"
                                        accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml"
                                        class="w-full p-2.5 bg-white border border-slate-300 rounded-lg text-xs">

                                    <p class="text-[11px] text-slate-400 mt-1">
                                        JPG, PNG, WEBP or SVG — maximum 2 MB.
                                    </p>
                                </div>

                            </div>

                        </section>

                        {{-- FAVICON --}}
                        <section class="border border-slate-200 rounded-xl p-5">

                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="globe" class="w-4 h-4 text-blue-600"></i>

                                <h2 class="text-sm font-extrabold text-slate-900">
                                    Website Favicon
                                </h2>
                            </div>

                            @if(!empty($branding['site_favicon']))
                                <div class="mb-5">

                                    <p class="text-[11px] font-semibold text-slate-500 mb-2">
                                        Current Favicon
                                    </p>

                                    <div class="w-24 h-24 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-center p-4">
                                        <img
                                            src="{{ $branding['site_favicon'] }}"
                                            alt="Current Favicon"
                                            class="max-w-full max-h-full object-contain">
                                    </div>

                                </div>
                            @endif

                            <div class="space-y-4">

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                        Favicon URL
                                    </label>

                                    <input
                                        type="url"
                                        name="site_favicon"
                                        value="{{ old('site_favicon', $branding['site_favicon'] ?? '') }}"
                                        placeholder="https://example.com/favicon.ico"
                                        class="w-full p-3 bg-white border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                        Upload Favicon
                                    </label>

                                    <input
                                        type="file"
                                        name="favicon_file"
                                        accept="image/jpeg,image/png,image/jpg,image/webp,image/x-icon,image/svg+xml"
                                        class="w-full p-2.5 bg-white border border-slate-300 rounded-lg text-xs">

                                    <p class="text-[11px] text-slate-400 mt-1">
                                        ICO, PNG, JPG, WEBP or SVG — maximum 1 MB.
                                    </p>
                                </div>

                            </div>

                        </section>

                        {{-- SAVE --}}
                        <div class="flex justify-end pt-1">

                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg text-xs transition">

                                <i data-lucide="save" class="w-4 h-4"></i>

                                Save Logo & Favicon
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>

</body>
</html>
