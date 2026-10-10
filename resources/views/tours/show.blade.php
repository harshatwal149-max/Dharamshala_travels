@extends('layouts.site')

@use('App\Support\Media')
@use('App\Models\Setting')

@php
    $gallery = collect([$package->thumbnail, $package->image_2, $package->image_3, $package->image_4, $package->image_5])
        ->filter()->map(fn ($img) => Media::url($img))->unique()->values();

    // Itinerary may be an array (seeder / admin "Day 1: ..." lines) or free text.
    $itinerary = $package->itinerary;
    if (is_string($itinerary)) {
        $itinerary = json_decode($itinerary, true) ?? $itinerary;
    }

    $days = collect(is_array($itinerary) ? $itinerary : [])->map(function ($text, $key) {
        $text = is_array($text) ? implode(', ', $text) : trim((string) $text);
        $title = null;

        // "Shimla - Manali (320 km / 8 hrs). After breakfast..." -> heading + body
        if (preg_match('/^([^.,]{3,60})\.\s+(.+)$/s', $text, $m)) {
            [$title, $text] = [$m[1], $m[2]];
        }

        return [
            'label' => is_numeric($key) ? 'Day ' . ($key + 1) : ucfirst($key),
            'title' => $title,
            'text'  => $text,
        ];
    })->values();

    $itineraryText = is_string($itinerary) ? $itinerary : null;
    $inclusions = $package->inclusion_list;

    $phone = Setting::get('contact_phone', '+91 98765 43210');

    $facts = array_filter([
        ['clock', 'Duration', $package->duration],
        ['indian-rupee', 'Starting from', (float) $package->starting_price > 0 ? '₹' . number_format((float) $package->starting_price) : null],
        ['compass', 'Trip type', $package->trip_type],
        ['car-front', 'Transport', 'Private cab & driver'],
    ], fn ($f) => filled($f[2]));
@endphp

@section('content')

@include('partials.page-hero', [
    'eyebrow'  => $package->duration ?: 'Tour package',
    'title'    => $package->title,
    'subtitle' => $package->short_desc,
    'image'    => $package->thumbnail ?: '/images/dharamshala/dhauladhar-alpenglow.jpg',
    'crumbs'   => ['Tour Packages' => route('tours.index'), $package->title => route('tours.show', $package->slug)],
])

