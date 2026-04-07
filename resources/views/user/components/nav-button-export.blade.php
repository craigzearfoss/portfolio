@php
    //@TODO: Export data button needs to be implemented.
    $class = !empty($class)
        ? is_array($class) ? $class : explode(' ', $class)
        : [ 'button', 'is-small', 'has-background-white-ter' ];
    $onclick = $onclick ?? "alert('Data downloads have not been implemented yet.'); return false;";
    $icon = $icon ?? 'fa-download';

    $htmlString = view('user.components.nav-button', [
        'id'      => $id ?? null,
        'name'    => $name ?? 'Export',
        'class'   => implode(' ' , $class),
        'icon'    => $icon,
        'href'    => $href ?? '',
        'target'  => $target ?? '',
        'onclick' => $onclick ?? null,
    ]);
@endphp
{!! $htmlString !!}
