<div class="space-y-3" x-data="{ open: 0 }">
    @foreach($faqs as $i => [$q, $a])
        <div class="rounded-2xl bg-white ring-1 ring-stone-200">
            <button type="button" @click="open = open === {{ $i }} ? null : {{ $i }}" class="flex w-full items-center justify-between gap-4 p-5 text-left" :aria-expanded="open === {{ $i }}">
                <span class="font-semibold text-pine-950">{{ $q }}</span>
                <i data-lucide="plus" class="h-5 w-5 shrink-0 text-pine-600 transition" :class="open === {{ $i }} && 'rotate-45'"></i>
            </button>
            <div x-show="open === {{ $i }}" @if($i > 0) x-cloak @endif class="px-5 pb-5 text-sm leading-relaxed text-stone-600">{{ $a }}</div>
        </div>
    @endforeach
</div>
