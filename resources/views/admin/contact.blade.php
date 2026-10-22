<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Basic Contact Information | Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>

    @if(file_exists(public_path('build/manifest.json')))
        @vite([
            'resources/css/app.css',
            'resources/js/app.js'
        ])
    @endif

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        * { box-sizing: border-box; }
        html { min-height: 100%; }
        body { font-family: 'Inter', sans-serif; min-height: 100vh; }
        .contact-admin-shell { min-width: 0; width: 100%; }
        .contact-admin-header { gap: 12px; flex-wrap: wrap; }
        .contact-admin-main { width: 100%; min-width: 0; }
        .contact-admin-card { min-width: 0; overflow-wrap: anywhere; }
        .contact-admin-card input, .contact-admin-card textarea { max-width: 100%; min-width: 0; }
        .contact-phone-row, .contact-phone-row > * { min-width: 0; }
        @media (max-width: 640px) {
            .contact-admin-header { height: auto !important; min-height: 4rem; padding: 12px 14px !important; align-items: flex-start; }
            .contact-admin-header a { max-width: 100%; white-space: normal; }
            .contact-admin-main { padding: 14px !important; }
            .contact-admin-card { padding: 16px !important; }
            .contact-phone-row { flex-direction: column; }
            .contact-phone-row > input, .contact-phone-row > div, .contact-phone-row > button { width: 100%; }
            .contact-phone-row > button { display: flex; justify-content: center; }
            .contact-save-row { justify-content: stretch !important; }
            .contact-save-row button { width: 100%; justify-content: center; }
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased flex min-h-screen overflow-x-hidden">

    @include('admin.partials.sidebar')

    <div class="contact-admin-shell flex-1 flex flex-col min-w-0">

        {{-- HEADER --}}
        <header class="contact-admin-header min-h-16 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between shrink-0 sticky top-0 z-30">

            <div class="flex items-center gap-2 text-xs">
                <span class="text-slate-400">Admin</span>
                <span class="text-slate-300">/</span>
                <span class="font-bold text-slate-800">
                    Basic Contact Information
                </span>
            </div>

            <a
                href="{{ route('admin.dashboard') }}"
                class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50">
                ← Back to Dashboard
            </a>

        </header>

        {{-- CONTENT --}}
        <main class="contact-admin-main flex-1 p-3 sm:p-4 lg:p-6">

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

                {{-- CONTACT FORM --}}
                <form
                    action="{{ route('admin.contact-information.update') }}"
                    method="POST">

                    @csrf

                    <div class="contact-admin-card bg-white rounded-xl border border-slate-200 shadow-sm p-4 sm:p-6 space-y-6">

                        {{-- TITLE --}}
                        <div>
                            <h1 class="text-base font-extrabold text-slate-900">
                                Basic Contact Information
                            </h1>

                            <p class="text-xs text-slate-500 mt-1">
                                Manage the main phone number, contact hours and office address shown on the website.
                            </p>
                        </div>

                        {{-- PHONE --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Contact Helpline
                            </label>

                            <div class="relative">

                                <i
                                    data-lucide="phone"
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400">
                                </i>

                                <input
                                    type="text"
                                    name="contact_phone"
                                    value="{{ old('contact_phone', $contact['contact_phone'] ?? '') }}"
                                    maxlength="50"
                                    placeholder="+91 98765 43210"
                                    class="w-full pl-10 pr-3 py-3 bg-white border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            </div>

                            <p class="text-[11px] text-slate-400 mt-1">
                                Main phone number customers can use to contact you. Shown first in the header and footer, and used for call buttons across the website.
                            </p>

                        </div>

                        {{-- ADDITIONAL PHONES --}}
                        @php
                            $extraPhones = old('extra_phones', $contact['extra_phones'] ?? []);
                            $phoneLabels = ['Booking', 'Office', 'Tours', 'Taxi Stand', 'WhatsApp', 'Emergency'];
                        @endphp
                        <div>

                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-700">
                                    Additional Phone Numbers
                                </label>
                                <span class="text-[11px] text-slate-400"><span data-phone-count>{{ count($extraPhones) }}</span>/10</span>
                            </div>

                            <p class="text-[11px] text-slate-400 mb-3">
                                Extra numbers shown in the header and footer after the main helpline. The label (e.g. Booking, Office) appears above the number.
                            </p>

                            <datalist id="phone-labels">
                                @foreach($phoneLabels as $phoneLabel)
                                    <option value="{{ $phoneLabel }}"></option>
                                @endforeach
                            </datalist>

                            <div class="space-y-2" data-phone-list>
                                @foreach($extraPhones as $i => $row)
                                    <div class="contact-phone-row flex flex-col sm:flex-row items-stretch sm:items-start gap-2" data-phone-row>
                                        <input type="text" name="extra_phones[{{ $i }}][label]" value="{{ $row['label'] ?? '' }}" maxlength="40" list="phone-labels"
                                            placeholder="Label (optional)"
                                            class="w-full sm:w-36 lg:w-44 sm:shrink-0 px-3 py-3 bg-white border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                        <div class="relative flex-1">
                                            <i data-lucide="phone" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                            <input type="tel" name="extra_phones[{{ $i }}][number]" value="{{ $row['number'] ?? '' }}" maxlength="30"
                                                placeholder="+91 98160 00000"
                                                class="w-full pl-10 pr-3 py-3 bg-white border @error('extra_phones.' . $i . '.number') border-red-400 @else border-slate-300 @enderror rounded-lg text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                        </div>
                                        <button type="button" data-phone-remove title="Remove number"
                                            class="shrink-0 p-3 rounded-lg border border-slate-300 text-slate-400 hover:text-red-600 hover:border-red-300 hover:bg-red-50">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <p class="text-[11px] text-slate-400 mt-2 {{ count($extraPhones) ? 'hidden' : '' }}" data-phone-empty>
                                No additional numbers yet.
                            </p>

                            <button type="button" data-phone-add
                                class="mt-3 inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-dashed border-slate-400 text-xs font-semibold text-slate-700 hover:border-blue-500 hover:text-blue-600 disabled:opacity-50 disabled:cursor-not-allowed">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                                Add another number
                            </button>

                            <template data-phone-template>
                                <div class="contact-phone-row flex flex-col sm:flex-row items-stretch sm:items-start gap-2" data-phone-row>
                                    <input type="text" data-name="label" maxlength="40" list="phone-labels" placeholder="Label (optional)"
                                        class="w-full sm:w-36 lg:w-44 sm:shrink-0 px-3 py-3 bg-white border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                    <div class="relative flex-1">
                                        <i data-lucide="phone" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                        <input type="tel" data-name="number" maxlength="30" placeholder="+91 98160 00000"
                                            class="w-full pl-10 pr-3 py-3 bg-white border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                    </div>
                                    <button type="button" data-phone-remove title="Remove number"
                                        class="shrink-0 p-3 rounded-lg border border-slate-300 text-slate-400 hover:text-red-600 hover:border-red-300 hover:bg-red-50">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </template>

                        </div>

                        {{-- HOURS --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Contact Hours
                            </label>

                            <div class="relative">

                                <i
                                    data-lucide="clock"
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400">
                                </i>

                                <input
                                    type="text"
                                    name="contact_hours"
                                    value="{{ old('contact_hours', $contact['contact_hours'] ?? '') }}"
                                    maxlength="100"
                                    placeholder="Available 6:00 AM – 11:00 PM"
                                    class="w-full pl-10 pr-3 py-3 bg-white border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            </div>

                            <p class="text-[11px] text-slate-400 mt-1">
                                Example: Available 6:00 AM – 11:00 PM
                            </p>

                        </div>

                        {{-- ADDRESS --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Office Address
                            </label>

                            <div class="relative">

                                <i
                                    data-lucide="map-pin"
                                    class="absolute left-3 top-3.5 w-4 h-4 text-slate-400">
                                </i>

                                <textarea
                                    name="contact_address"
                                    rows="4"
                                    maxlength="500"
                                    placeholder="Main Taxi Stand, Kotwali Bazar, Dharamshala, Himachal Pradesh 176215"
                                    class="w-full pl-10 pr-3 py-3 bg-white border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none">{{ old('contact_address', $contact['contact_address'] ?? '') }}</textarea>
                            </div>

                            <p class="text-[11px] text-slate-400 mt-1">
                                Full office or business address displayed to customers.
                            </p>

                        </div>

                        {{-- SAVE --}}
                        <div class="contact-save-row flex justify-end pt-2">

                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg text-xs transition">

                                <i data-lucide="save" class="w-4 h-4"></i>

                                Save Contact Information

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

        // Additional phone numbers: add / remove rows and keep input names in order.
        (function () {
            var MAX = 10;
            var list = document.querySelector('[data-phone-list]');
            var addBtn = document.querySelector('[data-phone-add]');
            var template = document.querySelector('[data-phone-template]');
            if (!list || !addBtn || !template) return;

            function refresh() {
                var rows = list.querySelectorAll('[data-phone-row]');
                rows.forEach(function (row, i) {
                    row.querySelectorAll('input').forEach(function (input) {
                        var field = input.dataset.name || input.name.replace(/^.*\[(\w+)\]$/, '$1');
                        input.dataset.name = field;
                        input.name = 'extra_phones[' + i + '][' + field + ']';
                    });
                });
                var countEl = document.querySelector('[data-phone-count]');
                var emptyEl = document.querySelector('[data-phone-empty]');
                if (countEl) countEl.textContent = rows.length;
                if (emptyEl) emptyEl.classList.toggle('hidden', rows.length > 0);
                addBtn.disabled = rows.length >= MAX;
            }

            addBtn.addEventListener('click', function () {
                list.appendChild(template.content.cloneNode(true));
                refresh();
                if (window.lucide) lucide.createIcons();
                var rows = list.querySelectorAll('[data-phone-row]');
                rows[rows.length - 1].querySelector('input[data-name="number"]').focus();
            });

            list.addEventListener('click', function (e) {
                var btn = e.target.closest('[data-phone-remove]');
                if (!btn) return;
                btn.closest('[data-phone-row]').remove();
                refresh();
            });

            refresh();
        })();
    </script>

</body>
</html>
