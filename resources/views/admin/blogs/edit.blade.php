<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Blog - {{ \App\Models\Setting::get('site_title', 'Dharamshala Travels') }}</title>

    <link rel="icon"
          href="{{ \App\Models\Setting::get('favicon') ? asset('storage/' . \App\Models\Setting::get('favicon')) : asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <script src="https://unpkg.com/lucide@latest"></script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
            defer></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    @include('admin.partials.sidebar')


    {{-- Main Area --}}
    <div class="flex-1 flex flex-col overflow-y-auto min-w-0">

        {{-- Header --}}
        <header
            class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between shrink-0 sticky top-0 z-30">

            <div class="flex items-center gap-4">

                <a href="{{ route('admin.blogs.index') }}"
                   class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                          border border-slate-200 text-slate-600
                          hover:bg-slate-50 hover:text-slate-900 transition">

                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>

                <div>
                    <div class="flex items-center gap-2 text-xs text-slate-500 mb-0.5">
                        <span>Admin</span>
                        <i data-lucide="chevron-right" class="w-3 h-3"></i>
                        <span>Blogs</span>
                        <i data-lucide="chevron-right" class="w-3 h-3"></i>
                        <span class="text-slate-700">Edit</span>
                    </div>

                    <h1 class="text-lg font-semibold text-slate-900">
                        Edit Blog
                    </h1>
                </div>

            </div>


            <div class="flex items-center gap-3">

                <a href="{{ route('admin.blogs.index') }}"
                   class="hidden sm:inline-flex items-center gap-2 px-4 py-2
                          text-sm font-medium text-slate-600
                          border border-slate-200 rounded-lg
                          hover:bg-slate-50 transition">

                    <i data-lucide="files" class="w-4 h-4"></i>

                    All Blogs
                </a>

                <a href="{{ route('home') }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2
                          text-sm font-medium text-slate-600
                          border border-slate-200 rounded-lg
                          hover:bg-slate-50 transition">

                    <i data-lucide="external-link" class="w-4 h-4"></i>

                    Website
                </a>

            </div>

        </header>


        {{-- Page Content --}}
        <main class="p-6 space-y-6">

            {{-- Validation Errors --}}
            @if ($errors->any())

                <div class="bg-red-50 border border-red-200 rounded-xl p-4">

                    <div class="flex items-start gap-3">

                        <div class="w-8 h-8 rounded-lg bg-red-100
                                    flex items-center justify-center shrink-0">

                            <i data-lucide="alert-circle"
                               class="w-5 h-5 text-red-600"></i>

                        </div>

                        <div>

                            <h3 class="font-semibold text-red-800 text-sm">
                                Please fix the following errors:
                            </h3>

                            <ul class="mt-2 list-disc list-inside text-sm text-red-700 space-y-1">

                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif


            {{-- Intro --}}
            <div>

                <h2 class="text-2xl font-bold text-slate-900">
                    Edit Blog
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Update your travel article
                </p>

            </div>


            {{-- Form --}}
            <form
                action="{{ route('admin.blogs.update', $blog) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')


                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">


                    {{-- LEFT SIDE --}}
                    <div class="xl:col-span-2 space-y-6">


                        {{-- Blog Information --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm">

                            <div class="px-6 py-5 border-b border-slate-200">

                                <div class="flex items-center gap-3">

                                    <div class="w-10 h-10 rounded-lg bg-blue-50
                                                flex items-center justify-center">

                                        <i data-lucide="file-text"
                                           class="w-5 h-5 text-blue-600"></i>

                                    </div>

                                    <div>

                                        <h3 class="font-semibold text-slate-900">
                                            Blog Information
                                        </h3>

                                        <p class="text-xs text-slate-500 mt-0.5">
                                            Update the main content of your blog
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <div class="p-6 space-y-6">


                                {{-- Title --}}
                                <div>

                                    <label
                                        for="title"
                                        class="block text-sm font-medium text-slate-700 mb-2">

                                        Blog Title
                                        <span class="text-red-500">*</span>

                                    </label>

                                    <input
                                        type="text"
                                        id="title"
                                        name="title"
                                        value="{{ old('title', $blog->title) }}"
                                        required
                                        class="w-full px-4 py-3 rounded-lg
                                               border border-slate-300
                                               bg-white text-slate-900
                                               placeholder-slate-400
                                               focus:ring-2 focus:ring-blue-500
                                               focus:border-blue-500
                                               outline-none transition"
                                        placeholder="Enter blog title">

                                </div>


                                {{-- Description --}}
                                <div>

                                    <label
                                        for="description"
                                        class="block text-sm font-medium text-slate-700 mb-2">

                                        Description
                                        <span class="text-red-500">*</span>

                                    </label>

                                    <textarea
                                        id="description"
                                        name="description"
                                        rows="12"
                                        required
                                        class="w-full px-4 py-3 rounded-lg
                                               border border-slate-300
                                               bg-white text-slate-900
                                               placeholder-slate-400
                                               focus:ring-2 focus:ring-blue-500
                                               focus:border-blue-500
                                               outline-none transition resize-y"
                                        placeholder="Write your blog content...">{{ old('description', $blog->description) }}</textarea>

                                </div>

                            </div>

                        </div>


                        {{-- Existing Gallery --}}
                        @if (!empty($blog->multiple_images))

                            <div class="bg-white rounded-xl border border-slate-200 shadow-sm">

                                <div class="px-6 py-5 border-b border-slate-200">

                                    <div class="flex items-center gap-3">

                                        <div class="w-10 h-10 rounded-lg bg-purple-50
                                                    flex items-center justify-center">

                                            <i data-lucide="images"
                                               class="w-5 h-5 text-purple-600"></i>

                                        </div>

                                        <div>

                                            <h3 class="font-semibold text-slate-900">
                                                Existing Gallery
                                            </h3>

                                            <p class="text-xs text-slate-500 mt-0.5">
                                                Current images in this blog
                                            </p>

                                        </div>

                                    </div>

                                </div>


                                <div class="p-6">

                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">

                                        @foreach ($blog->multiple_images as $image)

                                            <div class="relative group aspect-square rounded-lg
                                                        overflow-hidden bg-slate-100
                                                        border border-slate-200">

                                                <img
                                                    src="{{ asset('storage/' . $image) }}"
                                                    alt="Gallery Image"
                                                    class="w-full h-full object-cover">

                                                <div
                                                    class="absolute inset-0 bg-black/40
                                                           opacity-0 group-hover:opacity-100
                                                           transition flex items-center justify-center">

                                                    <i data-lucide="image"
                                                       class="w-6 h-6 text-white"></i>

                                                </div>

                                            </div>

                                        @endforeach

                                    </div>

                                </div>

                            </div>

                        @endif


                        {{-- Add Gallery Images --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm">

                            <div class="px-6 py-5 border-b border-slate-200">

                                <div class="flex items-center gap-3">

                                    <div class="w-10 h-10 rounded-lg bg-emerald-50
                                                flex items-center justify-center">

                                        <i data-lucide="image-plus"
                                           class="w-5 h-5 text-emerald-600"></i>

                                    </div>

                                    <div>

                                        <h3 class="font-semibold text-slate-900">
                                            Add More Gallery Images
                                        </h3>

                                        <p class="text-xs text-slate-500 mt-0.5">
                                            Upload additional images for this blog
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <div class="p-6">

                                <label
                                    for="multiple_images"
                                    class="block w-full border-2 border-dashed
                                           border-slate-300 rounded-xl p-8
                                           text-center cursor-pointer
                                           hover:border-blue-400
                                           hover:bg-blue-50/30 transition">

                                    <div class="flex flex-col items-center">

                                        <div class="w-12 h-12 rounded-full bg-slate-100
                                                    flex items-center justify-center mb-3">

                                            <i data-lucide="upload"
                                               class="w-6 h-6 text-slate-500"></i>

                                        </div>

                                        <p class="text-sm font-medium text-slate-700">
                                            Click to upload gallery images
                                        </p>

                                        <p class="text-xs text-slate-500 mt-1">
                                            JPEG, PNG, JPG or WEBP
                                        </p>

                                        <p id="gallery-count"
                                           class="text-xs text-blue-600 font-medium mt-2">
                                        </p>

                                    </div>

                                    <input
                                        type="file"
                                        id="multiple_images"
                                        name="multiple_images[]"
                                        multiple
                                        accept="image/jpeg,image/png,image/jpg,image/webp"
                                        class="hidden"
                                        onchange="showGalleryCount(this)">

                                </label>

                            </div>

                        </div>

                    </div>


                    {{-- RIGHT SIDE --}}
                    <div class="space-y-6">


                        {{-- Update Blog --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm">

                            <div class="px-6 py-5 border-b border-slate-200">

                                <div class="flex items-center gap-3">

                                    <div class="w-10 h-10 rounded-lg bg-blue-50
                                                flex items-center justify-center">

                                        <i data-lucide="settings"
                                           class="w-5 h-5 text-blue-600"></i>

                                    </div>

                                    <div>

                                        <h3 class="font-semibold text-slate-900">
                                            Update Blog
                                        </h3>

                                        <p class="text-xs text-slate-500 mt-0.5">
                                            Manage publishing details
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <div class="p-6 space-y-5">

                                {{-- Blog Date --}}
                                <div>

                                    <label
                                        for="blog_date"
                                        class="block text-sm font-medium text-slate-700 mb-2">

                                        Blog Date
                                        <span class="text-red-500">*</span>

                                    </label>

                                    <input
                                        type="date"
                                        id="blog_date"
                                        name="blog_date"
                                        value="{{ old('blog_date', optional($blog->blog_date)->format('Y-m-d')) }}"
                                        required
                                        class="w-full px-4 py-3 rounded-lg
                                               border border-slate-300
                                               focus:ring-2 focus:ring-blue-500
                                               focus:border-blue-500
                                               outline-none transition">

                                </div>


                                <button
                                    type="submit"
                                    class="w-full inline-flex items-center
                                           justify-center gap-2 px-5 py-3
                                           bg-blue-600 text-white
                                           font-semibold rounded-lg
                                           hover:bg-blue-700
                                           focus:ring-4 focus:ring-blue-100
                                           transition">

                                    <i data-lucide="save" class="w-5 h-5"></i>

                                    Update Blog

                                </button>


                                <a
                                    href="{{ route('admin.blogs.index') }}"
                                    class="w-full inline-flex items-center
                                           justify-center gap-2 px-5 py-3
                                           border border-slate-300
                                           text-slate-700 font-medium
                                           rounded-lg hover:bg-slate-50
                                           transition">

                                    Cancel

                                </a>

                            </div>

                        </div>


                        {{-- Current Cover Image --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm">

                            <div class="px-6 py-5 border-b border-slate-200">

                                <div class="flex items-center gap-3">

                                    <div class="w-10 h-10 rounded-lg bg-amber-50
                                                flex items-center justify-center">

                                        <i data-lucide="image"
                                           class="w-5 h-5 text-amber-600"></i>

                                    </div>

                                    <div>

                                        <h3 class="font-semibold text-slate-900">
                                            Cover Image
                                        </h3>

                                        <p class="text-xs text-slate-500 mt-0.5">
                                            Replace the current cover image
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <div class="p-6">

                                <div
                                    id="cover-preview"
                                    class="aspect-video rounded-xl overflow-hidden
                                           bg-slate-100 border border-slate-200 mb-4">

                                    @if ($blog->image)

                                        <img
                                            src="{{ asset('storage/' . $blog->image) }}"
                                            alt="{{ $blog->title }}"
                                            class="w-full h-full object-cover">

                                    @else

                                        <div class="w-full h-full flex items-center justify-center">

                                            <i data-lucide="image-off"
                                               class="w-10 h-10 text-slate-300"></i>

                                        </div>

                                    @endif

                                </div>


                                <label
                                    for="image"
                                    class="w-full inline-flex items-center
                                           justify-center gap-2 px-4 py-3
                                           border border-slate-300
                                           text-slate-700 font-medium
                                           rounded-lg cursor-pointer
                                           hover:bg-slate-50 transition">

                                    <i data-lucide="upload" class="w-4 h-4"></i>

                                    Choose New Cover Image

                                </label>

                                <input
                                    type="file"
                                    id="image"
                                    name="image"
                                    accept="image/jpeg,image/png,image/jpg,image/webp"
                                    class="hidden"
                                    onchange="previewCover(this)">

                                <p class="text-xs text-slate-500 mt-2 text-center">
                                    JPEG, PNG, JPG or WEBP
                                </p>

                            </div>

                        </div>


                        {{-- Blog ID --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm">

                            <div class="p-6">

                                <div class="flex items-center justify-between">

                                    <div>

                                        <p class="text-xs text-slate-500">
                                            Blog ID
                                        </p>

                                        <p class="text-lg font-semibold text-slate-900 mt-1">
                                            #{{ $blog->id }}
                                        </p>

                                    </div>

                                    <div class="w-10 h-10 rounded-lg bg-slate-100
                                                flex items-center justify-center">

                                        <i data-lucide="hash"
                                           class="w-5 h-5 text-slate-500"></i>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </main>

    </div>


    {{-- Scripts --}}
    <script>

        function previewCover(input) {

            const preview = document.getElementById('cover-preview');

            if (!input.files || !input.files[0]) {
                return;
            }

            const file = input.files[0];

            if (!file.type.startsWith('image/')) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function (e) {

                preview.innerHTML = `
                    <img
                        src="${e.target.result}"
                        alt="Cover Preview"
                        class="w-full h-full object-cover">
                `;

                lucide.createIcons();
            };

            reader.readAsDataURL(file);
        }


        function showGalleryCount(input) {

            const countElement = document.getElementById('gallery-count');

            if (!input.files || input.files.length === 0) {

                countElement.textContent = '';

                return;
            }

            const count = input.files.length;

            countElement.textContent =
                count + (count === 1 ? ' image selected' : ' images selected');
        }


        document.addEventListener('DOMContentLoaded', function () {

            lucide.createIcons();

        });

    </script>

</body>
</html>