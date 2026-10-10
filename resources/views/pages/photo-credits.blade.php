@extends('layouts.site')

@section('content')

@include('partials.page-hero', [
    'title'    => 'Photo Credits',
    'subtitle' => 'Photographs of Dharamshala and Himachal Pradesh on this site come from Wikimedia Commons and are used under their Creative Commons licences.',
    'crumbs'   => ['Photo Credits' => route('photo-credits')],
])

<section class="bg-cream">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($credits as $credit)
                <figure class="flex gap-4 rounded-2xl bg-white p-4 ring-1 ring-stone-200">
                    <img src="{{ \App\Support\Media::url($credit['file']) }}" alt="{{ $credit['title'] }}" loading="lazy" class="h-20 w-24 shrink-0 rounded-lg object-cover">
                    <figcaption class="min-w-0 text-xs leading-relaxed text-stone-600">
                        <a href="{{ $credit['source'] }}" target="_blank" rel="noopener" class="block truncate font-semibold text-pine-900 hover:underline">{{ pathinfo($credit['title'], PATHINFO_FILENAME) }}</a>
                        <span class="block">by {{ \Illuminate\Support\Str::limit($credit['author'], 80) }}</span>
                        @if($credit['license_url'])
                            <a href="{{ $credit['license_url'] }}" target="_blank" rel="noopener license" class="text-pine-700 hover:underline">{{ $credit['license'] }}</a>
                        @else
                            <span>{{ $credit['license'] }}</span>
                        @endif
                        <span class="text-stone-400">• resized</span>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>

@endsection
