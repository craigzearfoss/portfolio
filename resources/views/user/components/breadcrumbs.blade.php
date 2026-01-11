<ul>
    @foreach ($breadcrumbs as $breadcrumb)
        <li class="is-size-6">
            @if(!empty($breadcrumb['href']))
                @include('user.components.link', [
                    'url'  => $breadcrumb['href'],
                    'name' => $breadcrumb['name'] ?? '#name#'
                ])
            @else
                <a>{!! $breadcrumb['name'] ?? '#name#' !!}</a>
            @endif
        </li>
    @endforeach
</ul>
