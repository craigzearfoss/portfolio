@php
    $htmlString = view('admin.components.nav-button', [
        'name'   => $name ?? 'View',
        'class'  => 'button is-small is-dark my-0',
        'icon'   => 'fa-list',
        'href'   => $href ?? '',
        'target' => $target ?? '',
    ]);
@endphp
{!! $htmlString !!}
