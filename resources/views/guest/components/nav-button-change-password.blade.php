@php
    $htmlString = view('guest.components.nav-button', [
        'id'      => $id ?? null,
        'name'    => $name ?? 'Edit',
        'class'   => 'button is-small is-dark my-0',
        'icon'    => 'fa-key',
        'href'    => $href ?? route('admin.profile.change-password'),
        'target'  => $target ?? '',
        'onclick' => $onclick ?? null,
    ]);
@endphp
{!! $htmlString !!}
