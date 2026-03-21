@php
    $resourceType = $resourceType ?? '';
    $resources = $resources ?? [];
    $currentMenuLevel = 1;
@endphp

<ul class="menu-list" data-menu-level="{{ $currentMenuLevel }}" style="max-width: 20em;">

    @forelse ($resources as $i=>$resource)

        @if($resource->menu_level > $currentMenuLevel)
            <li class="list-item">
                <ul class="menu-list m-0 ml-2" data-menu-level="{{ $currentMenuLevel }}" style="max-width: 20em; border-left: 0;">
        @elseif($resource->menu_level < $currentMenuLevel)
            </ul>
        @endif

        <li class="list-item">

            @include('guest.components.link', [
                'name'  => $resource->plural,
                'href'  => $resource->url,
                'class' => 'list-item',
                'style' => 'color: #4a4a4a',
                'icon'  => $resource->icon
            ])
        </li>

        @php
            $currentMenuLevel = $resource->menu_level;
        @endphp

    @empty

        <li class="list-item">No {{ $resourceType }} resources found.</li>

    @endforelse

</ul>
