@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Navigasi halaman">
        @if ($paginator->onFirstPage())
            <span class="is-disabled"><x-icon name="chevron-left" :size="16" /></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya"><x-icon name="chevron-left" :size="16" /></a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="is-disabled">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="is-current" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya"><x-icon name="chevron-right" :size="16" /></a>
        @else
            <span class="is-disabled"><x-icon name="chevron-right" :size="16" /></span>
        @endif
    </nav>
@endif
