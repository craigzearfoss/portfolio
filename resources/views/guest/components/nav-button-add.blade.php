@php
    $htmlString = view('guest.components.nav-button', [
        'name'   => $name ?? 'Add',
        'class'  => 'button is-small is-dark my-0',
        'icon'   => 'fa-plus',
        'href'   => $href ?? '',
        'target' => $target ?? '',
    ]);
@endphp
{!! $htmlString !!}
