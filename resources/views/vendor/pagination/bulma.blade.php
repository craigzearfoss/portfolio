@if ($paginator->hasPages())
    <nav class="pagination is-small my-1" role="navigation" aria-label="pagination">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="pagination-previous">&lsaquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination-previous">&lsaquo;</a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination-next">&rsaquo;</a>
        @else
            <span  class="pagination-next">&rsaquo;</span>
        @endif

        {{-- Pagination Elements --}}
        <ul class="pagination-list">

            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <a
                                    class="pagination-link is-current"
                                    aria-label="Page {{ $page }}"
                                    aria-current="page"
                                    >{{ $page }}</a>
                            </li>
                        @else
                            <li>
                                <a
                                    href="{{ $url }}"
                                    class="pagination-link"
                                    aria-label="Page {{ $page }}"
                                    aria-current="page"
                                    >{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

        </ul>

    </nav>
@endif
