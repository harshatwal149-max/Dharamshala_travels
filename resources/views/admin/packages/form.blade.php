@php
use App\Support\Media;

$isEdit = isset($package) && $package?->exists;
$siteTitle = \App\Models\Setting::get('site_title', 'Dharamshala Travels');

// Stored itinerary ['Day 1' => 'Title. Description'] -> editable rows.
$storedItinerary = $isEdit ? $package->itinerary : null;
if (is_string($storedItinerary)) {
$storedItinerary = json_decode($storedItinerary, true) ?? $storedItinerary;
}

if (is_array($storedItinerary)) {
$itineraryRows = collect($storedItinerary)->map(function ($text, $key) {
$text = is_array($text) ? implode(', ', $text) : trim((string) $text);
$title = '';

if (preg_match('/^([^.,]{3,60})\.\s+(.+)$/s', $text, $m)) {
[$title, $text] = [$m[1], $m[2]];
}

return ['label' => is_numeric($key) ? 'Day ' . ($key + 1) : (string) $key, 'title' => $title, 'text' => $text];
})->values()->all();
} elseif (filled($storedItinerary) && $storedItinerary !== $package->short_desc) {
$itineraryRows = [['label' => 'Overview', 'title' => '', 'text' => (string) $storedItinerary]];
} else {
$itineraryRows = [];
}

$itineraryRows = old('itinerary', $itineraryRows ?: [['label' => 'Day 1', 'title' => '', 'text' => '']]);

$inclusionPresets = [
'Transport' => [
'Private AC cab for all transfers & sightseeing',
'Dedicated cab for the full trip',
'Experienced local driver',
'Airport / railway station pickup & drop',
'Fuel, tolls & parking',
'State taxes & driver allowance',
],
'Stay & meals' => [
'Hotel stay',
'Hotel stay with breakfast',
'Breakfast & dinner',
'All meals on the trek',
],
'Sightseeing & activities' => [
'All sightseeing as per itinerary',
'Local guide',
'Certified trek leader',
'Tent, sleeping bag & mat',
'Forest entry permissions',
'Help booking paragliding with a certified pilot',
],
];

$durationPresets = [
'Half Day (4 Hours)', 'Full Day (8 Hours)', '2 Days / 1 Night', '3 Days / 2 Nights',
'4 Days / 3 Nights', '5 Days / 4 Nights', '6 Days / 5 Nights', '7 Days / 6 Nights', '8 Days / 7 Nights',
];

$images = [
'thumbnail' => ['label' => 'Cover photo', 'hint' => 'Shown on tour cards and at the top of the tour page.'],
'image_2' => ['label' => 'Gallery photo 1', 'hint' => null],
'image_3' => ['label' => 'Gallery photo 2', 'hint' => null],
'image_4' => ['label' => 'Gallery photo 3', 'hint' => null],
'image_5' => ['label' => 'Gallery photo 4', 'hint' => null],
];

$initial = [
'title' => old('title', $package->title ?? ''),
'duration' => old('duration', $package->duration ?? ''),
'shortDesc' => old('short_desc', $package->short_desc ?? ''),
'isFeatured' => (bool) old('is_featured', $isEdit ? $package->is_featured : true),
'days' => array_values($itineraryRows),
'inclusions' => array_values(old('inclusions', $isEdit ? $package->inclusion_list : [])),
'thumb' => $isEdit ? Media::url($package->thumbnail) : null,
];

