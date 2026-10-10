{{-- @include('partials.pagination', ['paginator' => $items]) --}}
@if($paginator->hasPages())
    <nav class="mt-10 flex flex-wrap items-center justify-center gap-2" aria-label="Pagination">
        @if($paginator->onFirstPage())
            <span class="rounded-xl px-4 py-2 text-sm font-semibold text-stone-400 ring-1 ring-stone-200">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="rounded-xl bg-white px-4 py-2 text-sm font-semibold text-pine-800 ring-1 ring-stone-200 hover:bg-stone-50">Previous</a>
        @endif
        @foreach($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            <a href="{{ $url }}" @class(['flex h-10 w-10 items-center justify-center rounded-xl text-sm font-semibold',
                'bg-pine-900 text-white' => $page === $paginator->currentPage(),
                'bg-white text-pine-800 ring-1 ring-stone-200 hover:bg-stone-50' => $page !== $paginator->currentPage()])
               @if($page === $paginator->currentPage()) aria-current="page" @endif>{{ $page }}</a>
        @endforeach
        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="rounded-xl bg-white px-4 py-2 text-sm font-semibold text-pine-800 ring-1 ring-stone-200 hover:bg-stone-50">Next</a>
        @else
            <span class="rounded-xl px-4 py-2 text-sm font-semibold text-stone-400 ring-1 ring-stone-200">Next</span>
        @endif
    </nav>
@endif
