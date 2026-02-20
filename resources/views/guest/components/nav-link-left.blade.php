@php
    // get classes
    $classes = !empty($class)
        ? is_array($class) ? $class : explode(';', $class)
        : [];

    // get styles
    $styles = !empty($style)
        ? is_array($style) ? $style : explode(';', $style)
        : [];
    if (!empty($level)) $styles[] = 'padding: 0.3rem';
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
    @include('guest.components.nav-button', [
        'name'       => $name ?? '',
        'href'       => $href,
        'class'      => $classes,
        'style'      => $styles,
        'active'     => $active ?? false,
        'icon'       => $icon ?? false,
        'dataTarget' => $dataTarget ?? null,
    ])
@endif
