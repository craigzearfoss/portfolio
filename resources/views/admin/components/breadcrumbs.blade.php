<ul>
    @foreach ($breadcrumbs as $breadcrumb)
        <li class="is-size-6">
            @if(!empty($breadcrumb['href']))
                @include('admin.components.link', [
                    'name' => $breadcrumb['name'] ?? '#name#',
                    'href' => $breadcrumb['href'],
                ])
            @else
                <a>{!! $breadcrumb['name'] ?? '#name#' !!}</a>
            @endif
        </li>
    @endforeach
</ul>
