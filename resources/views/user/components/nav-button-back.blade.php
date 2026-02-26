@php
    $htmlString = view('user.components.nav-button', [
        'name'   => $name ?? 'Back',
        'class'  => 'button is-small is-dark my-0',
        'icon'   => 'fa-arrow-left',
        'href'   => $href ?? '',
        'target' => $target ?? '',
    ]);
@endphp
{!! $htmlString !!}
