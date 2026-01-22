@php
    $htmlString = view('user.components.nav-button', [
        'name'   => $name ?? 'View',
        'icon'   => 'fa-list',
        'href'   => $href ?? '',
        'target' => $target ?? '',
    ]);
@endphp
{!! $htmlString !!}
