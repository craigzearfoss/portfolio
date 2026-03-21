@php
    $name = $name ?? '';

    // get classes
    $classes = !empty($class)
        ? is_array($class) ? $class : explode(';', $class)
        : [];
    $classes[] = 'navbar-item';
    if ($active ?? false) $classes[] = 'has-text-primary';

    // get styles
    $styles = !empty($style)
        ? is_array($style) ? $style : explode(';', $style)
        : [];
    if ($level ?? 0 > 1) {
        $styles[] = 'padding: 0.3rem';
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
        @if(!empty($icon))
            <span class="icon">
                {{ '<i class="fa ' . $icon . '"></i>' }}
            </span>
        @endif
        <span>
            {!! $name ?? '' !!}
        </span>
    </span>
@else
    @include('guest.components.nav-button', [
        'name'       => $name,
        'href'       => $href,
        'class'      => $classes,
        'style'      => $styles,
        'icon'       => $icon ?? false,
        'dataTarget' => $dataTarget ?? null,
    ])
@endif
