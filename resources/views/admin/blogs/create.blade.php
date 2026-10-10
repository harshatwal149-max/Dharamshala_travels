<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Create Blog | Admin Panel</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <script src="https://unpkg.com/lucide@latest"></script>

</head>


<body class="bg-[#f6f8fb] text-slate-900 flex h-screen overflow-hidden">


    {{-- =========================================================
         SIDEBAR
    ========================================================== --}}

    @include('admin.partials.sidebar')


    {{-- =========================================================
         MAIN AREA
    ========================================================== --}}

    <div class="flex-1 flex flex-col overflow-y-auto min-w-0">


        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <header
            class="sticky top-0 z-30
                   h-16
                   bg-white
                   border-b border-slate-200
                   flex items-center justify-between
                   px-7
                   shrink-0"
        >

            {{-- LEFT --}}

            <div class="flex items-center gap-3">

                <a
                    href="{{ route('admin.blogs.index') }}"
                    class="w-9 h-9
                           rounded-lg
                           border border-slate-200
                           flex items-center justify-center
                           text-slate-600
                           hover:bg-slate-50
                           transition"
                >

                    <i
                        data-lucide="arrow-left"
                        class="w-4 h-4"
                    ></i>

                </a>


                <div>

                    <h1
                        class="text-base
                               font-bold
                               text-slate-900"
                    >
                        Create Blog
                    </h1>

                    <p
                        class="text-[11px]
                               text-slate-500"
                    >
                        Add a new travel article to your website
                    </p>

                </div>

            </div>


            {{-- RIGHT --}}

            <a
                href="{{ route('admin.blogs.index') }}"
                class="inline-flex
                       items-center
                       gap-2
                       px-4 py-2.5
                       rounded-lg
                       border border-slate-200
                       bg-white
                       text-slate-700
                       text-xs
                       font-bold
                       hover:bg-slate-50
                       transition"
            >

                <i
                    data-lucide="list"
                    class="w-4 h-4"
                ></i>

                All Blogs

            </a>

        </header>


        {{-- =====================================================
             PAGE CONTENT
        ====================================================== --}}

        <div class="p-7">


            {{-- =================================================
                 ERROR MESSAGE
            ================================================== --}}

            @if($errors->any())

                <div
                    class="mb-6
                           rounded-xl
                           border border-red-200
                           bg-red-50
                           p-4"
                >

                    <div class="flex items-start gap-3">

                        <div
                            class="w-8 h-8
                                   rounded-lg
                                   bg-white
                                   flex items-center
                                   justify-center
                                   shrink-0"
                        >

                            <i
                                data-lucide="alert-circle"
                                class="w-4 h-4 text-red-600"
                            ></i>

                        </div>


                        <div>

                            <p
                                class="text-xs
                                       font-bold
                                       text-red-800"
                            >
                                Please fix the following errors:
                            </p>


                            <ul
                                class="mt-2
                                       list-disc
                                       ml-4
                                       space-y-1
                                       text-xs
                                       text-red-700"
                            >

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif


            {{-- =================================================
                 PAGE INTRO
            ================================================== --}}

            <div class="mb-6">

                <h2
                    class="text-2xl
                           font-extrabold
                           text-slate-900"
                >
                    Create New Blog
                </h2>

                <p
                    class="text-xs
                           text-slate-500
                           mt-1"
                >
                    Add the title, cover image, content, date
                    and optional gallery images.
                </p>

            </div>


            {{-- =================================================
                 FORM
            ================================================== --}}

            <form
                action="{{ route('admin.blogs.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                <div
                    class="grid
                           grid-cols-1
                           xl:grid-cols-3
                           gap-6"
                >


                    {{-- =========================================
                         LEFT COLUMN
                    ========================================== --}}

                    <div
                        class="xl:col-span-2
                               space-y-6"
                    >


                        {{-- =====================================
                             BLOG INFORMATION
                        ====================================== --}}

                        <div
                            class="bg-white
                                   border border-slate-200
                                   rounded-2xl
                                   shadow-sm
                                   overflow-hidden"
                        >

                            <div
                                class="px-6 py-5
                                       border-b border-slate-200"
                            >

                                <div
                                    class="flex
                                           items-center
                                           gap-3"
                                >

                                    <div
                                        class="w-9 h-9
                                               rounded-lg
                                               bg-emerald-50
                                               flex items-center
                                               justify-center"
                                    >

                                        <i
                                            data-lucide="file-text"
                                            class="w-5 h-5
                                                   text-emerald-600"
                                        ></i>

                                    </div>


                                    <div>

                                        <h3
                                            class="text-sm
                                                   font-bold
                                                   text-slate-900"
                                        >
                                            Blog Information
                                        </h3>

                                        <p
                                            class="text-[11px]
                                                   text-slate-500"
                                        >
                                            Enter the main information
                                            for your travel article.
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <div
                                class="p-6
                                       space-y-5"
                            >


                                {{-- TITLE --}}

                                <div>

                                    <label
                                        class="block
                                               text-xs
                                               font-bold
                                               text-slate-700
                                               mb-2"
                                    >

                                        Blog Title

                                        <span class="text-red-500">
                                            *
                                        </span>

                                    </label>


                                    <input
                                        type="text"
                                        name="title"
                                        value="{{ old('title') }}"
                                        required
                                        placeholder="Enter blog title"
                                        class="w-full
                                               px-4 py-3
                                               rounded-xl
                                               border border-slate-200
                                               bg-slate-50
                                               text-sm
                                               text-slate-900
                                               focus:outline-none
                                               focus:ring-2
                                               focus:ring-emerald-500/20
                                               focus:border-emerald-500
                                               focus:bg-white
                                               transition"
                                    >

                                </div>


                                {{-- DESCRIPTION --}}

                                <div>

                                    <label
                                        class="block
                                               text-xs
                                               font-bold
                                               text-slate-700
                                               mb-2"
                                    >

                                        Blog Description

                                        <span class="text-red-500">
                                            *
                                        </span>

                                    </label>


                                    <textarea
                                        name="description"
                                        rows="14"
                                        required
                                        placeholder="Write your blog content..."
                                        class="w-full
                                               px-4 py-3
                                               rounded-xl
                                               border border-slate-200
                                               bg-slate-50
                                               text-sm
                                               text-slate-900
                                               focus:outline-none
                                               focus:ring-2
                                               focus:ring-emerald-500/20
                                               focus:border-emerald-500
                                               focus:bg-white
                                               transition
                                               resize-y"
                                    >{{ old('description') }}</textarea>

                                </div>

                            </div>

                        </div>


                        {{-- =====================================
                             COVER IMAGE
                        ====================================== --}}

                        <div
                            class="bg-white
                                   border border-slate-200
                                   rounded-2xl
                                   shadow-sm
                                   overflow-hidden"
                        >

                            <div
                                class="px-6 py-5
                                       border-b border-slate-200"
                            >

                                <div
                                    class="flex
                                           items-center
                                           gap-3"
                                >

                                    <div
                                        class="w-9 h-9
                                               rounded-lg
                                               bg-amber-50
                                               flex items-center
                                               justify-center"
                                    >

                                        <i
                                            data-lucide="image"
                                            class="w-5 h-5
                                                   text-amber-600"
                                        ></i>

                                    </div>


                                    <div>

                                        <h3
                                            class="text-sm
                                                   font-bold
                                                   text-slate-900"
                                        >
                                            Cover Image
                                        </h3>

                                        <p
                                            class="text-[11px]
                                                   text-slate-500"
                                        >
                                            Main image displayed with
                                            the blog article.
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <div class="p-6">

                                <label
                                    for="image"
                                    class="block cursor-pointer"
                                >

                                    <div
                                        class="border-2
                                               border-dashed
                                               border-slate-200
                                               rounded-2xl
                                               p-8
                                               text-center
                                               hover:border-emerald-400
                                               hover:bg-emerald-50/30
                                               transition"
                                    >

                                        <div
                                            class="w-12 h-12
                                                   rounded-xl
                                                   bg-slate-100
                                                   flex items-center
                                                   justify-center
                                                   mx-auto"
                                        >

                                            <i
                                                data-lucide="upload"
                                                class="w-6 h-6
                                                       text-slate-500"
                                            ></i>

                                        </div>


                                        <p
                                            class="text-sm
                                                   font-bold
                                                   text-slate-700
                                                   mt-4"
                                        >
                                            Choose Cover Image
                                        </p>


                                        <p
                                            class="text-[11px]
                                                   text-slate-400
                                                   mt-1"
                                        >
                                            JPG, JPEG, PNG or WEBP
                                        </p>


                                        <input
                                            id="image"
                                            type="file"
                                            name="image"
                                            accept="image/jpeg,image/png,image/jpg,image/webp"
                                            required
                                            class="hidden"
                                            onchange="previewCover(this)"
                                        >

                                    </div>

                                </label>


                                <div
                                    id="cover-preview"
                                    class="mt-4 hidden"
                                ></div>

                            </div>

                        </div>


                        {{-- =====================================
                             GALLERY
                        ====================================== --}}

                        <div
                            class="bg-white
                                   border border-slate-200
                                   rounded-2xl
                                   shadow-sm
                                   overflow-hidden"
                        >

                            <div
                                class="px-6 py-5
                                       border-b border-slate-200"
                            >

                                <div
                                    class="flex
                                           items-center
                                           gap-3"
                                >

                                    <div
                                        class="w-9 h-9
                                               rounded-lg
                                               bg-blue-50
                                               flex items-center
                                               justify-center"
                                    >

                                        <i
                                            data-lucide="images"
                                            class="w-5 h-5
                                                   text-blue-600"
                                        ></i>

                                    </div>


                                    <div>

                                        <h3
                                            class="text-sm
                                                   font-bold
                                                   text-slate-900"
                                        >
                                            Gallery Images
                                        </h3>

                                        <p
                                            class="text-[11px]
                                                   text-slate-500"
                                        >
                                            Add optional images to
                                            showcase this blog.
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <div class="p-6">

                                <label
                                    for="multiple_images"
                                    class="block cursor-pointer"
                                >

                                    <div
                                        class="border-2
                                               border-dashed
                                               border-slate-200
                                               rounded-2xl
                                               p-8
                                               text-center
                                               hover:border-blue-400
                                               hover:bg-blue-50/30
                                               transition"
                                    >

                                        <div
                                            class="w-12 h-12
                                                   rounded-xl
                                                   bg-blue-50
                                                   flex items-center
                                                   justify-center
                                                   mx-auto"
                                        >

                                            <i
                                                data-lucide="images"
                                                class="w-6 h-6
                                                       text-blue-600"
                                            ></i>

                                        </div>


                                        <p
                                            class="text-sm
                                                   font-bold
                                                   text-slate-700
                                                   mt-4"
                                        >
                                            Choose Gallery Images
                                        </p>


                                        <p
                                            class="text-[11px]
                                                   text-slate-400
                                                   mt-1"
                                        >
                                            You can select multiple images
                                        </p>


                                        <input
                                            id="multiple_images"
                                            type="file"
                                            name="multiple_images[]"
                                            multiple
                                            accept="image/jpeg,image/png,image/jpg,image/webp"
                                            class="hidden"
                                            onchange="showGalleryCount(this)"
                                        >

                                    </div>

                                </label>


                                <p
                                    id="gallery-count"
                                    class="text-center
                                           text-xs
                                           font-semibold
                                           text-emerald-600
                                           mt-3
                                           hidden"
                                ></p>


                                <p
                                    class="text-[10px]
                                           text-slate-400
                                           text-center
                                           mt-3"
                                >
                                    JPG, JPEG, PNG or WEBP
                                    · Maximum 5MB per image
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- =========================================
                         RIGHT COLUMN
                    ========================================== --}}

                    <div class="space-y-6">


                        {{-- =====================================
                             PUBLISH
                        ====================================== --}}

                        <div
                            class="bg-white
                                   border border-slate-200
                                   rounded-2xl
                                   shadow-sm
                                   overflow-hidden"
                        >

                            <div
                                class="px-5 py-4
                                       border-b border-slate-200"
                            >

                                <div
                                    class="flex
                                           items-center
                                           gap-2"
                                >

                                    <i
                                        data-lucide="send"
                                        class="w-4 h-4
                                               text-emerald-600"
                                    ></i>


                                    <h3
                                        class="text-sm
                                               font-bold
                                               text-slate-900"
                                    >
                                        Publish Blog
                                    </h3>

                                </div>

                            </div>


                            <div
                                class="p-5
                                       space-y-4"
                            >

                                {{-- DATE --}}

                                <div>

                                    <label
                                        class="block
                                               text-xs
                                               font-bold
                                               text-slate-700
                                               mb-2"
                                    >

                                        Blog Date

                                        <span class="text-red-500">
                                            *
                                        </span>

                                    </label>


                                    <div class="relative">

                                        <i
                                            data-lucide="calendar"
                                            class="absolute
                                                   left-3
                                                   top-1/2
                                                   -translate-y-1/2
                                                   w-4 h-4
                                                   text-slate-400"
                                        ></i>


                                        <input
                                            type="date"
                                            name="blog_date"
                                            value="{{ old('blog_date', now()->format('Y-m-d')) }}"
                                            required
                                            class="w-full
                                                   pl-10 pr-3
                                                   py-3
                                                   rounded-xl
                                                   border border-slate-200
                                                   bg-slate-50
                                                   text-sm
                                                   text-slate-700
                                                   focus:outline-none
                                                   focus:ring-2
                                                   focus:ring-emerald-500/20
                                                   focus:border-emerald-500
                                                   focus:bg-white
                                                   transition"
                                        >

                                    </div>


                                    <p
                                        class="text-[10px]
                                               text-slate-400
                                               mt-2"
                                    >
                                        You can change the publication date.
                                    </p>

                                </div>


                                <div
                                    class="border-t
                                           border-slate-100"
                                ></div>


                                {{-- PUBLISH --}}

                                <button
                                    type="submit"
                                    class="w-full
                                           inline-flex
                                           items-center
                                           justify-center
                                           gap-2
                                           px-4 py-3
                                           rounded-xl
                                           bg-emerald-600
                                           text-white
                                           text-xs
                                           font-bold
                                           shadow-sm
                                           hover:bg-emerald-700
                                           hover:shadow
                                           transition"
                                >

                                    <i
                                        data-lucide="check"
                                        class="w-4 h-4"
                                    ></i>

                                    Publish Blog

                                </button>


                                {{-- CANCEL --}}

                                <a
                                    href="{{ route('admin.blogs.index') }}"
                                    class="w-full
                                           inline-flex
                                           items-center
                                           justify-center
                                           gap-2
                                           px-4 py-3
                                           rounded-xl
                                           border border-slate-200
                                           bg-white
                                           text-slate-700
                                           text-xs
                                           font-bold
                                           hover:bg-slate-50
                                           transition"
                                >

                                    <i
                                        data-lucide="x"
                                        class="w-4 h-4"
                                    ></i>

                                    Cancel

                                </a>

                            </div>

                        </div>


                        {{-- =====================================
                             WRITING TIPS
                        ====================================== --}}

                        <div
                            class="bg-slate-900
                                   rounded-2xl
                                   shadow-sm
                                   overflow-hidden"
                        >

                            <div class="p-5">

                                <div
                                    class="flex
                                           items-center
                                           gap-2"
                                >

                                    <i
                                        data-lucide="lightbulb"
                                        class="w-4 h-4
                                               text-amber-300"
                                    ></i>


                                    <h3
                                        class="text-sm
                                               font-bold
                                               text-white"
                                    >
                                        Writing Tips
                                    </h3>

                                </div>


                                <ul
                                    class="mt-4
                                           space-y-3
                                           text-[11px]
                                           text-slate-300"
                                >

                                    <li class="flex gap-2">

                                        <span class="text-emerald-400">
                                            •
                                        </span>

                                        Use a clear and engaging title.

                                    </li>


                                    <li class="flex gap-2">

                                        <span class="text-emerald-400">
                                            •
                                        </span>

                                        Add useful travel information
                                        for visitors.

                                    </li>


                                    <li class="flex gap-2">

                                        <span class="text-emerald-400">
                                            •
                                        </span>

                                        Use high-quality landscape images.

                                    </li>


                                    <li class="flex gap-2">

                                        <span class="text-emerald-400">
                                            •
                                        </span>

                                        Keep the description informative
                                        and easy to read.

                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
         JAVASCRIPT
    ========================================================== --}}

    <script>

        function previewCover(input) {

            const preview =
                document.getElementById('cover-preview');

            if (!preview) {
                return;
            }

            if (!input.files || !input.files[0]) {

                preview.innerHTML = '';

                preview.classList.add('hidden');

                return;
            }

            const file = input.files[0];

            const reader = new FileReader();

            reader.onload = function (event) {

                preview.innerHTML = `
                    <div class="rounded-xl overflow-hidden border border-slate-200 bg-slate-50">
                        <img
                            src="${event.target.result}"
                            alt="Cover Preview"
                            class="w-full max-h-80 object-cover"
                        >
                    </div>
                `;

                preview.classList.remove('hidden');

            };

            reader.readAsDataURL(file);

        }


        function showGalleryCount(input) {

            const count =
                document.getElementById('gallery-count');

            if (!count) {
                return;
            }

            const total = input.files
                ? input.files.length
                : 0;

            if (total > 0) {

                count.textContent =
                    `${total} image${total > 1 ? 's' : ''} selected`;

                count.classList.remove('hidden');

            } else {

                count.textContent = '';

                count.classList.add('hidden');

            }

        }


        document.addEventListener(
            'DOMContentLoaded',
            function () {

                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }

            }
        );

    </script>

</body>

</html>