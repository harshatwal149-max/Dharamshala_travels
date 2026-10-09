<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Email Desk | Admin</title>

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
                <span class="font-bold text-slate-800">
                    Email Desk
                </span>
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

                        <i
                            data-lucide="check-circle"
                            class="w-4 h-4 text-emerald-600">
                        </i>

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

                {{-- EMAIL FORM --}}
                <form
                    action="{{ route('admin.email-desk.update') }}"
                    method="POST">

                    @csrf

                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-6">

                        {{-- TITLE --}}
                        <div>
                            <h1 class="text-base font-extrabold text-slate-900">
                                Email Desk
                            </h1>

                            <p class="text-xs text-slate-500 mt-1">
                                Manage the customer support email address and expected response time.
                            </p>
                        </div>

                        {{-- EMAIL --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Contact Email
                            </label>

                            <div class="relative">

                                <i
                                    data-lucide="mail"
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400">
                                </i>

                                <input
                                    type="email"
                                    name="contact_email"
                                    value="{{ old('contact_email', $email['contact_email'] ?? '') }}"
                                    maxlength="100"
                                    placeholder="info@dharamshalatravels.com"
                                    class="w-full pl-10 pr-3 py-3 bg-white border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">

                            </div>

                            <p class="text-[11px] text-slate-400 mt-1">
                                Main email address customers can use for enquiries and support.
                            </p>

                        </div>

                        {{-- RESPONSE TIME --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Email Response Time
                            </label>

                            <div class="relative">

                                <i
                                    data-lucide="clock-3"
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400">
                                </i>

                                <input
                                    type="text"
                                    name="contact_email_response"
                                    value="{{ old('contact_email_response', $email['contact_email_response'] ?? '') }}"
                                    maxlength="100"
                                    placeholder="Response within 2 hours"
                                    class="w-full pl-10 pr-3 py-3 bg-white border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">

                            </div>

                            <p class="text-[11px] text-slate-400 mt-1">
                                Example: Response within 2 hours
                            </p>

                        </div>

                        {{-- SAVE --}}
                        <div class="flex justify-end pt-2">

                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg text-xs transition">

                                <i data-lucide="save" class="w-4 h-4"></i>

                                Save Email Desk

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
