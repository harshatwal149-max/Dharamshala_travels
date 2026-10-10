{{--
    Global booking modal. Open from anywhere with:
    $dispatch('open-booking', { type: 'airport'|'local'|'outstation'|'package', vehicle: id, package: id, pickup: '', drop: '' })
--}}
@php
    $bmVehicles = \App\Models\Vehicle::where('is_active', true)->orderBy('name')->get(['id', 'name', 'category', 'seating_capacity']);
    $bmPackages = \App\Models\Package::orderBy('title')->get(['id', 'title', 'duration']);
    $bmInitial = [
        'open'    => $errors->hasAny(['booking_type', 'customer_name', 'customer_phone', 'travel_date', 'pickup_location', 'drop_location', 'vehicle_id', 'package_id']),
        'type'    => old('booking_type', 'airport'),
        'vehicle' => (string) old('vehicle_id', ''),
        'package' => (string) old('package_id', ''),
        'pickup'  => old('pickup_location', ''),
        'drop'    => old('drop_location', ''),
    ];
@endphp

<div x-data="{
        ...@js($bmInitial),
        tabs: { airport: 'Airport Transfer', local: 'Local Sightseeing', outstation: 'Outstation', package: 'Tour Package' },
        show(detail) {
            this.type = detail.type || 'airport';
            this.vehicle = detail.vehicle ? String(detail.vehicle) : '';
            this.package = detail.package ? String(detail.package) : '';
            this.pickup = detail.pickup ?? (this.type === 'airport' ? 'Gaggal Airport (DHM)' : '');
            this.drop = detail.drop ?? '';
            this.open = true;
        }
     }"
     data-booking-modal
     @open-booking.window="show($event.detail || {})"
     @keydown.escape.window="open = false"
     x-show="open"
     x-cloak
     class="fixed inset-0 z-[60] flex items-end justify-center p-0 sm:items-center sm:p-4"
     role="dialog" aria-modal="true" aria-labelledby="booking-modal-title">

    <div x-show="open" x-transition.opacity class="absolute inset-0 bg-pine-950/70 backdrop-blur-sm" @click="open = false"></div>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="translate-y-6 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         class="relative max-h-[94vh] w-full max-w-2xl overflow-y-auto rounded-t-3xl bg-white p-5 shadow-2xl sm:rounded-3xl sm:p-8">

        <button type="button" @click="open = false" class="absolute right-4 top-4 rounded-full p-2 text-stone-400 transition hover:bg-stone-100 hover:text-stone-700" aria-label="Close">
            <i data-lucide="x" class="h-5 w-5"></i>
        </button>

        <span class="dt-eyebrow">Instant booking request</span>
        <h2 id="booking-modal-title" class="mt-2 text-2xl font-extrabold text-pine-950">Book your ride</h2>
        <p class="mt-1 text-sm text-stone-500">Share a few details — we call back to confirm your booking, usually within minutes.</p>

        <div class="dt-scroll-x mt-5 -mx-1 flex gap-2 overflow-x-auto px-1 pb-1">
            <template x-for="(label, key) in tabs" :key="key">
                <button type="button" @click="type = key"
                        :class="type === key ? 'bg-pine-900 text-white shadow' : 'bg-stone-100 text-stone-600 hover:bg-stone-200'"
                        class="whitespace-nowrap rounded-full px-4 py-2 text-xs font-semibold transition" x-text="label"></button>
            </template>
        </div>

        @if($errors->any() && $bmInitial['open'])
            <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                <ul class="list-inside list-disc space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('bookings.store') }}" method="POST" class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
            @csrf
            <input type="hidden" name="booking_type" :value="type">

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold text-stone-600">Full name *</span>
                <input type="text" name="customer_name" required maxlength="100" value="{{ old('customer_name') }}" placeholder="e.g. Rahul Sharma" class="dt-input" autocomplete="name">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold text-stone-600">Mobile / WhatsApp *</span>
                <input type="tel" name="customer_phone" required maxlength="20" value="{{ old('customer_phone') }}" placeholder="e.g. 98160 12345" class="dt-input" autocomplete="tel">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold text-stone-600">Pickup location *</span>
                <input type="text" name="pickup_location" required maxlength="255" x-model="pickup" placeholder="Hotel, airport or station" class="dt-input">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold text-stone-600">Drop location</span>
                <input type="text" name="drop_location" maxlength="255" x-model="drop" :placeholder="type === 'local' ? 'Places you want to visit' : 'e.g. McLeodganj, Manali'" class="dt-input">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold text-stone-600">Travel date *</span>
                <input type="date" name="travel_date" required min="{{ now()->toDateString() }}" value="{{ old('travel_date', now()->toDateString()) }}" class="dt-input">
            </label>

            <label class="block" x-show="type !== 'package'">
                <span class="mb-1.5 block text-xs font-semibold text-stone-600">Preferred cab</span>
                <select name="vehicle_id" x-model="vehicle" class="dt-input" :disabled="type === 'package'">
                    <option value="">Any available cab</option>
                    @foreach($bmVehicles as $veh)
                        <option value="{{ $veh->id }}">{{ $veh->name }} — {{ $veh->category }} ({{ $veh->seating_capacity }} seats)</option>
                    @endforeach
                </select>
            </label>

            <label class="block" x-show="type === 'package'" x-cloak>
                <span class="mb-1.5 block text-xs font-semibold text-stone-600">Tour package</span>
                <select name="package_id" x-model="package" class="dt-input" :disabled="type !== 'package'">
                    <option value="">Help me choose</option>
                    @foreach($bmPackages as $pkg)
                        <option value="{{ $pkg->id }}">{{ $pkg->title }} ({{ $pkg->duration }})</option>
                    @endforeach
                </select>
            </label>

            <div class="sm:col-span-2">
                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-saffron-500 px-6 py-3.5 text-sm font-bold text-pine-950 shadow-lg shadow-saffron-500/25 transition hover:bg-saffron-400">
                    <i data-lucide="send" class="h-4 w-4"></i>
                    Send booking request
                </button>
                <p class="mt-3 flex items-center justify-center gap-1.5 text-center text-xs text-stone-500">
                    <i data-lucide="shield-check" class="h-3.5 w-3.5 text-pine-500"></i>
                    No advance payment needed to request a booking.
                </p>
            </div>
        </form>
    </div>
</div>
