<a @if(!empty($route))href="{{ $route }}" @endif>
    <strong>{{ $word->name }}</strong>
    @if(!empty($word->abbreviation) && ($word->abbreviation != $word->name))[{{ $word->abbreviation }}] @endif
    (<i>{{ $word->table_name }}</i>)
</a>

@if(!empty($word->link))
    <a title="{{ !empty($word->link_name) ? $word->link_name : 'link' }}"
       class="button is-small px-1 py-0"
       style="border-width: 0;"
       href="{{ $word->link }}"
       target="_blank"
    >
        <i class="fa-solid fa-external-link"></i>{{-- link --}}
    </a>
@endif

@if(!empty($word->wikipedia))
    <a title="Wikipedia page"
       class="button is-small px-1 py-0"
       style="border-width: 0;"
       href="{{ $word->wikipedia }}"
       target="_blank"
    >
        <i class="fa-solid fa-wikipedia-w"></i>{{-- wikipedia --}}
    </a>
@endif
