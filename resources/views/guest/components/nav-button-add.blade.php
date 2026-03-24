@php
    $htmlString = view('guest.components.nav-button', [
        'id'      => $id ?? null,
        'name'    => $name ?? 'Add',
        'class'   => 'button is-small is-dark my-0',
        'icon'    => 'fa-plus',
        'href'    => $href ?? '',
        'target'  => $target ?? '',
        'onclick' => $onclick ?? null,
    ]);
@endphp
{!! $htmlString !!}
