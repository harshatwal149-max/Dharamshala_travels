<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Blogs Management - {{ \App\Models\Setting::get('site_title', 'Dharamshala Travels') }}
    </title>

    @if(\App\Models\Setting::get('site_favicon'))
        <link rel="icon"
              type="image/x-icon"
              href="{{ \App\Models\Setting::get('site_favicon') }}">
    @endif

    {{-- Inter Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Vite --}}
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    {{-- Lucide --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- Alpine --}}
    <script defer
            src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- SweetAlert --}}
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

    {{-- =========================================================
         SIDEBAR
    ========================================================== --}}
    @include('admin.partials.sidebar')


    {{-- =========================================================
         MAIN APPLICATION WRAPPER
    ========================================================== --}}
    <div class="flex-1 flex flex-col overflow-y-auto min-w-0">


        {{-- =====================================================
             TOP HEADER
        ====================================================== --}}
        <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between shrink-0 sticky top-0 z-30">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-xs">

                <span class="text-slate-400">
                    Admin
                </span>

                <span class="text-slate-300">
                    /
                </span>

                <span class="font-semibold text-slate-700">
                    Blogs
                </span>

            </div>


            {{-- Website Button --}}
            <a href="{{ route('home') }}"
               target="_blank"
               class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">

                <i data-lucide="globe"
                   class="w-3.5 h-3.5 text-slate-500"></i>

                Website

            </a>

        </header>


        {{-- =====================================================
             MAIN CONTENT
        ====================================================== --}}
        <main class="p-6 space-y-6">


            {{-- =================================================
                 SUCCESS MESSAGE
            ================================================== --}}
            @if(session('success'))

                <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">

                    <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shrink-0">

                        <i data-lucide="check"
                           class="w-4 h-4 text-emerald-600"></i>

                    </div>

                    <div>

                        <p class="text-xs font-bold text-emerald-800">
                            Success
                        </p>

                        <p class="text-xs text-emerald-700 mt-0.5">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

            @endif


            {{-- =================================================
                 ERROR MESSAGE
            ================================================== --}}
            @if($errors->any())

                <div class="p-4 bg-red-50 border border-red-200 rounded-xl">

                    <div class="flex items-start gap-3">

                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shrink-0">

                            <i data-lucide="alert-circle"
                               class="w-4 h-4 text-red-600"></i>

                        </div>

                        <div>

                            <p class="text-xs font-bold text-red-800">
                                Something went wrong
                            </p>

                            <ul class="mt-1 text-xs text-red-700 space-y-1">

                                @foreach($errors->all() as $error)

                                    <li>
                                        • {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif


            {{-- =================================================
                 PAGE HEADING
            ================================================== --}}
            <div class="flex items-center justify-between">

                <div>

                    <h1 class="text-xl font-extrabold text-slate-900">
                        Blogs Management
                    </h1>

                    <p class="text-sm text-slate-500">
                        Create and manage travel stories, guides and articles.
                    </p>

                </div>


                {{-- Add Blog --}}
                <a href="{{ route('admin.blogs.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-emerald-600 text-white text-xs font-bold shadow-sm hover:bg-emerald-700 transition">

                    <i data-lucide="plus"
                       class="w-4 h-4"></i>

                    Add New Blog

                </a>

            </div>


            {{-- =================================================
                 SUMMARY CARD
            ================================================== --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm">

                <div class="px-5 py-4 flex items-center justify-between">

                    <div>

                        <h2 class="text-sm font-bold text-slate-900">
                            Travel Blogs
                        </h2>

                        <p class="text-xs text-slate-500 mt-1">
                            Manage useful travel content for your website visitors.
                        </p>

                    </div>


                    <div class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg">

                        <span class="text-[10px] text-slate-500 uppercase font-bold">
                            Total Blogs
                        </span>

                        <span class="ml-2 text-sm font-bold text-slate-900">
                            {{ $blogs->total() }}
                        </span>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 BLOG GRID
            ================================================== --}}
            @if($blogs->count())

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                    @foreach($blogs as $blog)

                        <article class="group bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition">


                            {{-- =================================================
                                 IMAGE
                            ================================================== --}}
                            <div class="relative h-52 bg-slate-100 overflow-hidden">

                                @if($blog->image)

                                    <img src="{{ $blog->image }}"
                                         alt="{{ $blog->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">

                                @else

                                    <div class="w-full h-full flex flex-col items-center justify-center">

                                        <div class="w-14 h-14 rounded-xl bg-white flex items-center justify-center shadow-sm">

                                            <i data-lucide="image"
                                               class="w-7 h-7 text-slate-300"></i>

                                        </div>

                                        <span class="text-[10px] text-slate-400 mt-2 font-medium">
                                            No cover image
                                        </span>

                                    </div>

                                @endif


                                {{-- Overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none"></div>


                                {{-- Date --}}
                                <div class="absolute top-4 left-4">

                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-white/95 backdrop-blur-sm shadow-sm">

                                        <i data-lucide="calendar"
                                           class="w-3.5 h-3.5 text-emerald-600"></i>

                                        <span class="text-[10px] font-bold text-slate-700">

                                            {{ $blog->blog_date?->format('d M Y') }}

                                        </span>

                                    </div>

                                </div>


                                {{-- Gallery Count --}}
                                @php
                                    $galleryCount = is_array($blog->multiple_images)
                                        ? count($blog->multiple_images)
                                        : 0;
                                @endphp

                                @if($galleryCount > 0)

                                    <div class="absolute top-4 right-4">

                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-black/60 backdrop-blur-sm text-white">

                                            <i data-lucide="images"
                                               class="w-3.5 h-3.5"></i>

                                            <span class="text-[10px] font-bold">
                                                {{ $galleryCount }}
                                            </span>

                                        </div>

                                    </div>

                                @endif

                            </div>


                            {{-- =================================================
                                 CARD BODY
                            ================================================== --}}
                            <div class="p-5">


                                {{-- Category --}}
                                <div class="flex items-center gap-2 mb-3">

                                    <span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wide text-emerald-600">

                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>

                                        Travel Blog

                                    </span>

                                </div>


                                {{-- Title --}}
                                <h3 class="text-base font-bold text-slate-900 leading-6 line-clamp-2 min-h-[48px]">

                                    {{ $blog->title }}

                                </h3>


                                {{-- Description --}}
                                <p class="text-xs text-slate-500 leading-5 mt-3 line-clamp-3 min-h-[60px]">

                                    {{ \Illuminate\Support\Str::limit(strip_tags($blog->description), 145) }}

                                </p>


                                {{-- Divider --}}
                                <div class="border-t border-slate-100 my-4"></div>


                                {{-- Footer --}}
                                <div class="flex items-center justify-between">


                                    {{-- Blog ID --}}
                                    <div class="flex items-center gap-2">

                                        <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center">

                                            <i data-lucide="file-text"
                                               class="w-3.5 h-3.5 text-slate-500"></i>

                                        </div>

                                        <div>

                                            <p class="text-[9px] uppercase font-bold text-slate-400 tracking-wide">
                                                Blog ID
                                            </p>

                                            <p class="text-[11px] font-bold text-slate-700">
                                                #{{ $blog->id }}
                                            </p>

                                        </div>

                                    </div>


                                    {{-- Actions --}}
                                    <div class="flex items-center gap-2">


                                        {{-- Edit --}}
                                        <a href="{{ route('admin.blogs.edit', $blog) }}"
                                           onclick="confirmEdit(event, this.href);"
                                           class="w-9 h-9 rounded-lg border border-slate-200 flex items-center justify-center text-slate-600 hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-600 transition"
                                           title="Edit Blog">

                                            <i data-lucide="pencil"
                                               class="w-4 h-4"></i>

                                        </a>


                                        {{-- Delete --}}
                                        <form action="{{ route('admin.blogs.destroy', $blog) }}"
                                              method="POST"
                                              onsubmit="return confirmDelete(event, this);">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit"
                                                    class="w-9 h-9 rounded-lg border border-slate-200 flex items-center justify-center text-slate-600 hover:border-red-200 hover:bg-red-50 hover:text-red-600 transition"
                                                    title="Delete Blog">

                                                <i data-lucide="trash-2"
                                                   class="w-4 h-4"></i>

                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>


                {{-- =================================================
                     PAGINATION
                ================================================== --}}
                @if($blogs->hasPages())

                    <div class="bg-white border border-slate-200 rounded-xl px-5 py-4 shadow-sm">

                        {{ $blogs->links() }}

                    </div>

                @endif


            @else


                {{-- =================================================
                     EMPTY STATE
                ================================================== --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm">

                    <div class="min-h-[500px] flex items-center justify-center px-6">

                        <div class="text-center max-w-md">


                            <div class="relative w-24 h-24 mx-auto mb-6">

                                <div class="absolute inset-0 rounded-3xl bg-emerald-50 rotate-6"></div>

                                <div class="absolute inset-0 rounded-3xl bg-slate-100 flex items-center justify-center">

                                    <i data-lucide="newspaper"
                                       class="w-10 h-10 text-emerald-600"></i>

                                </div>

                            </div>


                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider">

                                No Content Yet

                            </span>


                            <h3 class="text-xl font-bold text-slate-900 mt-4">

                                Start Your First Travel Blog

                            </h3>


                            <p class="text-sm text-slate-500 leading-6 mt-2">

                                Share travel guides, destination stories and useful information with your website visitors.

                            </p>


                            <a href="{{ route('admin.blogs.create') }}"
                               class="inline-flex items-center gap-2 mt-6 px-5 py-3 rounded-xl bg-emerald-600 text-white text-xs font-bold shadow-sm hover:bg-emerald-700 transition">

                                <i data-lucide="plus"
                                   class="w-4 h-4"></i>

                                Create Your First Blog

                            </a>

                        </div>

                    </div>

                </div>

            @endif

        </main>

    </div>


    {{-- =========================================================
         LUCIDE
    ========================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            if (window.lucide) {
                lucide.createIcons();
            }

        });
    </script>


    {{-- =========================================================
         DELETE CONFIRMATION
    ========================================================== --}}
    <script>

        function confirmDelete(event, form) {

            event.preventDefault();

            Swal.fire({
                title: 'Delete Blog?',
                text: 'This blog will be permanently deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {

                if (result.isConfirmed) {
                    form.submit();
                }

            });

            return false;
        }


        function confirmEdit(event, url) {

            event.preventDefault();

            Swal.fire({
                title: 'Edit Blog?',
                text: 'You are about to edit this blog.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Edit',
                cancelButtonText: 'Cancel'
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location.href = url;
                }

            });

            return false;
        }

    </script>

</body>

</html>