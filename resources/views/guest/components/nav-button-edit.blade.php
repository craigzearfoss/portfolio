@php
    $htmlString = view('guest.components.nav-button', [
        'name'   => $name ?? 'Edit',
        'icon'   => 'fa-pen-to-square',
        'href'   => $href ?? '',
        'target' => $target ?? '',
    ]);
@endphp
{!! $htmlString !!}
