<nav class="pagination is-small my-1" role="navigation" aria-label="pagination" style="font-size: 16px;">
    @if($prev)
        <a href="{{ $prev }}" class="pagination-previous" title="previous">‹</a>
    @else
        <span class="pagination-previous">‹</span>
    @endif

    @if($next)
        <a href="{{ $next }}" class="pagination-next" title="next">›</a>
    @else
        <span class="pagination-next">›</span>
    @endif
</nav>
