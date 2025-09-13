<a @if(!empty($route))href="{{ $route }}" @endif>
    <strong>{{ $word->name }}</strong>
    @if(!empty($word->abbreviation) && ($word->abbreviation != $word->name))[{{ $word->abbreviation }}] @endif
</a>

@if(isset($word->table_name))
    @if(!empty($word->table_slug))
        (<a href="{{ route('admin.dictionary.'.$word->table_slug.'.index') }}"><i>{{ $word->table_name }}</i></a><i>)
    @else
        (<i>{{ $word->table_name }}</i>)
    @endif
@endif


@if(!empty($word->definition))
    - {{ $word->definition }}
@endif

@if(!empty($word->link))
    <a title="{{ $word->link_name ?? 'link' }}"
       class="button is-small p-0"
       style="border-width: 0;"
       href="{{ $word->link }}"
       target="_blank"
    >
        <i class="fa-solid fa-external-link"></i>{{-- link--}}
    </a>
@endif

@if(!empty($word->wikipedia))
    <a title="Wikipedia page"
       class="button is-small p-0"
       style="border-width: 0;"
       href="{{ $word->wikipedia }}"
       target="_blank"
    >
        <i class="fa-solid fa-wikipedia-w"></i>{{-- wikipedia--}}
    </a>
@endif
