<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Blogs | Admin Panel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f6f8fb] text-slate-900">

    <div class="min-h-screen flex">

        {{-- SIDEBAR --}}
        @include('admin.partials.sidebar')


        {{-- MAIN --}}
        <main class="flex-1 min-w-0 overflow-hidden">


            {{-- TOP HEADER --}}
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-7">

                <div class="flex items-center gap-3">

                    <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center">
                        <i
                            data-lucide="newspaper"
                            class="w-5 h-5 text-emerald-600"></i>
                    </div>

                    <div>

                        <h1 class="text-base font-bold text-slate-900">
                            Blogs
                        </h1>

                        <p class="text-[11px] text-slate-500">
                            Manage travel stories, guides and articles
                        </p>

                    </div>

                </div>


                <a
                    href="{{ route('admin.blogs.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-emerald-600 text-white text-xs font-bold shadow-sm hover:bg-emerald-700 hover:shadow transition">

                    <i data-lucide="plus" class="w-4 h-4"></i>

                    Add New Blog

                </a>

            </header>



            {{-- CONTENT --}}
            <div class="p-7">


                {{-- SUCCESS --}}
                @if(session('success'))

                <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">

                    <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shrink-0">

                        <i
                            data-lucide="check"
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



                {{-- ERRORS --}}
                @if($errors->any())

                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

                    <div class="flex items-start gap-3">

                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shrink-0">

                            <i
                                data-lucide="alert-circle"
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



                {{-- PAGE INTRO --}}
                <div class="flex items-end justify-between mb-6">

                    <div>

                        <div class="flex items-center gap-2 mb-1">

                            <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-600">
                                Content Management
                            </span>

                        </div>

                        <h2 class="text-xl font-bold text-slate-900">
                            Travel Blogs
                        </h2>

                        <p class="text-xs text-slate-500 mt-1">
                            Create and manage useful travel content for your visitors.
                        </p>

                    </div>


                    <div class="flex items-center gap-2">

                        <div class="px-3 py-2 bg-white border border-slate-200 rounded-lg">

                            <span class="text-[10px] text-slate-500 uppercase font-bold">
                                Total Blogs
                            </span>

                            <span class="ml-2 text-sm font-bold text-slate-900">
                                {{ $blogs->total() }}
                            </span>

                        </div>

                    </div>

                </div>



                {{-- BLOG GRID --}}
                @if($blogs->count())

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">


                    @foreach($blogs as $blog)

                    <article
                        class="group bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">


                        {{-- IMAGE --}}
                        <div class="relative h-52 bg-slate-100 overflow-hidden">


                            @if($blog->image)

                            <img
                                src="{{ $blog->image }}"
                                alt="{{ $blog->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">

                            @else

                            <div class="w-full h-full flex flex-col items-center justify-center">

                                <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center shadow-sm">

                                    <i
                                        data-lucide="image"
                                        class="w-7 h-7 text-slate-300"></i>

                                </div>

                                <span class="text-[10px] text-slate-400 mt-2 font-medium">
                                    No cover image
                                </span>

                            </div>

                            @endif


                            {{-- DARK OVERLAY --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent pointer-events-none"></div>


                            {{-- DATE --}}
                            <div class="absolute top-4 left-4">

                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-white/95 backdrop-blur-sm shadow-sm">

                                    <i
                                        data-lucide="calendar"
                                        class="w-3.5 h-3.5 text-emerald-600"></i>

                                    <span class="text-[10px] font-bold text-slate-700">

                                        {{ $blog->blog_date?->format('d M Y') }}

                                    </span>

                                </div>

                            </div>


                            {{-- GALLERY --}}
                            @php
                            $galleryCount = is_array($blog->multiple_images)
                            ? count($blog->multiple_images)
                            : 0;
                            @endphp


                            @if($galleryCount > 0)

                            <div class="absolute top-4 right-4">

                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-black/60 backdrop-blur-sm text-white">

                                    <i
                                        data-lucide="images"
                                        class="w-3.5 h-3.5"></i>

                                    <span class="text-[10px] font-bold">
                                        {{ $galleryCount }}
                                    </span>

                                </div>

                            </div>

                            @endif


                        </div>



                        {{-- CARD BODY --}}
                        <div class="p-5">


                            {{-- CATEGORY / META --}}
                            <div class="flex items-center gap-2 mb-3">

                                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wide text-emerald-600">

                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>

                                    Travel Blog

                                </span>

                            </div>



                            {{-- TITLE --}}
                            <h3 class="text-base font-bold text-slate-900 leading-6 line-clamp-2 min-h-[48px] group-hover:text-emerald-700 transition">

                                {{ $blog->title }}

                            </h3>



                            {{-- DESCRIPTION --}}
                            <p class="text-xs text-slate-500 leading-5 mt-3 line-clamp-3 min-h-[60px]">

                                {{ \Illuminate\Support\Str::limit(strip_tags($blog->description), 145) }}

                            </p>



                            {{-- DIVIDER --}}
                            <div class="border-t border-slate-100 my-4"></div>



                            {{-- FOOTER --}}
                            <div class="flex items-center justify-between">


                                {{-- BLOG ID --}}
                                <div class="flex items-center gap-2">

                                    <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center">

                                        <i
                                            data-lucide="file-text"
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



                                {{-- ACTIONS --}}
                                <div class="flex items-center gap-2">


                                    {{-- EDIT --}}
                                    <a
                                        href="{{ route('admin.blogs.edit', $blog) }}"
                                        onclick="confirmEdit(event, this.href);"
                                        class="w-9 h-9 rounded-lg border border-slate-200 flex items-center justify-center text-slate-600 hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-600 transition"
                                        title="Edit Blog">

                                        <i
                                            data-lucide="pencil"
                                            class="w-4 h-4"></i>

                                    </a>


                                    {{-- DELETE --}}
                                    <form
                                        action="{{ route('admin.blogs.destroy', $blog) }}"
                                        method="POST"
                                        onsubmit="return confirmDelete(event, this);">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="w-9 h-9 rounded-lg border border-slate-200 flex items-center justify-center text-slate-600 hover:border-red-200 hover:bg-red-50 hover:text-red-600 transition"
                                            title="Delete Blog">
                                            <i
                                                data-lucide="trash-2"
                                                class="w-4 h-4"></i>
                                        </button>
                                    </form>

                                </div>


                            </div>


                        </div>


                    </article>

                    @endforeach


                </div>



                {{-- PAGINATION --}}
                @if($blogs->hasPages())

                <div class="mt-7 bg-white border border-slate-200 rounded-xl px-5 py-4">

                    {{ $blogs->links() }}

                </div>

                @endif


                @else


                {{-- EMPTY STATE --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">

                    <div class="min-h-[500px] flex items-center justify-center px-6">

                        <div class="text-center max-w-md">


                            <div class="relative w-24 h-24 mx-auto mb-6">

                                <div class="absolute inset-0 rounded-3xl bg-emerald-50 rotate-6"></div>

                                <div class="absolute inset-0 rounded-3xl bg-slate-100 flex items-center justify-center">

                                    <i
                                        data-lucide="newspaper"
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


                            <a
                                href="{{ route('admin.blogs.create') }}"
                                class="inline-flex items-center gap-2 mt-6 px-5 py-3 rounded-xl bg-emerald-600 text-white text-xs font-bold shadow-sm hover:bg-emerald-700 transition">

                                <i
                                    data-lucide="plus"
                                    class="w-4 h-4"></i>

                                Create Your First Blog

                            </a>


                        </div>

                    </div>

                </div>

                @endif


            </div>


        </main>

    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {

            if (window.lucide) {
                lucide.createIcons();
            }

        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
</script>

<script>
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