@extends('layouts.site')

@use('App\Models\Setting')
@use('App\Support\Media')

@php
    $phone = Setting::get('contact_phone') ?: '+91 98765 43210';
    $phoneHref = preg_replace('/[^0-9+]/', '', $phone);
    $whatsapp = Setting::get('footer_whatsapp') ?: $phone;
    $whatsappHref = preg_replace('/\D/', '', $whatsapp);
    $email = Setting::get('contact_email') ?: 'info@dharamshalatravels.com';
    $address = Setting::get('contact_address') ?: 'Main Taxi Stand, Kotwali Bazar, Dharamshala, Himachal Pradesh 176215';
    $hours = Setting::get('contact_hours') ?: 'Available 6:00 AM – 11:00 PM';
    $response = Setting::get('contact_email_response') ?: 'Response within 2 hours';
    $mapUrl = Setting::get('footer_map_url') ?: 'https://www.google.com/maps/search/?api=1&query=' . urlencode($address);
    $lat = Setting::get('seo_latitude');
    $lng = Setting::get('seo_longitude');
    $mapEmbed = 'https://maps.google.com/maps?q=' . urlencode($lat && $lng ? "{$lat},{$lng}" : $address) . '&z=15&output=embed';

    $field = 'dt-input';
@endphp

@section('content')

@include('partials.page-hero', [
    'eyebrow'  => 'We reply within minutes',
    'title'    => 'Contact our travel desk',
    'subtitle' => Setting::get('contact_subtitle') ?: 'Questions about a cab, a tour or an airport pickup? Call, WhatsApp or send us a message — a real person from our Dharamshala team will get back to you.',
    'image'    => '/images/dharamshala/mcleodganj-view.jpg',
    'crumbs'   => ['Contact' => route('contact')],
])

{{-- Contact cards --}}
<section class="bg-cream">
    <div class="mx-auto grid max-w-7xl gap-4 px-4 pt-10 sm:grid-cols-2 sm:px-6 lg:grid-cols-4 lg:px-8 lg:pt-14">
        @foreach([
            ['phone-call', 'Call us', $phone, $hours, 'tel:' . $phoneHref, false],
            ['message-circle', 'WhatsApp', $whatsapp, 'Quickest way to book', 'https://wa.me/' . $whatsappHref . '?text=' . rawurlencode('Hi Dharamshala Travels, I would like to book a cab.'), true],
            ['mail', 'Email', $email, $response, 'mailto:' . $email, false],
            ['map-pin', 'Visit us', 'Dharamshala, HP', $address, $mapUrl, true],
        ] as [$icon, $label, $value, $sub, $href, $external])
            <a href="{{ $href }}" @if($external) target="_blank" rel="noopener" @endif
               class="group flex items-start gap-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-stone-200 transition hover:-translate-y-1 hover:ring-pine-300">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-pine-900 text-saffron-400 transition group-hover:bg-saffron-500 group-hover:text-pine-950">
                    <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
                </span>
                <span class="min-w-0">
                    <span class="block text-xs font-semibold uppercase tracking-wider text-stone-500">{{ $label }}</span>
                    <span class="mt-0.5 block font-bold text-pine-950 [overflow-wrap:anywhere] {{ str_contains($value, '@') ? 'text-sm' : '' }}">{{ $value }}</span>
                    <span class="mt-1 block text-xs leading-relaxed text-stone-500">{{ $sub }}</span>
                </span>
            </a>
        @endforeach
    </div>
</section>

