<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Logo &amp; Favicon | Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>

    @if(file_exists(public_path('build/manifest.json')))
        @vite([
            'resources/css/app.css',
            'resources/js/app.js'
        ])
    @endif

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        html { min-width: 0; overflow-x: hidden; }
        body {
            font-family: 'Inter', sans-serif;
            width: 100%; max-width: 100%; margin: 0;
        }

        .branding-main,
        .branding-main * {
            box-sizing: border-box;
        }

        .branding-main {
            width: 100%;
            min-width: 0;
        }

        .branding-content {
            width: 100%;
            max-width: 56rem;
            min-width: 0;
            margin-inline: auto;
        }

        .branding-card,
        .branding-section,
        .branding-content,
        .branding-main,
        .branding-header,
        form {
            min-width: 0;
            overflow-wrap: anywhere;
        }

        .branding-main input[type="text"],
        .branding-main input[type="url"],
        .branding-main input[type="file"] {
            display: block;
            width: 100%;
            max-width: 100%;
            min-width: 0;
        }

        .branding-main input[type="file"] {
            font-size: 12px;
        }

        .branding-main input[type="file"]::file-selector-button {
            max-width: 100%;
            margin-right: .75rem;
            margin-bottom: .25rem;
            padding: .4rem .65rem;
            border: 1px solid #cbd5e1;
            border-radius: .4rem;
            background: #f8fafc;
            color: #334155;
            cursor: pointer;
        }

        .branding-header {
            gap: 1rem;
        }

        .branding-preview {
            min-width: 0;
            max-width: 100%;
        }

        .branding-save {
            min-height: 2.75rem;
        }

        .branding-main input[type="url"] {
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .branding-preview img {
            max-width: 100%;
            height: auto;
        }

        @media (max-width: 640px) {
            .branding-header {
                min-height: 4rem;
                height: auto;
                padding: .75rem 1rem;
                align-items: flex-start;
                flex-wrap: wrap;
            }

            .branding-breadcrumb {
                flex: 1 1 100%;
                min-width: 0;
            }

            .branding-dashboard-link {
                max-width: 100%;
                white-space: normal;
                text-align: center;
            }

            .branding-main {
                padding: 1rem;
            }

            .branding-content { max-width: 100%; }

            .branding-card {
                padding: 1rem;
                border-radius: .75rem;
            }

            .branding-section {
                padding: 1rem;
            }

            .branding-save-row {
                display: flex;
                width: 100%;
            }

            .branding-save {
                width: 100%;
                justify-content: center;
                white-space: normal;
            }

            .branding-helper {
                overflow-wrap: anywhere;
                line-height: 1.5;
            }
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased flex min-h-screen overflow-x-hidden">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0 w-0 max-w-full">

        {{-- HEADER --}}
        <header class="branding-header min-h-16 bg-white border-b border-slate-200 px-6 py-3 flex items-center justify-between flex-wrap shrink-0 sticky top-0 z-30">

            <div class="branding-breadcrumb flex items-center gap-2 text-xs">
                <span class="text-slate-400">Admin</span>
                <span class="text-slate-300">/</span>
                <span class="font-bold text-slate-800">Logo &amp; Favicon</span>
            </div>

            <a
                href="{{ route('admin.dashboard') }}"
                class="branding-dashboard-link inline-flex items-center justify-center px-3 py-2 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                ← Back to Dashboard
            </a>

        </header>

        {{-- CONTENT --}}
        <main class="branding-main flex-1 min-w-0 w-full p-6 overflow-x-hidden">

            <div class="branding-content space-y-6">

                {{-- SUCCESS --}}
                @if(session('success'))
                    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs flex items-start gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" aria-hidden="true"></i>
                        <span class="min-w-0 break-words">{{ session('success') }}</span>
                    </div>
                @endif

                {{-- ERRORS --}}
                @if($errors->any())
                    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs">
                        <div class="font-bold mb-2">
                            Please fix the following errors:
                        </div>

                        <ul class="list-disc pl-5 space-y-1 break-words">
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

                    <div class="branding-card bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-7">

                        <div>
                            <h1 class="text-base font-extrabold text-slate-900">
                                Logo &amp; Favicon
                            </h1>

                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Manage the website logo and browser favicon.
                            </p>
                        </div>

                        {{-- LOGO --}}
                        <section class="branding-section border border-slate-200 rounded-xl p-5" aria-labelledby="logo-heading">

                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="image" class="w-4 h-4 text-blue-600 shrink-0" aria-hidden="true"></i>

                                <h2 id="logo-heading" class="text-sm font-extrabold text-slate-900">
                                    Website Logo
                                </h2>
                            </div>

                            @if(!empty($branding['site_logo']))
                                <div class="mb-5">
                                    <p class="text-[11px] font-semibold text-slate-500 mb-2">
                                        Current Logo
                                    </p>

                                    <div class="branding-preview w-full min-h-28 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-center p-4">
                                        <img
                                            src="{{ $branding['site_logo'] }}"
                                            alt="Current Website Logo"
                                            loading="lazy"
                                            class="block max-h-20 max-w-full object-contain">
                                    </div>
                                </div>
                            @endif

                            <div class="space-y-4">
                                <div>
                                    <label for="site_logo" class="block text-xs font-bold text-slate-700 mb-1.5">
                                        Logo URL
                                    </label>

                                    <input
                                        id="site_logo"
                                        type="url"
                                        name="site_logo"
                                        value="{{ old('site_logo', $branding['site_logo'] ?? '') }}"
                                        maxlength="2048"
                                        inputmode="url"
                                        placeholder="https://example.com/logo.png"
                                        class="w-full p-3 bg-white border @error('site_logo') border-red-400 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                </div>

                                <div>
                                    <label for="logo_file" class="block text-xs font-bold text-slate-700 mb-1.5">
                                        Upload Logo
                                    </label>

                                    <input
                                        id="logo_file"
                                        type="file"
                                        name="logo_file"
                                        accept=".svg,.webp,.png,.jpg,.jpeg,.gif,.avif,.ico,.bmp,image/*"
                                        class="w-full p-2.5 bg-white border @error('logo_file') border-red-400 @else border-slate-300 @enderror rounded-lg text-xs">

                                    <p class="branding-helper text-[11px] text-slate-400 mt-1">
                                        SVG, WEBP, PNG, JPG, GIF, AVIF, ICO or BMP.
                                    </p>
                                </div>
                            </div>

                        </section>

                        {{-- FAVICON --}}
                        <section class="branding-section border border-slate-200 rounded-xl p-5" aria-labelledby="favicon-heading">

                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="globe" class="w-4 h-4 text-blue-600 shrink-0" aria-hidden="true"></i>

                                <h2 id="favicon-heading" class="text-sm font-extrabold text-slate-900">
                                    Website Favicon
                                </h2>
                            </div>

                            @if(!empty($branding['site_favicon']))
                                <div class="mb-5">
                                    <p class="text-[11px] font-semibold text-slate-500 mb-2">
                                        Current Favicon
                                    </p>

                                    <div class="branding-preview w-24 h-24 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-center p-4">
                                        <img
                                            src="{{ $branding['site_favicon'] }}"
                                            alt="Current Favicon"
                                            loading="lazy"
                                            class="block max-w-full max-h-full object-contain">
                                    </div>
                                </div>
                            @endif

                            <div class="space-y-4">
                                <div>
                                    <label for="site_favicon" class="block text-xs font-bold text-slate-700 mb-1.5">
                                        Favicon URL
                                    </label>

                                    <input
                                        id="site_favicon"
                                        type="url"
                                        name="site_favicon"
                                        value="{{ old('site_favicon', $branding['site_favicon'] ?? '') }}"
                                        maxlength="2048"
                                        inputmode="url"
                                        placeholder="https://example.com/favicon.ico"
                                        class="w-full p-3 bg-white border @error('site_favicon') border-red-400 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                </div>

                                <div>
                                    <label for="favicon_file" class="block text-xs font-bold text-slate-700 mb-1.5">
                                        Upload Favicon
                                    </label>

                                    <input
                                        id="favicon_file"
                                        type="file"
                                        name="favicon_file"
                                        accept=".svg,.webp,.png,.jpg,.jpeg,.gif,.avif,.ico,.bmp,image/*"
                                        class="w-full p-2.5 bg-white border @error('favicon_file') border-red-400 @else border-slate-300 @enderror rounded-lg text-xs">

                                    <p class="branding-helper text-[11px] text-slate-400 mt-1">
                                        ICO, SVG, PNG, WEBP, JPG, GIF or AVIF.
                                    </p>
                                </div>
                            </div>

                        </section>

                        {{-- SAVE --}}
                        <div class="branding-save-row flex justify-end pt-1">
                            <button
                                type="submit"
                                class="branding-save inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-white font-semibold px-5 py-2.5 rounded-lg text-sm transition">
                                <i data-lucide="save" class="w-4 h-4 shrink-0" aria-hidden="true"></i>
                                <span>Save Logo &amp; Favicon</span>
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
                window.lucide.createIcons();
            }
        });
    </script>

</body>
</html>
