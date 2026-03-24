@php
    $htmlString = view('guest.components.nav-button', [
        'id'      => $id ?? null,
        'name'    => $name ?? 'Edit',
        'class'   => 'button is-small is-dark my-0',
        'icon'    => 'fa-pen-to-square',
        'href'    => $href ?? '',
        'target'  => $target ?? '',
        'onclick' => $onclick ?? null,
    ]);
@endphp
{!! $htmlString !!}