$inputClass = 'w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20';
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $isEdit ? 'Edit Tour - ' . $package->title : 'Add New Tour - ' . $siteTitle }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            min-width: 320px;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-width: 320px;
        }

        [x-cloak] {
            display: none !important;
        }

        input,
        textarea,
        select,
        button {
            max-width: 100%;
        }

        input,
        textarea {
            min-width: 0;
        }

        .package-main {
            min-width: 0;
            width: 100%;
        }

        .package-content {
            min-width: 0;
        }

        .package-content>* {
            min-width: 0;
        }

        .package-sticky-actions {
            padding-bottom: max(.75rem, env(safe-area-inset-bottom));
        }

        #adminSidebar {
            transition: transform .25s ease, width .25s ease;
        }

        #adminSidebarOverlay {
            display: none;
        }

        @media (max-width: 767px) {
            #adminSidebar {
                position: fixed !important;
                inset: 0 auto 0 0 !important;
                width: min(18rem, 85vw) !important;
                max-width: 85vw !important;
                height: 100dvh !important;
                z-index: 50 !important;
                transform: translateX(-105%);
            }

            body.admin-sidebar-mobile-open #adminSidebar {
                transform: translateX(0);
            }

            #adminSidebarOverlay {
                position: fixed;
                inset: 0;
                z-index: 40;
                background: rgba(15, 23, 42, .5);
                cursor: pointer;
            }

            body.admin-sidebar-mobile-open #adminSidebarOverlay {
                display: block;
            }

            #adminMainContent {
                width: 100%;
                height: 100dvh;
            }

            #adminTopHeader {
                flex-wrap: wrap;
            }

            #adminMainContent>form {
                min-width: 0;
            }

            .package-sticky-actions {
                position: sticky;
                bottom: 0;
            }
        }

        @media (max-width: 639px) {
            .package-content {
                padding: 1rem;
                gap: 1rem;
            }

            .package-header {
                padding: .875rem 1rem;
                align-items: flex-start;
            }

            .package-header-actions {
                width: 100%;
                display: grid;
                grid-template-columns: 1fr;
            }

            .package-header-actions a {
                justify-content: center;
            }

            .package-section-body {
                padding: 1rem;
            }

            .package-sticky-actions {
                align-items: stretch;
            }

            .package-sticky-actions>p {
                width: 100%;
            }

            .package-sticky-actions>div {
                width: 100%;
                display: grid;
                grid-template-columns: 1fr;
            }

            .package-sticky-actions>div>* {
                width: 100%;
                justify-content: center;
            }

            .itinerary-day-label {
                width: min(9rem, 48vw);
            }
        }

        @media (min-width: 640px) and (max-width: 1023px) {
            .package-content {
                gap: 1.25rem;
            }
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased flex h-screen overflow-hidden">

    {{-- COMMON ADMIN SIDEBAR --}}
    @include('admin.partials.sidebar')
    <div id="adminSidebarOverlay" aria-hidden="true"></div>

    {{-- MAIN CONTENT --}}
    <div id="adminMainContent" class="package-main flex-1 flex flex-col overflow-y-auto min-w-0" x-data="packageForm(@js($initial))">

        {{-- TOP HEADER --}}
        <header id="adminTopHeader" class="package-header bg-white border-b border-slate-200 px-4 sm:px-6 py-4 flex flex-wrap items-center justify-between gap-3 sticky top-0 z-30">
            <div class="flex items-start gap-2 min-w-0">
                <button id="adminMobileMenuToggle" type="button"
                    class="md:hidden inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 bg-white text-slate-700 shrink-0"
                    aria-label="Open admin menu" aria-expanded="false">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div class="min-w-0">
                    <div class="flex items-center gap-2 text-xs text-slate-500 flex-wrap">
                        <span>Admin</span>
                        <span>/</span>
                        <a href="{{ route('admin.tours.index') }}" class="hover:text-slate-700">Tours</a>
                        <span>/</span>
                        <span class="text-slate-700 font-semibold">{{ $isEdit ? 'Edit Tour' : 'Add New Tour' }}</span>
                    </div>

                    <h1 class="text-lg font-bold text-slate-900 mt-1 break-words">
                        {{ $isEdit ? 'Edit: ' . $package->title : 'Add New Tour' }}
                    </h1>
                </div>
            </div>

            <div class="package-header-actions flex flex-wrap items-center gap-2">
                @if($isEdit)
                <a href="{{ route('tours.show', $package->slug) }}" target="_blank"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition">
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i> View on website
                </a>
                @endif

                <a href="{{ route('admin.tours.index') }}"
                    class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Back to Tours
                </a>
            </div>
        </header>

        <form action="{{ $isEdit ? route('admin.packages.update', $package) : route('admin.packages.store') }}"
            method="POST" enctype="multipart/form-data" class="flex-1 flex flex-col"
            x-ref="form" @input="dirty = true" @change="dirty = true" @submit="if (submitting) { $event.preventDefault(); return; } submitting = true">

            @csrf
            @if($isEdit)
            @method('PUT')
            @endif

            <div class="package-content p-4 sm:p-6 grid grid-cols-1 xl:grid-cols-3 gap-6 items-start flex-1">

                {{-- ================= LEFT: FORM SECTIONS ================= --}}
                <div class="xl:col-span-2 space-y-6 min-w-0">

                    @if(session('success'))
                    <div class="flex items-center gap-2 p-4 rounded-xl border border-emerald-200 bg-emerald-50 text-sm font-semibold text-emerald-800">
                        <i data-lucide="check-circle" class="w-4 h-4"></i> {{ session('success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="p-4 rounded-xl border border-red-200 bg-red-50">
                        <p class="text-sm font-bold text-red-700">Please fix the following and save again:</p>
                        <ul class="mt-2 text-xs text-red-600 space-y-1 list-disc pl-5">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        @if(! $isEdit || collect(array_keys($images))->contains(fn ($f) => $errors->has($f . '_file')))
                        <p class="mt-2 text-xs text-red-600">Selected photos are not kept after an error. Please choose them again.</p>
                        @endif
                    </div>
                    @endif

                    {{-- 1. BASIC DETAILS --}}
                    <section class="bg-white rounded-xl border border-slate-200 shadow-sm">
                        <div class="px-5 sm:px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                            <span class="w-7 h-7 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold flex items-center justify-center">1</span>
                            <div>
                                <h2 class="text-sm font-bold text-slate-900">Basic details</h2>
                                <p class="text-xs text-slate-500">Name, length and a short summary of the tour.</p>
                            </div>
                        </div>

                        <div class="package-section-body p-5 sm:p-6 space-y-5">
                            {{-- Title --}}
                            <div>
                                <label for="title" class="block text-xs font-bold text-slate-700 mb-1.5">Tour title <span class="text-red-500">*</span></label>
                                <input id="title" type="text" name="title" x-model="title" required maxlength="150"
                                    placeholder="e.g. Kangra Valley, Dalhousie & Chamba Tour"
                                    class="{{ $inputClass }} @error('title') border-red-400 @enderror">
                                @error('title')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                @if($isEdit)
                                <p class="mt-1 text-[11px] text-slate-500">Page link: <span class="font-mono">/tours/{{ $package->slug }}</span> (stays the same when you rename the tour)</p>
                                @endif
                            </div>

                            {{-- Duration --}}
                            <div>
                                <label for="duration" class="block text-xs font-bold text-slate-700 mb-1.5">Duration <span class="text-red-500">*</span></label>
                                <input id="duration" type="text" name="duration" x-model="duration" required maxlength="50"
                                    placeholder="e.g. 6 Days / 5 Nights"
                                    class="{{ $inputClass }} @error('duration') border-red-400 @enderror">
                                @error('duration')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror

                                <div class="mt-2 flex flex-wrap gap-1.5">
                                    @foreach($durationPresets as $preset)
                                    <button type="button" @click="duration = @js($preset); dirty = true"
                                        :class="duration === @js($preset) ? 'bg-emerald-700 text-white border-emerald-700' : 'bg-white text-slate-600 border-slate-200 hover:border-emerald-600 hover:text-emerald-700'"
                                        class="px-2.5 py-1 rounded-full border text-[11px] font-semibold transition">{{ $preset }}</button>
                                    @endforeach
                                </div>

                                <p x-show="suggestedDuration && suggestedDuration !== duration" x-cloak class="mt-2 text-[11px] text-amber-700">
                                    Your itinerary has <span x-text="filledDays"></span> days.
                                    <button type="button" class="font-semibold underline" @click="duration = suggestedDuration; dirty = true">
                                        Use “<span x-text="suggestedDuration"></span>”
                                    </button>
                                </p>
                            </div>

                            {{-- Short description --}}
                            <div>
                                <div class="flex items-end justify-between mb-1.5">
                                    <label for="short_desc" class="block text-xs font-bold text-slate-700">Short description <span class="text-red-500">*</span></label>
                                    <span class="text-[11px]" :class="shortDesc.length > 230 ? 'text-amber-600 font-semibold' : 'text-slate-400'">
                                        <span x-text="shortDesc.length"></span>/255
                                    </span>
                                </div>
                                <textarea id="short_desc" name="short_desc" x-model="shortDesc" required rows="3" maxlength="255"
                                    placeholder="Route and highlights in 1–2 lines, e.g. Tour route: Chandigarh - Shimla - Manali - Dharamshala..."
                                    class="{{ $inputClass }} resize-none @error('short_desc') border-red-400 @enderror"></textarea>
                                @error('short_desc')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                <p class="mt-1 text-[11px] text-slate-500">Shown on tour cards and under the title on the tour page.</p>
                            </div>
                        </div>
                    </section>

                    {{-- 2. ITINERARY --}}
                    <section class="bg-white rounded-xl border border-slate-200 shadow-sm">
                        <div class="px-5 sm:px-6 py-4 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold flex items-center justify-center">2</span>
                                <div>
                                    <h2 class="text-sm font-bold text-slate-900">Day-wise itinerary</h2>
                                    <p class="text-xs text-slate-500">One card per day (or Morning / Afternoon for day trips).</p>
                                </div>
                            </div>
                            <button type="button" @click="importOpen = !importOpen"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                <i data-lucide="clipboard-paste" class="w-3.5 h-3.5"></i> Paste itinerary text
                            </button>
                        </div>

                        <div class="package-section-body p-5 sm:p-6 space-y-4">
                            {{-- Paste & import --}}
                            <div x-show="importOpen" x-cloak class="p-4 rounded-xl border border-dashed border-emerald-300 bg-emerald-50/50 space-y-3">
                                <p class="text-xs text-slate-600">
                                    Paste an itinerary from WhatsApp, Word or email. Lines starting with <strong>Day 1</strong>, <strong>Day 2</strong>… start a new day;
                                    the lines below each day (e.g. <em>- McLeod Ganj</em>) become its sightseeing list.
                                </p>
                                <textarea x-model="importText" rows="7" class="{{ $inputClass }} font-mono text-xs"
                                    placeholder="Day 1 – Dharamshala&#10;- Dharamshala local sightseeing&#10;- McLeod Ganj&#10;Day 2 – Baijnath / Bir&#10;- Baijnath Temple&#10;- Bir Billing"></textarea>
                                <div class="flex flex-wrap items-center gap-2">
                                    <button type="button" @click="importItinerary(true)" :disabled="!importText.trim()"
                                        class="px-3 py-1.5 rounded-lg bg-emerald-700 text-white text-xs font-semibold hover:bg-emerald-800 disabled:opacity-50">Replace current days</button>
                                    <button type="button" @click="importItinerary(false)" :disabled="!importText.trim()"
                                        class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 disabled:opacity-50">Add after current days</button>
                                    <button type="button" @click="importOpen = false" class="px-3 py-1.5 text-xs font-semibold text-slate-500 hover:text-slate-700">Close</button>
                                </div>
                            </div>

                            @error('itinerary')<p class="text-xs text-red-600">{{ $message }}</p>@enderror

                            <datalist id="itinerary-labels">
                                <option value="Morning"></option>
                                <option value="Midday"></option>
                                <option value="Afternoon"></option>
                                <option value="Evening"></option>
                                <option value="Overview"></option>
                            </datalist>

                            <template x-for="(day, index) in days" :key="day.uid">
                                <div class="rounded-xl border border-slate-200 bg-slate-50/60">
                                    <div class="flex items-center justify-between gap-2 px-4 py-2.5 border-b border-slate-200">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <span class="w-6 h-6 shrink-0 rounded-full bg-emerald-700 text-white text-[11px] font-bold flex items-center justify-center" x-text="index + 1"></span>
                                            <input type="text" :name="`itinerary[${index}][label]`" x-model="day.label" maxlength="30"
                                                list="itinerary-labels" placeholder="Day 1"
                                                class="itinerary-day-label w-36 max-w-full rounded-md border border-transparent bg-transparent px-2 py-1 text-sm font-bold text-slate-800 hover:border-slate-300 focus:border-emerald-600 focus:bg-white outline-none">
                                        </div>
                                        <div class="flex items-center gap-0.5 text-slate-400">
                                            <button type="button" @click="moveDay(index, -1)" :disabled="index === 0" title="Move up"
                                                class="p-1.5 rounded-md hover:bg-white hover:text-slate-700 disabled:opacity-30 disabled:hover:bg-transparent"><i data-lucide="arrow-up" class="w-4 h-4"></i></button>
                                            <button type="button" @click="moveDay(index, 1)" :disabled="index === days.length - 1" title="Move down"
                                                class="p-1.5 rounded-md hover:bg-white hover:text-slate-700 disabled:opacity-30 disabled:hover:bg-transparent"><i data-lucide="arrow-down" class="w-4 h-4"></i></button>
                                            <button type="button" @click="removeDay(index)" title="Remove day"
                                                class="p-1.5 rounded-md hover:bg-red-50 hover:text-red-600"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                        </div>
                                    </div>
                                    <div class="p-4 space-y-3">
                                        <div>
                                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Heading <span class="font-normal text-slate-400">(route or place)</span></label>
                                            <input type="text" :name="`itinerary[${index}][title]`" x-model="day.title" maxlength="80"
                                                placeholder="e.g. Shimla - Manali (250 km / 8 hrs)" class="{{ $inputClass }}">
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Plan &amp; sightseeing</label>
                                            <textarea :name="`itinerary[${index}][text]`" x-model="day.text" rows="3" maxlength="2000"
                                                placeholder="e.g. After breakfast visit Hadimba Devi Temple, Vashisht hot springs and Mall Road. Overnight in Manali."
                                                class="{{ $inputClass }}"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <p x-show="days.length === 0" x-cloak class="py-6 text-center text-xs text-slate-500">No days added yet.</p>

                            <button type="button" @click="addDay()"
                                class="w-full flex items-center justify-center gap-2 py-3 rounded-xl border-2 border-dashed border-slate-300 text-sm font-semibold text-slate-600 hover:border-emerald-600 hover:text-emerald-700 transition">
                                <i data-lucide="plus" class="w-4 h-4"></i> Add <span x-text="nextDayLabel()"></span>
                            </button>
                        </div>
                    </section>

                    {{-- 3. INCLUSIONS --}}
                    <section class="bg-white rounded-xl border border-slate-200 shadow-sm">
                        <div class="px-5 sm:px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                            <span class="w-7 h-7 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold flex items-center justify-center">3</span>
                            <div>
                                <h2 class="text-sm font-bold text-slate-900">What's included</h2>
                                <p class="text-xs text-slate-500">Tick common items or add your own.</p>
                            </div>
                        </div>

                        <div class="package-section-body p-5 sm:p-6 space-y-5">
                            @foreach($inclusionPresets as $group => $items)
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">{{ $group }}</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($items as $item)
                                    <button type="button" @click="toggleInclusion(@js($item))"
                                        :class="hasInclusion(@js($item)) ? 'bg-emerald-50 border-emerald-600 text-emerald-800' : 'bg-white border-slate-200 text-slate-600 hover:border-slate-400'"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-medium transition">
                                        <span class="w-3.5 h-3.5 rounded border flex items-center justify-center"
                                            :class="hasInclusion(@js($item)) ? 'bg-emerald-600 border-emerald-600 text-white' : 'border-slate-300'">
                                            <svg x-show="hasInclusion(@js($item))" class="w-2.5 h-2.5" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M2.5 6.5l2.5 2.5 4.5-6" />
                                            </svg>
                                        </span>
                                        {{ $item }}
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach

                            <div>
                                <label for="custom-inclusion" class="block text-xs font-bold text-slate-700 mb-1.5">Add your own</label>
                                <div class="flex gap-2">
                                    <input id="custom-inclusion" type="text" x-model="customInclusion" maxlength="150"
                                        @keydown.enter.prevent="addCustomInclusion()"
                                        placeholder="e.g. Rohtang Pass permit" class="{{ $inputClass }}">
                                    <button type="button" @click="addCustomInclusion()"
                                        class="shrink-0 px-4 rounded-lg bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800">Add</button>
                                </div>
                            </div>

                            <div class="rounded-xl bg-slate-50 border border-slate-200 p-4">
                                <p class="text-xs font-bold text-slate-700 mb-2">
                                    Selected (<span x-text="inclusions.length"></span>)
                                </p>
                                <p x-show="inclusions.length === 0" class="text-xs text-slate-500">
                                    Nothing selected yet.@unless($isEdit) If left empty, a default cab inclusion list is used.@endunless
                                </p>
                                <ul class="space-y-1.5">
                                    <template x-for="(item, i) in inclusions" :key="item">
                                        <li class="flex items-center justify-between gap-2 bg-white rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-700">
                                            <span class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600"></i><span x-text="item"></span></span>
                                            <input type="hidden" name="inclusions[]" :value="item">
                                            <button type="button" @click="inclusions.splice(i, 1); dirty = true" class="text-slate-400 hover:text-red-600" title="Remove">
                                                <svg class="w-3.5 h-3.5" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.8">
                                                    <path d="M3 3l6 6M9 3l-6 6" />
                                                </svg>
                                            </button>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </section>

                    {{-- 4. PHOTOS --}}
                    <section class="bg-white rounded-xl border border-slate-200 shadow-sm">
                        <div class="px-5 sm:px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                            <span class="w-7 h-7 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold flex items-center justify-center">4</span>
                            <div>
                                <h2 class="text-sm font-bold text-slate-900">Photos</h2>
                                <p class="text-xs text-slate-500">Drag &amp; drop, click to upload, or paste an image link. JPG, PNG or WEBP, max 3 MB. Landscape photos look best.</p>
                            </div>
                        </div>

                        <div class="package-section-body p-5 sm:p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($images as $field => $meta)
                            @php
                            $isCover = $field === 'thumbnail';
                            $current = $isEdit ? Media::url($package->{$field}) : null;
                            @endphp
                            <div x-data="imageSlot(@js(['field' => $field, 'current' => $current, 'url' => old($field, ''), 'cover' => $isCover]))"
                                class="{{ $isCover ? 'sm:col-span-2 lg:col-span-4' : '' }}">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-bold text-slate-700">{{ $meta['label'] }} @if($isCover)<span class="text-red-500">*</span>@endif</span>
                                    <span x-show="status" x-cloak class="text-[10px] font-semibold" :class="removed ? 'text-red-600' : 'text-emerald-600'" x-text="status"></span>
                                </div>

                                <div @dragover.prevent="dragging = true" @dragleave.prevent="dragging = false" @drop.prevent="drop($event)"
                                    @click="if (!preview) $refs.file.click()"
                                    :class="[dragging ? 'border-emerald-600 bg-emerald-50' : 'border-slate-300 bg-slate-50', preview ? '' : 'cursor-pointer hover:border-emerald-600']"
                                    class="relative overflow-hidden rounded-xl border-2 border-dashed {{ $isCover ? 'aspect-[21/9]' : 'aspect-[4/3]' }}">

                                    <template x-if="preview">
                                        <img :src="preview" alt="" class="absolute inset-0 w-full h-full object-cover" @@error="preview = null; error = 'Could not load this image link.'">
                                    </template>

                                    <div x-show="!preview" class="absolute inset-0 flex flex-col items-center justify-center gap-1.5 p-3 text-center text-slate-500">
                                        <i data-lucide="image-plus" class="w-6 h-6"></i>
                                        <span class="text-xs font-semibold">Drop photo or click to upload</span>
                                        @if($meta['hint'])<span class="text-[11px] text-slate-400">{{ $meta['hint'] }}</span>@endif
                                    </div>

                                    <div x-show="preview" x-cloak class="absolute inset-x-0 bottom-0 flex gap-1.5 p-2 bg-gradient-to-t from-black/60 to-transparent">
                                        <button type="button" @click.stop="$refs.file.click()"
                                            class="flex-1 px-2 py-1.5 rounded-md bg-white/95 text-[11px] font-semibold text-slate-800 hover:bg-white">Replace</button>
                                        @unless($isCover)
                                        <button type="button" @click.stop="remove()"
                                            class="px-2 py-1.5 rounded-md bg-white/95 text-[11px] font-semibold text-red-600 hover:bg-white">Remove</button>
                                        @endunless
                                        <button type="button" x-show="fileName || url" @click.stop="reset()"
                                            class="px-2 py-1.5 rounded-md bg-white/95 text-[11px] font-semibold text-slate-600 hover:bg-white">Undo</button>
                                    </div>
                                </div>

                                <input type="file" name="{{ $field }}_file" x-ref="file" accept=".jpg,.jpeg,.png,.webp" class="hidden" @change="pick($event.target.files[0])">
                                <template x-if="removed"><input type="hidden" name="remove_images[]" value="{{ $field }}"></template>

                                <p x-show="removed" x-cloak class="mt-1.5 text-[11px] text-red-600">
                                    Will be removed when you save. <button type="button" class="font-semibold underline" @click="reset()">Undo</button>
                                </p>

                                <div class="mt-2">
                                    <button type="button" x-show="!showUrl" @click="showUrl = true" class="text-[11px] font-semibold text-emerald-700 hover:underline">or paste image link</button>
                                    <input x-show="showUrl" x-cloak type="url" name="{{ $field }}" x-model="url" @input.debounce.400ms="useUrl()"
                                        placeholder="https://..." class="{{ $inputClass }} text-xs py-2">
                                </div>

                                <p x-show="error" x-cloak x-text="error" class="mt-1 text-[11px] text-red-600"></p>
                                @error($field)<p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>@enderror
                                @error($field . '_file')<p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>@enderror
                            </div>
                            @endforeach
                        </div>
                    </section>
                </div>

                {{-- ================= RIGHT: PREVIEW & PUBLISH ================= --}}
                <aside class="space-y-6 xl:sticky xl:top-6">

                    {{-- Visibility --}}
                    <section class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                        <h2 class="text-sm font-bold text-slate-900 mb-3">Visibility</h2>
                        <label class="flex items-start justify-between gap-4 cursor-pointer">
                            <span>
                                <span class="block text-xs font-semibold text-slate-700">Show on homepage</span>
                                <span class="block text-[11px] text-slate-500 mt-0.5">Featured tours appear on the homepage. All tours are always listed on the Tours page.</span>
                            </span>
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" name="is_featured" value="1" x-model="isFeatured" class="sr-only peer">
                            <span class="relative shrink-0 w-10 h-6 rounded-full bg-slate-300 transition peer-checked:bg-emerald-600 after:absolute after:top-0.5 after:left-0.5 after:w-5 after:h-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-4"></span>
                        </label>
                    </section>

                    {{-- Live preview --}}
                    <section class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                        <h2 class="text-sm font-bold text-slate-900 mb-3">Card preview</h2>
                        <div class="overflow-hidden rounded-xl border border-slate-200">
                            <div class="relative aspect-[4/3] bg-slate-100">
                                <img x-show="thumb" :src="thumb" alt="" class="absolute inset-0 w-full h-full object-cover">
                                <div x-show="!thumb" class="absolute inset-0 flex items-center justify-center text-slate-400"><i data-lucide="image" class="w-8 h-8"></i></div>
                                <span x-show="duration" class="absolute left-3 top-3 rounded-full bg-slate-900/80 px-2.5 py-1 text-[11px] font-semibold text-white" x-text="duration"></span>
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-slate-900 leading-snug" x-text="title || 'Tour title'"></h3>
                                <p class="mt-1 text-xs text-slate-500 line-clamp-3" x-text="shortDesc || 'Short description will appear here.'"></p>
                            </div>
                        </div>
                    </section>

                    {{-- Checklist --}}
                    <section class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-sm font-bold text-slate-900">Checklist</h2>
                            <span class="text-[11px] font-semibold text-slate-500"><span x-text="checklist.filter(c => c.done).length"></span>/<span x-text="checklist.length"></span></span>
                        </div>
                        <ul class="space-y-2">
                            <template x-for="item in checklist" :key="item.label">
                                <li class="flex items-center gap-2 text-xs" :class="item.done ? 'text-slate-700' : 'text-slate-400'">
                                    <span class="w-4 h-4 rounded-full flex items-center justify-center" :class="item.done ? 'bg-emerald-600 text-white' : 'border border-slate-300'">
                                        <svg x-show="item.done" class="w-2.5 h-2.5" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M2.5 6.5l2.5 2.5 4.5-6" />
                                        </svg>
                                    </span>
                                    <span x-text="item.label"></span>
                                    <span x-show="item.required && !item.done" class="text-[10px] font-semibold text-red-500">required</span>
                                </li>
                            </template>
                        </ul>
                    </section>
                </aside>
            </div>

            {{-- STICKY ACTION BAR --}}
            <div class="package-sticky-actions sticky bottom-0 z-20 border-t border-slate-200 bg-white/95 backdrop-blur px-4 sm:px-6 py-3 flex flex-wrap items-center justify-between gap-3">
                <p class="text-xs" :class="dirty ? 'text-amber-600 font-semibold' : 'text-slate-400'"
                    x-text="dirty ? 'You have unsaved changes' : '{{ $isEdit ? 'All changes saved' : 'Fill in the details and publish' }}'"></p>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.tours.index') }}"
                        class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">Cancel</a>

                    @if($isEdit)
                    <button type="submit" name="after_save" value="stay" :class="submitting && 'opacity-60 pointer-events-none'"
                        class="px-4 py-2.5 rounded-lg border border-emerald-700 text-emerald-700 text-sm font-semibold hover:bg-emerald-50 transition disabled:opacity-60">
                        Save &amp; keep editing
                    </button>
                    @endif

                    <button type="submit" :class="submitting && 'opacity-60 pointer-events-none'"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold shadow-sm transition disabled:opacity-60">
                        <svg x-show="submitting" x-cloak class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity=".3" stroke-width="3" />
                            <path d="M21 12a9 9 0 00-9-9" stroke="currentColor" stroke-width="3" />
                        </svg>
                        <span x-text="submitting ? 'Saving…' : '{{ $isEdit ? 'Save changes' : 'Publish tour' }}'"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        const MAX_IMAGE_BYTES = 3 * 1024 * 1024;
        let packageUid = 0;

        window.packageForm = (initial) => ({
            title: initial.title,
            duration: initial.duration,
            shortDesc: initial.shortDesc,
            isFeatured: initial.isFeatured,
            days: initial.days.map((d) => ({
                uid: ++packageUid,
                label: d.label || '',
                title: d.title || '',
                text: d.text || ''
            })),
            inclusions: initial.inclusions,
            customInclusion: '',
            thumb: initial.thumb,
            importOpen: false,
            importText: '',
            dirty: false,
            submitting: false,

            init() {
                window.addEventListener('beforeunload', (e) => {
                    if (this.dirty && !this.submitting) {
                        e.preventDefault();
                        e.returnValue = '';
                    }
                });
                window.addEventListener('cover-preview', (e) => {
                    this.thumb = e.detail;
                });
                this.$watch('days', () => this.$nextTick(() => window.lucide && lucide.createIcons()));
                this.$watch('inclusions', () => this.$nextTick(() => window.lucide && lucide.createIcons()));
            },

            get filledDays() {
                return this.days.filter((d) => /^day\s*\d+/i.test(d.label) && (d.title.trim() || d.text.trim())).length;
            },

            get suggestedDuration() {
                const n = this.filledDays;
                if (n < 2) return null;
                return `${n} Days / ${n - 1} Night${n - 1 === 1 ? '' : 's'}`;
            },

            get checklist() {
                return [{
                        label: 'Tour title',
                        done: !!this.title.trim(),
                        required: true
                    },
                    {
                        label: 'Duration',
                        done: !!this.duration.trim(),
                        required: true
                    },
                    {
                        label: 'Short description',
                        done: !!this.shortDesc.trim(),
                        required: true
                    },
                    {
                        label: 'Cover photo',
                        done: !!this.thumb,
                        required: true
                    },
                    {
                        label: 'At least one itinerary day',
                        done: this.days.some((d) => d.title.trim() || d.text.trim()),
                        required: false
                    },
                    {
                        label: 'Inclusions',
                        done: this.inclusions.length > 0,
                        required: false
                    },
                ];
            },

            // ---------- Itinerary ----------
            usesDayLabels() {
                return this.days.length === 0 || this.days.every((d) => /^day\s*\d+$/i.test(d.label.trim()));
            },

            nextDayLabel() {
                return this.usesDayLabels() ? `Day ${this.days.length + 1}` : 'section';
            },

            renumber() {
                if (!this.days.every((d) => /^day\s*\d+$/i.test(d.label.trim()))) return;
                this.days.forEach((d, i) => {
                    d.label = `Day ${i + 1}`;
                });
            },

            addDay(data = {}) {
                const label = data.label ?? (this.usesDayLabels() ? `Day ${this.days.length + 1}` : '');
                this.days.push({
                    uid: ++packageUid,
                    label,
                    title: data.title || '',
                    text: data.text || ''
                });
                this.dirty = true;
            },

            removeDay(index) {
                const d = this.days[index];
                if ((d.title.trim() || d.text.trim()) && !confirm(`Remove "${d.label || 'this day'}"?`)) return;
                this.days.splice(index, 1);
                this.renumber();
                this.dirty = true;
            },

            moveDay(index, step) {
                const target = index + step;
                if (target < 0 || target >= this.days.length) return;
                const [d] = this.days.splice(index, 1);
                this.days.splice(target, 0, d);
                this.renumber();
                this.dirty = true;
            },

            importItinerary(replace) {
                const parsed = [];
                let current = null;
                const items = () => current._items;

                this.importText.split(/\r?\n/).map((l) => l.trim()).filter(Boolean).forEach((line) => {
                    const m = line.match(/^(day\s*\d+)\s*[:\-–—.)]*\s*(.*)$/i);
                    if (m) {
                        current = {
                            label: m[1].replace(/\s+/, ' ').replace(/^day/i, 'Day'),
                            title: '',
                            _items: []
                        };
                        const rest = m[2].trim();
                        if (rest.length > 60) current._items.push(rest);
                        else current.title = rest;
                        parsed.push(current);
                        return;
                    }
                    if (!current) {
                        current = {
                            label: `Day ${parsed.length + 1}`,
                            title: '',
                            _items: []
                        };
                        parsed.push(current);
                    }
                    items().push(line.replace(/^[-•*·▪●]+\s*/, ''));
                });

                if (!parsed.length) return;

                if (replace) this.days = [];
                const offset = this.days.length;
                parsed.forEach((p, i) => {
                    const joined = p._items.join(', ').replace(/,\s*$/, '');
                    this.addDay({
                        label: replace ? p.label : (this.usesDayLabels() ? `Day ${offset + i + 1}` : p.label),
                        title: p.title.replace(/[.,]/g, ' ').replace(/\s+/g, ' ').trim(),
                        text: joined ? joined.replace(/\.?$/, '.') : '',
                    });
                });

                this.importText = '';
                this.importOpen = false;
            },

            // ---------- Inclusions ----------
            hasInclusion(item) {
                return this.inclusions.includes(item);
            },

            toggleInclusion(item) {
                const i = this.inclusions.indexOf(item);
                i === -1 ? this.inclusions.push(item) : this.inclusions.splice(i, 1);
                this.dirty = true;
            },

            addCustomInclusion() {
                const value = this.customInclusion.trim();
                if (value && !this.hasInclusion(value)) {
                    this.inclusions.push(value);
                    this.dirty = true;
                }
                this.customInclusion = '';
            },
        });

        window.imageSlot = (opts) => ({
            field: opts.field,
            cover: opts.cover,
            current: opts.current,
            preview: opts.current,
            url: opts.url,
            showUrl: !!opts.url,
            fileName: '',
            removed: false,
            dragging: false,
            error: '',

            init() {
                if (this.url) this.useUrl();
            },

            get status() {
                if (this.removed) return 'Will be removed';
                if (this.fileName) return 'New photo selected';
                if (this.url && this.preview === this.url) return 'Using image link';
                return this.current ? 'Current photo' : '';
            },

            notify() {
                if (this.cover) window.dispatchEvent(new CustomEvent('cover-preview', {
                    detail: this.preview
                }));
            },

            pick(file) {
                this.error = '';
                if (!file) return;
                if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
                    this.error = 'Please choose a JPG, PNG or WEBP image.';
                    this.$refs.file.value = '';
                    return;
                }
                if (file.size > MAX_IMAGE_BYTES) {
                    this.error = `This photo is ${(file.size / 1048576).toFixed(1)} MB. Max size is 3 MB.`;
                    this.$refs.file.value = '';
                    return;
                }
                this.fileName = file.name;
                this.removed = false;
                this.preview = URL.createObjectURL(file);
                this.notify();
            },

            drop(event) {
                this.dragging = false;
                const file = event.dataTransfer.files[0];
                if (!file) return;
                const transfer = new DataTransfer();
                transfer.items.add(file);
                this.$refs.file.files = transfer.files;
                this.pick(file);
                this.$dispatch('change');
            },

            useUrl() {
                this.error = '';
                if (this.fileName) return;
                if (/^https?:\/\/\S+$/i.test(this.url.trim())) {
                    this.removed = false;
                    this.preview = this.url.trim();
                } else {
                    this.preview = this.removed ? null : this.current;
                }
                this.notify();
            },

            remove() {
                this.$refs.file.value = '';
                this.fileName = '';
                this.url = '';
                this.showUrl = false;
                this.preview = null;
                this.removed = !!this.current;
                this.$dispatch('change');
                this.notify();
            },

            reset() {
                this.$refs.file.value = '';
                this.fileName = '';
                this.url = '';
                this.error = '';
                this.removed = false;
                this.preview = this.current;
                this.$dispatch('change');
                this.notify();
            },
        });

        document.addEventListener('DOMContentLoaded', () => {
            const menuToggle = document.getElementById('adminMobileMenuToggle');
            const sidebarOverlay = document.getElementById('adminSidebarOverlay');

            function closeMobileSidebar() {
                document.body.classList.remove('admin-sidebar-mobile-open');
                if (menuToggle) {
                    menuToggle.setAttribute('aria-expanded', 'false');
                    menuToggle.setAttribute('aria-label', 'Open admin menu');
                }
            }

            function toggleMobileSidebar() {
                const isOpen = document.body.classList.toggle('admin-sidebar-mobile-open');
                if (menuToggle) {
                    menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                    menuToggle.setAttribute('aria-label', isOpen ? 'Close admin menu' : 'Open admin menu');
                }
            }

            if (menuToggle) menuToggle.addEventListener('click', toggleMobileSidebar);
            if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeMobileSidebar);
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') closeMobileSidebar();
            });
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) closeMobileSidebar();
            });

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>

</body>

</html>