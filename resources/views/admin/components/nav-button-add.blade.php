@php
    $htmlString = view('admin.components.nav-button', [
        'name'   => $name ?? 'Add',
        'icon'   => 'fa-plus',
        'href'   => $href ?? '',
        'target' => $target ?? '',
    ]);
@endphp
{!! $htmlString !!}
