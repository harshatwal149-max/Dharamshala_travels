<section class="bg-pine-900">
    <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-6 px-4 py-12 sm:px-6 lg:flex-row lg:items-center lg:px-8">
        <div class="max-w-2xl text-white">
            <h2 class="text-2xl font-extrabold sm:text-3xl">{{ $heading }}</h2>
            <p class="mt-2 text-white/75">{{ $text }}</p>
        </div>
        <button type="button"
                @click="$dispatch('open-booking', @js(array_filter(['type' => $type ?? 'local', 'drop' => $drop ?? null, 'pickup' => $pickup ?? null])))"
                class="inline-flex w-full shrink-0 items-center justify-center gap-2 rounded-xl bg-saffron-500 px-6 py-3.5 text-sm font-bold text-pine-950 transition hover:bg-saffron-400 sm:w-auto">
            <i data-lucide="calendar-check" class="h-4 w-4"></i>
            {{ $button ?? 'Book a cab' }}
        </button>
    </div>
</section>
