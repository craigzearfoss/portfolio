<ul class="breadcrumbs">
    @foreach ($breadcrumbs as $breadcrumb)
        <li class="is-size-6">
            @if(!empty($breadcrumb['href']))
                @include('admin.components.link', [
                    'name' => $breadcrumb['name'] ?? '',
                    'href' => $breadcrumb['href'],
                ])
            @else
                <span>{!! $breadcrumb['name'] ?? '' !!}</span>
            @endif
        </li>
    @endforeach
</ul>
