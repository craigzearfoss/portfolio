@php
    $attributes = $attributes ?? [];

    $href = $href ?? '';
    $filename = $filename ?? 'file.xlsx';

    // set data attributes
    if (!array_key_exists('data-href', $attributes)) {
        $attributes['data-href'] = $href;
    }
    if (!array_key_exists('data-filename', $attributes)) {
        $attributes['data-filename'] = $filename;
    }

    $class = !empty($class)
        ? is_array($class) ? $class : explode(' ', $class)
        : [ 'button', 'is-small', 'has-background-white-ter' ];
    $class[] = 'export-to-excel-btn';

    $onclick = $onclick ?? null;

    $icon = $icon ?? 'fa-download';

    $htmlString = view('admin.components.nav-button', [
        'id'         => $id ?? null,
        'name'       => $name ?? 'Export',
        'class'      => implode(' ' , $class),
        'icon'       => $icon,
        'href'       => $href,
        'target'     => $target ?? '',
        'onclick'    => $onclick ?? null,
        'attributes' => $attributes,
    ]);
@endphp
{!! $htmlString !!}
