@php
    // get classes
    $classes = !empty($class)
        ? is_array($class) ? $class : explode(';', $class)
        : [];
    if ($active ?? false) $classes[] = 'has-text-white';

    // get styles
    $styles = !empty($style)
        ? is_array($style) ? $style : explode(';', $style)
        : [];
    switch ($level ?? 0) {
        case 4:
        case 3:
        case 2:
        case 1:
        default:
            $styles[] = 'padding: 0.3rem';
            break;
    }

    $htmlString = view('admin.components.nav-button', [
            'name'   => $name ?? false,
            'href'   => $href ?? false,
            'class'  => $classes,
            'style'  => $styles,
            'icon'   => $icon ?? false
        ]);
    @endphp
{!! $htmlString !!}
