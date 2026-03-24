@php
    $htmlString = view('guest.components.nav-button', [
        'id'      => $id ?? null,
        'name'    => $name ?? 'View',
        'class'   => 'button is-small is-dark my-0',
        'icon'    => 'fa-list',
        'href'    => $href ?? '',
        'target'  => $target ?? '',
        'onclick' => $onclick ?? null,
    ]);
@endphp
{!! $htmlString !!}
