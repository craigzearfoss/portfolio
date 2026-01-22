@php
    $htmlString = view('guest.components.nav-button', [
        'name'   => $name ?? 'Back',
        'icon'   => 'fa-arrow-left',
        'href'   => $href ?? '',
        'target' => $target ?? '',
    ]);
@endphp
{!! $htmlString !!}
