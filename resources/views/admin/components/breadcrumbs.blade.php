<ul>
    @foreach ($breadcrumbs as $breadcrumb)
        <li class="is-size-6">
            @if(!empty($breadcrumb['url']))
                @include('admin.components.link', [
                    'name' => $breadcrumb['name'] ?? '#name#',
                    'href' => $breadcrumb['url'],
                ])
            @else
                <a>{{ $breadcrumb['name'] ?? '#name#' }}</a>
            @endif
        </li>
    @endforeach
</ul>
