@php
    $htmlString = view('user.components.nav-button', [
        'name'   => $name ?? 'Edit',
        'class'  => 'button is-small is-dark my-0',
        'icon'   => 'fa-pen-to-square',
        'href'   => $href ?? '',
        'target' => $target ?? '',
    ]);
@endphp
{!! $htmlString !!}
