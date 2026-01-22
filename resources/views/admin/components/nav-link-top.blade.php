@php
    $icon       = $icon ?? false;
    $dataTarget = $dataTarget ?? false;

    $name = $name ?? false;
    if ($name === false) {
        $label = '';
    } else {
        if (empty($name)) {
            $label = 'NONE'; $name ?? '#NAME#';
        } else {
            if ($icon === false) {
                $label = (strpos($name, '<') !== false) ? $name : '<span>' . $name . '</span>';
            } else {
                $label = !empty($icon)
                    ? '<span class="icon"><i class="fa-solid ' . $icon . '"></i></span><span>' .  $name . '</span>'
                    : '<span>' . $name . '</span>';
            }
        }
    }

    // get classes
    $classes = !empty($class)
        ? is_array($class) ? $class : explode(';', $class)
        : [];
    $classes[] = 'navbar-item';
    if ($active ?? false) $classes[] = 'has-text-gray';

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
            break;
    }

    $htmlString = view('admin.components.nav-button', [
            'name'       => $label,
            'href'       => isset($href) ? $href : false,
            'class'      => $classes,
            'style'      => $styles,
            'dataTarget' => $dataTarget
        ]);
@endphp
{!! $htmlString !!}
