@php
    $htmlString = view('admin.components.nav-button', [
        'name'   => $name ?? 'Edit',
        'icon'   => 'fa-pen-to-square',
        'href'   => $href ?? '',
        'target' => $target ?? '',
    ]);
@endphp
{!! $htmlString !!}