{{-- Key facts --}}
<section class="border-b border-stone-200 bg-white">
    <div class="mx-auto grid max-w-7xl grid-cols-2 gap-4 px-4 py-6 sm:px-6 lg:grid-cols-4 lg:px-8">
        @foreach($facts as [$icon, $label, $value])
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-pine-50 text-pine-700"><i data-lucide="{{ $icon }}" class="h-5 w-5"></i></span>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wide text-stone-500">{{ $label }}</p>
                    <p class="truncate text-sm font-bold text-pine-950">{{ $value }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section class="bg-cream">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-12 lg:px-8 lg:py-16">

        <article class="min-w-0 lg:col-span-8">

            {{-- Gallery --}}
            @if($gallery->isNotEmpty())
                <div x-data="{ active: 0, images: @js($gallery) }" class="overflow-hidden rounded-2xl bg-white ring-1 ring-stone-200">
                    <div class="relative aspect-[16/9] bg-stone-100">
                        <img :src="images[active]" src="{{ $gallery->first() }}" alt="{{ $package->title }}"
                             class="h-full w-full object-cover"
                             onerror="this.onerror=null; this.src=@js(Media::url('/images/dharamshala/dhauladhar-alpenglow.jpg'))">
                        @if($gallery->count() > 1)
                            <button type="button" @click="active = (active - 1 + images.length) % images.length" aria-label="Previous photo"
                                    class="absolute left-3 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-pine-900 shadow transition hover:bg-white">
                                <i data-lucide="chevron-left" class="h-5 w-5"></i>
                            </button>
                            <button type="button" @click="active = (active + 1) % images.length" aria-label="Next photo"
                                    class="absolute right-3 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-pine-900 shadow transition hover:bg-white">
                                <i data-lucide="chevron-right" class="h-5 w-5"></i>
                            </button>
                            <span class="absolute bottom-3 right-3 rounded-full bg-pine-950/80 px-3 py-1 text-xs font-semibold text-white backdrop-blur">
                                <span x-text="active + 1">1</span> / {{ $gallery->count() }}
                            </span>
                        @endif
                    </div>

                    @if($gallery->count() > 1)
                        <div class="grid grid-cols-5 gap-2 p-3">
                            @foreach($gallery as $image)
                                <button type="button" @click="active = {{ $loop->index }}"
                                        :class="active === {{ $loop->index }} ? 'ring-2 ring-saffron-500' : 'opacity-70 hover:opacity-100'"
                                        class="aspect-[4/3] overflow-hidden rounded-lg transition">
                                    <img src="{{ $image }}" alt="{{ $package->title }} photo {{ $loop->iteration }}" loading="lazy" class="h-full w-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            {{-- Overview --}}
            @if($package->short_desc)
                <h2 class="mt-10 text-2xl font-extrabold text-pine-950">Tour overview</h2>
                <p class="mt-3 text-lg leading-relaxed text-stone-700">{{ $package->short_desc }}</p>
            @endif

            {{-- Itinerary --}}
            @if($days->isNotEmpty() || $itineraryText)
                <h2 class="mt-10 text-2xl font-extrabold text-pine-950">Day-wise itinerary</h2>

                @if($days->isNotEmpty())
                    <ol class="mt-6 space-y-0">
                        @foreach($days as $day)
                            <li class="relative flex gap-4 pb-8 last:pb-0">
                                @unless($loop->last)
                                    <span class="absolute left-5 top-11 bottom-0 w-px bg-pine-200" aria-hidden="true"></span>
                                @endunless
                                <span class="relative flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-pine-900 text-xs font-bold text-white ring-4 ring-cream">
                                    {{ preg_match('/\d+/', $day['label'], $n) ? $n[0] : $loop->iteration }}
                                </span>
                                <div class="min-w-0 flex-1 rounded-2xl bg-white p-5 ring-1 ring-stone-200">
                                    <p class="text-xs font-bold uppercase tracking-wider text-saffron-600">{{ $day['label'] }}</p>
                                    @if($day['title'])
                                        <h3 class="mt-1 text-lg font-bold text-pine-950">{{ $day['title'] }}</h3>
                                    @endif
                                    <p class="mt-2 text-sm leading-relaxed text-stone-600">{{ $day['text'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                @else
                    <div class="mt-4 whitespace-pre-line rounded-2xl bg-white p-5 text-sm leading-relaxed text-stone-600 ring-1 ring-stone-200">{{ $itineraryText }}</div>
                @endif
            @endif

            {{-- Inclusions --}}
            @if($inclusions)
                <h2 class="mt-10 text-2xl font-extrabold text-pine-950">What’s included</h2>
                <ul class="mt-4 grid gap-3 sm:grid-cols-2">
                    @foreach($inclusions as $inc)
                        <li class="flex items-start gap-3 rounded-xl bg-white p-4 text-sm text-stone-700 ring-1 ring-stone-200">
                            <i data-lucide="check-circle-2" class="mt-0.5 h-4 w-4 shrink-0 text-pine-500"></i>{{ $inc }}
                        </li>
                    @endforeach
                </ul>
            @endif

            <div class="mt-6 flex items-start gap-3 rounded-2xl border border-saffron-300 bg-saffron-300/20 p-4 text-sm text-pine-900">
                <i data-lucide="sliders-horizontal" class="mt-0.5 h-4 w-4 shrink-0 text-saffron-600"></i>
                <p><strong>Fully customisable.</strong> Change the days, stops or hotels — tell us what you want and we’ll plan the route around you. No middle-man, no commission.</p>
            </div>

            {{-- Review --}}
            <div class="mt-12 rounded-2xl bg-white p-6 ring-1 ring-stone-200 sm:p-8" x-data="{ photoName: null }">
                <h2 class="text-xl font-extrabold text-pine-950">Travelled with us? Leave a review</h2>
                <p class="mt-1 text-sm text-stone-500">Share your experience of this tour.</p>

                <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data" class="mt-5 space-y-4">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $package->id }}">

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-stone-600">Your name</label>
                            <input type="text" name="customer_name" required placeholder="e.g. Rahul Sharma" class="dt-input">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-stone-600">Rating</label>
                            <select name="rating" class="dt-input">
                                <option value="5">★★★★★ Excellent</option>
                                <option value="4">★★★★☆ Very good</option>
                                <option value="3">★★★☆☆ Average</option>
                                <option value="2">★★☆☆☆ Below average</option>
                                <option value="1">★☆☆☆☆ Poor</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-stone-600">Your feedback</label>
                        <textarea name="comment" rows="3" required placeholder="Describe your travel experience..." class="dt-input"></textarea>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <label class="inline-flex cursor-pointer items-center gap-2 text-sm font-semibold text-pine-700">
                            <i data-lucide="image-plus" class="h-4 w-4"></i>
                            <span x-text="photoName || 'Add a trip photo (optional)'">Add a trip photo (optional)</span>
                            <input type="file" name="image" accept="image/*" class="hidden" @change="photoName = $event.target.files[0]?.name ?? null">
                        </label>
                        <button type="submit" class="rounded-xl bg-pine-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-pine-800">
                            Submit review
                        </button>
                    </div>
                </form>
            </div>
        </article>

        {{-- Booking sidebar --}}
        <aside class="lg:col-span-4">
            <div class="sticky top-24 space-y-6">
                <div class="rounded-2xl bg-white p-6 shadow-lg shadow-pine-900/5 ring-1 ring-stone-200">
                    @if((float) $package->starting_price > 0)
                        <p class="text-xs font-semibold uppercase tracking-wide text-stone-500">Starting from</p>
                        <p class="mt-1 text-3xl font-extrabold text-pine-950">₹{{ number_format((float) $package->starting_price) }}</p>
                        <p class="text-xs text-stone-500">Final price depends on group size, hotels & vehicle.</p>
                    @else
                        <h2 class="text-lg font-extrabold text-pine-950">Book this tour</h2>
                    @endif

                    <form action="{{ route('bookings.store') }}" method="POST" class="mt-5 space-y-3">
                        @csrf
                        <input type="hidden" name="booking_type" value="tour_package">
                        <input type="hidden" name="package_id" value="{{ $package->id }}">

                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-stone-600">Your name</label>
                            <input type="text" name="customer_name" required placeholder="e.g. Amit Verma" class="dt-input">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-stone-600">Phone / WhatsApp</label>
                            <input type="tel" name="customer_phone" required placeholder="e.g. 98160XXXXX" class="dt-input">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-stone-600">Travel start date</label>
                            <input type="date" name="travel_date" required min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" class="dt-input">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-stone-600">Pickup location</label>
                            <input type="text" name="pickup_location" required placeholder="Hotel, airport or railway station" class="dt-input">
                        </div>
                        @if(isset($vehicles) && $vehicles->isNotEmpty())
                            <div>
                                <label class="mb-1.5 block text-xs font-semibold text-stone-600">Preferred vehicle</label>
                                <select name="vehicle_id" class="dt-input">
                                    <option value="">Any (we’ll suggest one)</option>
                                    @foreach($vehicles as $veh)
                                        <option value="{{ $veh->id }}">{{ $veh->name }} — {{ $veh->seating_capacity }} seater</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-saffron-500 px-5 py-3.5 text-sm font-bold text-pine-950 transition hover:bg-saffron-400">
                            <i data-lucide="send" class="h-4 w-4"></i> Send booking request
                        </button>
                    </form>

                    <ul class="mt-5 space-y-2 border-t border-stone-100 pt-5 text-xs text-stone-600">
                        <li class="flex items-center gap-2"><i data-lucide="badge-check" class="h-4 w-4 text-pine-500"></i>Zero advance to enquire</li>
                        <li class="flex items-center gap-2"><i data-lucide="shield-check" class="h-4 w-4 text-pine-500"></i>Registered taxi union — best price policy</li>
                        <li class="flex items-center gap-2"><i data-lucide="phone-call" class="h-4 w-4 text-pine-500"></i>We call back within minutes</li>
                    </ul>
                </div>

                <div class="rounded-2xl bg-pine-900 p-6 text-white">
                    <h2 class="text-lg font-extrabold">Need help planning?</h2>
                    <p class="mt-2 text-sm text-white/75">Talk to our travel desk to customise this tour.</p>
                    <a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}"
                       class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-white/10 px-5 py-3 text-sm font-bold text-white ring-1 ring-white/20 transition hover:bg-white/20">
                        <i data-lucide="phone" class="h-4 w-4"></i> {{ $phone }}
                    </a>
                </div>
            </div>
        </aside>
    </div>
</section>

{{-- Related tours --}}
@if(isset($relatedPackages) && $relatedPackages->isNotEmpty())
<section class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between gap-4">
            <h2 class="text-2xl font-extrabold text-pine-950">More tour packages</h2>
            <a href="{{ route('tours.index') }}" class="text-sm font-semibold text-pine-700 hover:text-pine-900">View all →</a>
        </div>
        <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($relatedPackages as $rel)
                <a href="{{ route('tours.show', $rel->slug) }}" class="group block overflow-hidden rounded-2xl bg-white ring-1 ring-stone-200 transition hover:-translate-y-1 hover:shadow-xl hover:shadow-pine-900/10">
                    <div class="relative aspect-[16/10] overflow-hidden bg-stone-100">
                        <img src="{{ Media::url($rel->thumbnail) }}" alt="{{ $rel->title }}" loading="lazy" class="dt-card-img h-full w-full object-cover"
                             onerror="this.onerror=null; this.src=@js(Media::url('/images/dharamshala/dhauladhar-alpenglow.jpg'))">
                        <span class="absolute left-3 top-3 inline-flex items-center gap-1 rounded-full bg-pine-950/80 px-2.5 py-1 text-[11px] font-semibold text-white backdrop-blur">
                            <i data-lucide="clock" class="h-3 w-3 text-saffron-400"></i>{{ $rel->duration ?: 'Flexible' }}
                        </span>
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold leading-snug text-pine-950 group-hover:text-pine-700">{{ $rel->title }}</h3>
                        @if((float) $rel->starting_price > 0)
                            <p class="mt-2 text-sm text-stone-500">From <span class="font-bold text-pine-900">₹{{ number_format((float) $rel->starting_price) }}</span></p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@if(session('success'))
    @push('scripts')
        <script>
            window.addEventListener('load', function () {
                if (window.Swal) {
                    Swal.fire({ icon: 'success', title: 'Review submitted!', text: @json(session('success')), confirmButtonColor: '#1a503f' });
                }
            });
        </script>
    @endpush
@endif
