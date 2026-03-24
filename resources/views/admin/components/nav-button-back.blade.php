@php
    $htmlString = view('admin.components.nav-button', [
        'id'      => $id ?? null,
        'name'    => $name ?? 'Back',
        'class'   => 'button is-small is-dark my-0',
        'icon'    => 'fa-arrow-left',
        'href'    => $href ?? '',
        'target'  => $target ?? '',
        'onclick' => $onclick ?? null,
    ]);
@endphp
{!! $htmlString !!}
