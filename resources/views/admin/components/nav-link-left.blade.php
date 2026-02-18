@php
    // get classes
    $classes = !empty($class)
        ? is_array($class) ? $class : explode(';', $class)
        : [];

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
            $styles[] = 'padding: 0.3rem';
            break;
    }
@endphp
@if(empty($href))
    <span
        @if(!empty($classes))
            class="{!! implode(' ', $classes)  !!}"
        @endif
        @if(!empty($styles))
            style="{!! implode('; ', $styles) !!}"
        @endif
    >
        {!! !empty($icon) ? '<i class="fa ' . $icon . '"></i>' : '' !!}
        {!! $name ?? '' !!}
    </span>
@else
    @include('admin.components.nav-button', [
        'name'       => $name ?? '',
        'href'       => $href,
        'class'      => $classes,
        'style'      => $styles,
        'icon'       => $icon ?? false,
        'dataTarget' => $dataTarget ?? null,
    ]);
@endif
