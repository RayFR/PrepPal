@if ($paginator->hasPages())
    <nav class="pp-pagination" role="navigation" aria-label="Pagination Navigation">

        {{-- Results text --}}
        <div class="pp-pagination__meta">
            Showing {{ $paginator->firstItem() ?? 0 }} to {{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }} results
        </div>

        <div class="pp-pagination__bar">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="pp-page pp-page--disabled" aria-disabled="true">‹ Previous</span>
            @else
                <a class="pp-page" href="{{ $paginator->previousPageUrl() }}" rel="prev">‹ Previous</a>
            @endif

            {{-- Page Numbers --}}
            <div class="pp-pages">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="pp-page pp-page--dots">{{ $element }}</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="pp-page pp-page--active" aria-current="page">{{ $page }}</span>
                            @else
                                <a class="pp-page" href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a class="pp-page" href="{{ $paginator->nextPageUrl() }}" rel="next">Next ›</a>
            @else
                <span class="pp-page pp-page--disabled" aria-disabled="true">Next ›</span>
            @endif

        </div>
    </nav>
@endif