{{-- Form + info --}}
<section class="bg-cream">
    <div class="mx-auto grid max-w-7xl gap-8 px-4 pb-14 pt-8 sm:px-6 lg:grid-cols-12 lg:px-8 lg:pb-20 lg:pt-10">

        {{-- Form --}}
        <div class="lg:col-span-7">
            <div class="rounded-3xl bg-white p-6 ring-1 ring-stone-200 sm:p-10">
                <span class="dt-eyebrow">Send an enquiry</span>
                <h2 class="mt-2 text-2xl font-extrabold text-pine-950 sm:text-3xl">Tell us about your trip</h2>
                <p class="mt-2 text-sm text-stone-600">Share your dates, pickup point and group size — we will call you back to plan everything.</p>

                @if(session('enquiry_success'))
                    <div class="mt-6 flex items-start gap-3 rounded-2xl border border-pine-200 bg-pine-50 p-4 text-sm text-pine-800" role="status">
                        <i data-lucide="circle-check" class="mt-0.5 h-5 w-5 shrink-0 text-pine-600"></i>
                        <p><strong class="block">Message sent!</strong>{{ session('enquiry_success') }}</p>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="mt-6 grid gap-5 sm:grid-cols-2" novalidate>
                    @csrf

                    <label class="block">
                        <span class="mb-1.5 block text-xs font-semibold text-stone-600">Your name *</span>
                        <input type="text" name="name" value="{{ old('name') }}" required maxlength="100" autocomplete="name" placeholder="e.g. Rajesh Kumar"
                               class="{{ $field }} @error('name') !border-red-400 @enderror">
                        @error('name')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>

                    <label class="block">
                        <span class="mb-1.5 block text-xs font-semibold text-stone-600">Mobile / WhatsApp *</span>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required maxlength="20" autocomplete="tel" placeholder="e.g. 98160 12345"
                               class="{{ $field }} @error('phone') !border-red-400 @enderror">
                        @error('phone')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>

                    <label class="block">
                        <span class="mb-1.5 block text-xs font-semibold text-stone-600">Email <span class="font-normal text-stone-400">(optional)</span></span>
                        <input type="email" name="email" value="{{ old('email') }}" maxlength="150" autocomplete="email" placeholder="you@example.com"
                               class="{{ $field }} @error('email') !border-red-400 @enderror">
                        @error('email')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>

                    <label class="block">
                        <span class="mb-1.5 block text-xs font-semibold text-stone-600">Subject</span>
                        <select name="subject" class="{{ $field }}">
                            @foreach(['General enquiry', 'Gaggal Airport pickup / drop', 'Local sightseeing', 'Outstation cab', 'Tour package', 'Trek (Triund, Kareri…)', 'Other'] as $topic)
                                <option value="{{ $topic }}" @selected(old('subject') === $topic)>{{ $topic }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="block sm:col-span-2">
                        <span class="mb-1.5 block text-xs font-semibold text-stone-600">Your message *</span>
                        <textarea name="message" rows="5" required maxlength="2000"
                                  placeholder="Travel dates, pickup point, destination, number of passengers…"
                                  class="{{ $field }} resize-y @error('message') !border-red-400 @enderror">{{ old('message') }}</textarea>
                        @error('message')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>

                    <div class="flex flex-col gap-3 sm:col-span-2 sm:flex-row sm:items-center sm:justify-between">
                        <p class="flex items-center gap-1.5 text-xs text-stone-500">
                            <i data-lucide="lock" class="h-3.5 w-3.5 text-pine-500"></i> Your details are only used to reply to you.
                        </p>
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-saffron-500 px-7 py-3.5 text-sm font-bold text-pine-950 shadow-lg shadow-saffron-500/25 transition hover:bg-saffron-400">
                            <i data-lucide="send" class="h-4 w-4"></i> Send message
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Side --}}
        <aside class="space-y-6 lg:col-span-5">
            <div class="overflow-hidden rounded-3xl bg-white ring-1 ring-stone-200">
                <iframe title="Dharamshala Travels location" src="{{ $mapEmbed }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="h-64 w-full border-0"></iframe>
                <div class="p-6">
                    <h2 class="font-extrabold text-pine-950">{{ Setting::get('site_title') ?: 'Dharamshala Travels' }}</h2>
                    <p class="mt-1 text-sm leading-relaxed text-stone-600">{{ $address }}</p>
                    <a href="{{ $mapUrl }}" target="_blank" rel="noopener" class="mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-pine-700 hover:text-pine-900">
                        Get directions <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                    </a>
                </div>
            </div>

            <div class="rounded-3xl bg-pine-900 p-6 text-white">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/10 text-saffron-400"><i data-lucide="shield-check" class="h-5 w-5"></i></span>
                    <h2 class="font-extrabold">{{ Setting::get('contact_guarantee_title') ?: 'Local Hill Drivers' }}</h2>
                </div>
                <p class="mt-3 text-sm leading-relaxed text-white/75">{{ Setting::get('contact_guarantee_desc') ?: 'Experienced drivers who know every road in the Kangra Valley.' }}</p>
                <div class="mt-5 grid grid-cols-2 gap-2">
                    <a href="{{ route('airport-taxi') }}" class="rounded-xl bg-white/10 px-3 py-2.5 text-center text-xs font-semibold hover:bg-white/15">Airport taxi</a>
                    <a href="{{ route('taxi-routes.index') }}" class="rounded-xl bg-white/10 px-3 py-2.5 text-center text-xs font-semibold hover:bg-white/15">Taxi routes</a>
                    <a href="{{ route('tours.index') }}" class="rounded-xl bg-white/10 px-3 py-2.5 text-center text-xs font-semibold hover:bg-white/15">Tour packages</a>
                    <a href="{{ route('destinations.index') }}" class="rounded-xl bg-white/10 px-3 py-2.5 text-center text-xs font-semibold hover:bg-white/15">Destinations</a>
                </div>
            </div>
        </aside>
    </div>
</section>

{{-- FAQ --}}
<section class="bg-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-12 lg:px-8 lg:py-20">
        <div class="lg:col-span-4">
            <span class="dt-eyebrow">FAQ</span>
            <h2 class="mt-3 text-3xl font-extrabold text-pine-950">Before you get in touch</h2>
        </div>
        <div class="lg:col-span-8">
            @include('partials.faq-list', ['faqs' => $faqs])
        </div>
    </div>
</section>

@include('partials.cta-band', [
    'heading' => 'Prefer to book right away?',
    'text'    => 'Send a booking request in under a minute — no payment needed.',
    'type'    => 'airport',
    'button'  => 'Book a cab now',
])

@endsection
