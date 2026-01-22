@php
    $htmlString = view('user.components.nav-button', [
        'name'   => $name ?? 'Add',
        'icon'   => 'fa-plus',
        'href'   => $href ?? '',
        'target' => $target ?? '',
    ]);
@endphp
{!! $htmlString !!}
