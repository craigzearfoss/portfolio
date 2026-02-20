@php
    $resourceType = $resourceType ?? '';
    $resources = $resources ?? [];
    $currentLevel = 1;
@endphp
@if(!empty($resource))

    <h2>No {{ $resourceType }} resources found.</h2>

@else

    <ul class="menu-list" data-menu-level="{{ $currentLevel }}" style="max-width: 20em;">

        @foreach($resources as $i=>$resource)

            @if($resource->menu_level > $currentLevel)
                <li class="list-item">
                    <ul class="menu-list m-0 ml-2" data-menu-level="{{ $currentLevel }}" style="max-width: 20em; border-left: 0;">
            @elseif($resource->menu_level < $currentLevel)
                </ul>
                <li class="list-item">
            @else
                <li class="list-item">
            @endif

            @php $currentLevel = $resource->menu_level @endphp

            <li class="list-item">

                @include('user.components.link', [
                    'name'  => $resource->plural,
                    'href'  => Route::has('user.'.$resourceType.'.'.$resource->name.'.index')
                                   ? route('user.'.$resourceType.'.'.$resource->name.'.index', (isRootAdmin() ? [ 'owner_id' => $owner->id ?? '' ] : []))
                                   : null,
                    'class' => 'list-item',
                ])

        @endforeach

        </li>
    </ul>

@endif
