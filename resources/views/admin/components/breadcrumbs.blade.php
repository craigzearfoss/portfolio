<ul>
    @foreach ($breadcrumbs as $breadcrumb)
        <li class="is-size-6">
            @if(!empty($breadcrumb['url']))
                @include('admin.components.link', [
                    'url'  => $breadcrumb['url'],
                    'name' => $breadcrumb['name'] ?? '#name#'
                ])
            @else
                <a>{{ $breadcrumb['name'] ?? '#name#' }}</a>
            @endif
        </li>
    @endforeach
</ul>
