@php
    $name      = $name ?? '';
    $routeName = $route ?? Route::currentRouteName();
    $params    = $params ?? request()->except([ 'page', 'sort' ]);

    // get the sort field and direction (if it is not specified then we will create a span instead of a link)
    if ($sort = $sort ?? $name ?? '') {
        $sortField = explode('|', $sort)[0];
        $sortDir   = explode('|', $sort)[1] ?? 'asc';
    } else {
        $sortField = null;
        $sortDir = null;
    }

    // determine the sort direction
    $currentSortField = '';
    if ($currentSort = request()->query('sort') ?? null) {
        $currentSortField = explode('|', $currentSort)[0] ?? '';
        if ($sortField == $currentSortField) {
            // reverse the sort direction
            $sortDir = ((explode('|', $currentSort)[1] ?? 'asc') == 'asc') ? 'desc' : 'asc';
        }
    }
@endphp

@if(empty($sort))
    <span class="col-heading">{{ $name }}</span>
@else
    @php
        $sort = $sortField . '|' . $sortDir;
    @endphp
    <a href="{{ route(Route::currentRouteName(), array_merge($params, ['sort' => $sort, $owner])) }}"
       class="col-heading"
    >
        {{ $name }}
        @if($sortField == $currentSortField)
            <i class="fa fa-sort-{{ $sortDir }}" aria-hidden="true"></i>
        @endif
    </a>
@endif
