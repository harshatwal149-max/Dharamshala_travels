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

        /* Keep the admin workspace usable on narrow screens. */
        .email-desk-main,
        .email-desk-main * {
            box-sizing: border-box;
        }

        .email-desk-main {
            min-width: 0;
            width: 100%;
        }

        .email-desk-content {
            width: 100%;
            max-width: 56rem;
            min-width: 0;
        }

        .email-desk-card {
            min-width: 0;
            overflow-wrap: anywhere;
        }

        .email-desk-card input,
        .email-desk-card textarea {
            min-width: 0;
            max-width: 100%;
        }

        .email-desk-header {
            gap: 1rem;
        }

        .email-desk-breadcrumb {
            min-width: 0;
            overflow-wrap: anywhere;
        }

        .email-desk-save {
            min-height: 2.75rem;
        }

        @media (max-width: 640px) {
            .email-desk-header {
                height: auto;
                min-height: 4rem;
                padding: .75rem 1rem;
                align-items: flex-start;
                flex-wrap: wrap;
            }

            .email-desk-breadcrumb {
                flex: 1 1 100%;
            }

            .email-desk-dashboard-link {
                max-width: 100%;
                white-space: normal;
                text-align: center;
            }

            .email-desk-main {
                padding: 1rem;
            }

            .email-desk-card {
                padding: 1rem;
                border-radius: .75rem;
            }

            .email-desk-save-row {
                display: block;
            }

            .email-desk-save {
                width: 100%;
                justify-content: center;
                white-space: normal;
            }

            .email-desk-helper {
                overflow-wrap: anywhere;
            }
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased flex min-h-screen h-screen overflow-hidden">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col overflow-y-auto min-w-0">

        {{-- HEADER --}}
        <header class="email-desk-header min-h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between shrink-0 sticky top-0 z-30">

            <div class="email-desk-breadcrumb flex items-center gap-2 text-xs">
                <span class="text-slate-400">Admin</span>
                <span class="text-slate-300">/</span>
                <span class="font-bold text-slate-800">
                    Email Desk
                </span>
            </div>

            <a
                href="{{ route('admin.dashboard') }}"
                class="email-desk-dashboard-link inline-flex items-center justify-center px-3 py-2 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                ← Back to Dashboard
            </a>

        </header>

        {{-- CONTENT --}}
        <main class="email-desk-main flex-1 p-6 overflow-y-auto">

            <div class="email-desk-content space-y-6">

                {{-- SUCCESS --}}
                @if(session('success'))
                    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs flex items-start gap-2">
                        <i
                            data-lucide="check-circle"
                            class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5">
                        </i>
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

                {{-- EMAIL FORM --}}
                <form
                    action="{{ route('admin.email-desk.update') }}"
                    method="POST">

                    @csrf

                    <div class="email-desk-card bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-6">

                        {{-- TITLE --}}
                        <div>
                            <h1 class="text-base font-extrabold text-slate-900">
                                Email Desk
                            </h1>

                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Manage the customer support email, response time and who receives booking & enquiry alerts.
                            </p>
                        </div>

                        {{-- EMAIL --}}
                        <div>
                            <label for="contact_email" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Contact Email
                            </label>

                            <div class="relative">
                                <i
                                    data-lucide="mail"
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none">
                                </i>

                                <input
                                    id="contact_email"
                                    type="email"
                                    name="contact_email"
                                    value="{{ old('contact_email', $email['contact_email'] ?? '') }}"
                                    maxlength="100"
                                    placeholder="info@dharamshalatravels.com"
                                    autocomplete="email"
                                    inputmode="email"
                                    class="w-full pl-10 pr-3 py-3 bg-white border @error('contact_email') border-red-400 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            </div>

                            <p class="email-desk-helper text-[11px] text-slate-400 mt-1 leading-relaxed">
                                Main email address customers can use for enquiries and support.
                            </p>
                        </div>

                        {{-- ADMIN NOTIFICATION EMAILS --}}
                        <div>
                            <label for="admin_notification_emails" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Admin Notification Emails
                            </label>

                            <textarea
                                id="admin_notification_emails"
                                name="admin_notification_emails"
                                rows="4"
                                maxlength="2000"
                                spellcheck="false"
                                placeholder="owner@example.com, bookings@example.com"
                                class="w-full px-3 py-3 bg-white border @error('admin_notification_emails') border-red-400 @else border-slate-300 @enderror rounded-lg text-sm leading-relaxed focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-y">{{ old('admin_notification_emails', $email['admin_notification_emails'] ?? '') }}</textarea>

                            <p class="email-desk-helper text-[11px] text-slate-400 mt-1 leading-relaxed">
                                Every new booking and contact enquiry is emailed to these addresses. Separate multiple emails with commas or new lines.
                                Leave empty to use the Contact Email above.
                            </p>

                            <div class="mt-2 p-3 rounded-lg bg-slate-50 border border-slate-200">
                                <p class="text-[11px] text-slate-500 leading-relaxed">
                                    Currently sending to:
                                    <strong class="text-slate-700 break-words">{{ implode(', ', \App\Support\AdminNotifier::recipients()) ?: 'no valid email set' }}</strong>
                                </p>
                            </div>
                        </div>

                        {{-- RESPONSE TIME --}}
                        <div>
                            <label for="contact_email_response" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Email Response Time
                            </label>

                            <div class="relative">
                                <i
                                    data-lucide="clock-3"
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none">
                                </i>

                                <input
                                    id="contact_email_response"
                                    type="text"
                                    name="contact_email_response"
                                    value="{{ old('contact_email_response', $email['contact_email_response'] ?? '') }}"
                                    maxlength="100"
                                    placeholder="Response within 2 hours"
                                    class="w-full pl-10 pr-3 py-3 bg-white border @error('contact_email_response') border-red-400 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            </div>

                            <p class="email-desk-helper text-[11px] text-slate-400 mt-1 leading-relaxed">
                                Example: Response within 2 hours
                            </p>
                        </div>

                        {{-- SAVE --}}
                        <div class="email-desk-save-row flex justify-end pt-2">
                            <button
                                type="submit"
                                class="email-desk-save inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-white font-semibold px-5 py-2.5 rounded-lg text-sm transition">
                                <i data-lucide="save" class="w-4 h-4 shrink-0"></i>
                                <span>Save Email Desk</span>
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
