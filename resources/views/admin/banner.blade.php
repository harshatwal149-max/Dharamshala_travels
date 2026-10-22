<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hero Banners | Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
            min-width: 320px;
            overflow-x: hidden;
        }

        [x-cloak] {
            display: none !important;
        }

        .banner-admin-main {
            flex: 1 1 0%;
            min-width: 0;
            width: 100%;
        }

        .banner-admin-header {
            min-height: 4rem;
            height: auto;
            gap: .75rem;
            flex-wrap: wrap;
            padding-top: .75rem;
            padding-bottom: .75rem;
        }

        .banner-admin-content {
            width: 100%;
            max-width: 100%;
            min-width: 0;
        }

        .banner-admin-content section,
        .banner-admin-content article,
        .banner-admin-content form,
        .banner-admin-content input,
        .banner-admin-content textarea,
        .banner-admin-content button {
            min-width: 0;
            max-width: 100%;
        }

        .banner-admin-content h1,
        .banner-admin-content h2,
        .banner-admin-content h3,
        .banner-admin-content p,
        .banner-admin-content label,
        .banner-admin-content span {
            overflow-wrap: anywhere;
        }

        .banner-card-image {
            display: block;
            width: 100%;
            height: 16rem;
            object-fit: cover;
        }

        .banner-admin-content input[type="file"] {
            width: 100%;
            max-width: 100%;
            overflow: hidden;
        }

        .banner-admin-content input[type="text"],
        .banner-admin-content input[type="number"],
        .banner-admin-content textarea {
            width: 100%;
            min-width: 0;
        }

        @media (max-width: 767px) {
            body {
                min-height: 100vh;
            }

            .banner-admin-header {
                align-items: flex-start;
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .banner-admin-header>a {
                width: 100%;
                justify-content: center;
                white-space: normal;
            }

            .banner-admin-content {
                padding: 1rem;
            }

            .banner-admin-content .banner-page-title {
                margin-bottom: 1.25rem;
            }

            .banner-admin-content .banner-section-heading {
                padding: 1rem;
            }

            .banner-admin-content .banner-add-form {
                padding: 1rem;
            }

            .banner-admin-content .banner-add-actions {
                justify-content: stretch;
            }

            .banner-admin-content .banner-add-actions button {
                width: 100%;
                justify-content: center;
            }

            .banner-admin-content .banner-card-details {
                padding: 1rem;
            }

            .banner-card-image {
                height: auto;
                max-height: 16rem;
                aspect-ratio: 16 / 9;
            }

            .banner-admin-content .banner-existing-heading {
                align-items: flex-start;
                flex-wrap: wrap;
                gap: .5rem;
            }
        }

        @media (max-width: 420px) {
            .banner-admin-header>a {
                width: 100%;
            }

            .banner-admin-content h1 {
                font-size: 1.25rem;
                line-height: 1.75rem;
            }

            .banner-admin-content .banner-title-row {
                align-items: flex-start;
            }

            .banner-admin-content .banner-card-details {
                padding: .875rem;
            }

            .banner-admin-content input[type="file"] {
                font-size: .75rem;
            }
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased flex min-h-screen">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    <main class="banner-admin-main flex-1 min-w-0">

        {{-- TOP HEADER --}}
        <header class="banner-admin-header h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between sticky top-0 z-30">

            <div>
                <div class="flex items-center gap-2 text-xs">
                    <span class="text-slate-400">Admin</span>
                    <span class="text-slate-300">/</span>
                    <span class="font-bold text-slate-800">Hero Banners</span>
                </div>
            </div>

            <a
                href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-300 bg-white text-sm font-semibold text-slate-700 hover:bg-slate-50">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                Dashboard
            </a>

        </header>


        {{-- CONTENT --}}
        <div class="banner-admin-content p-6 lg:p-8">

            {{-- PAGE TITLE --}}
            <div class="banner-page-title mb-8">

                <div class="banner-title-row flex items-center gap-3 mb-2">

                    <div class="w-11 h-11 rounded-xl bg-slate-900 text-white flex items-center justify-center">
                        <i data-lucide="images" class="w-5 h-5"></i>
                    </div>

                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">
                            Hero Banners
                        </h1>

                        <p class="text-sm text-slate-500">
                            Manage homepage slider images, titles and subtitles.
                        </p>
                    </div>

                </div>

            </div>


            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))

            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 flex items-center gap-3">

                <i data-lucide="circle-check" class="w-5 h-5 shrink-0"></i>

                <span>
                    {{ session('success') }}
                </span>

            </div>

            @endif


            {{-- VALIDATION ERRORS --}}
            @if($errors->any())

            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-700">

                <div class="font-bold mb-2">
                    Please fix the following:
                </div>

                <ul class="list-disc ml-5 space-y-1">

                    @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

            @endif


            {{-- ADD NEW BANNER --}}
            <section class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-8">

                <div class="banner-section-heading px-6 py-5 border-b border-slate-200">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i data-lucide="plus" class="w-5 h-5"></i>
                        </div>

                        <div>

                            <h2 class="font-bold text-slate-900">
                                Add New Banner
                            </h2>

                            <p class="text-xs text-slate-500">
                                Upload a new slide for the homepage hero section.
                            </p>

                        </div>

                    </div>

                </div>


                <form
                    action="{{ route('admin.banner.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="banner-add-form p-6">

                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        {{-- IMAGE --}}
                        <div class="lg:col-span-2">

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Banner Image
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="file"
                                name="image"
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                required
                                class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-800">

                            <p class="mt-2 text-xs text-slate-500">
                                JPG, JPEG, PNG or WEBP. Maximum 5MB.
                            </p>

                        </div>


                        {{-- TITLE --}}
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Banner Title
                            </label>

                            <input
                                type="text"
                                name="title"
                                maxlength="200"
                                placeholder="Example: Explore Dharamshala"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-100">

                        </div>


                        {{-- SUBTITLE --}}
                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Banner Subtitle
                            </label>

                            <input
                                type="text"
                                name="subtitle"
                                maxlength="500"
                                placeholder="Example: Comfortable rides across Himachal Pradesh"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-100">

                        </div>

                    </div>


                    <div class="banner-add-actions mt-6 flex justify-end">

                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-3 text-sm font-bold text-white hover:bg-slate-800">

                            <i data-lucide="upload" class="w-4 h-4"></i>

                            Add Banner

                        </button>

                    </div>

                </form>

            </section>


            {{-- EXISTING BANNERS --}}
            <section>

                <div class="banner-existing-heading flex items-center justify-between mb-5">

                    <div>

                        <h2 class="text-lg font-bold text-slate-900">
                            Existing Banners
                        </h2>

                        <p class="text-sm text-slate-500">
                            {{ $banners->count() }} banner(s) available.
                        </p>

                    </div>

                </div>


                @if($banners->count())

                <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

                    @foreach($banners as $banner)

                    <article class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                        {{-- IMAGE --}}
                        <div class="relative bg-slate-900">

                            <img
                                src="{{ \App\Support\Media::url($banner->image) }}"
                                alt="{{ $banner->title ?: 'Hero Banner' }}"
                                class="banner-card-image w-full h-64 object-cover">

                            {{-- STATUS --}}
                            <div class="absolute top-4 right-4">

                                @if($banner->is_active)

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500 px-3 py-1.5 text-xs font-bold text-white shadow">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                    Active
                                </span>

                                @else

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-700 px-3 py-1.5 text-xs font-bold text-white shadow">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                    Inactive
                                </span>

                                @endif

                            </div>

                        </div>


                        {{-- DETAILS --}}
                        <div class="banner-card-details p-6">

                            <div class="mb-5">

                                <h3 class="text-lg font-bold text-slate-900">
                                    {{ $banner->title ?: 'Untitled Banner' }}
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    {{ $banner->subtitle ?: 'No subtitle added.' }}
                                </p>

                            </div>


                            {{-- EDIT FORM --}}
                            <form
                                action="{{ route('admin.banner.update', $banner) }}"
                                method="POST"
                                enctype="multipart/form-data"
                                class="space-y-5">

                                @csrf
                                @method('PUT')


                                {{-- NEW IMAGE --}}
                                <div>

                                    <label class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-2">
                                        Replace Image
                                    </label>

                                    <input
                                        type="file"
                                        name="image"
                                        accept="image/jpeg,image/png,image/jpg,image/webp"
                                        class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-1.5 file:text-xs file:font-semibold">

                                </div>


                                {{-- TITLE --}}
                                <div>

                                    <label class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-2">
                                        Title
                                    </label>

                                    <input
                                        type="text"
                                        name="title"
                                        value="{{ $banner->title }}"
                                        maxlength="200"
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-100">

                                </div>


                                {{-- SUBTITLE --}}
                                <div>

                                    <label class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-2">
                                        Subtitle
                                    </label>

                                    <textarea
                                        name="subtitle"
                                        rows="3"
                                        maxlength="500"
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-100">{{ $banner->subtitle }}</textarea>

                                </div>


                                {{-- SORT ORDER --}}
                                <div>

                                    <label class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-2">
                                        Slide Order
                                    </label>

                                    <input
                                        type="number"
                                        name="sort_order"
                                        min="0"
                                        value="{{ $banner->sort_order }}"
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-100">

                                    <p class="mt-1 text-xs text-slate-400">
                                        Lower number appears first.
                                    </p>

                                </div>


                                {{-- ACTIVE --}}
                                <label class="flex items-center gap-3 cursor-pointer">

                                    <input
                                        type="hidden"
                                        name="is_active"
                                        value="0">

                                    <input
                                        type="checkbox"
                                        name="is_active"
                                        value="1"
                                        @checked($banner->is_active)
                                    class="w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-400"
                                    >

                                    <span class="text-sm font-semibold text-slate-700">
                                        Show this banner on homepage
                                    </span>

                                </label>


                                {{-- UPDATE --}}
                                <button
                                    type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-3 text-sm font-bold text-white hover:bg-blue-700">

                                    <i data-lucide="save" class="w-4 h-4"></i>

                                    Save Changes

                                </button>

                            </form>


                            {{-- DELETE --}}
                            <form
                                action="{{ route('admin.banner.destroy', $banner) }}"
                                method="POST"
                                class="mt-3"
                                onsubmit="return confirm('Delete this hero banner? This action cannot be undone.');">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-red-600 hover:bg-red-100">

                                    <i data-lucide="trash-2" class="w-4 h-4"></i>

                                    Delete Banner

                                </button>

                            </form>

                        </div>

                    </article>

                    @endforeach

                </div>

                @else

                {{-- EMPTY STATE --}}
                <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-12 text-center">

                    <div class="mx-auto w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">

                        <i data-lucide="images" class="w-7 h-7 text-slate-400"></i>

                    </div>

                    <h3 class="text-lg font-bold text-slate-900">
                        No Hero Banners
                    </h3>

                    <p class="mt-2 text-sm text-slate-500">
                        Add your first banner above to start the homepage slider.
                    </p>

                </div>

                @endif

            </section>

        </div>

    </main>


    <script>
        lucide.createIcons();
    </script>

</body>

</html>