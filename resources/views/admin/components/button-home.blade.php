@php
    // get classes
    $classes = $classes ?? [
         'home-button',
    ];
    if (!empty($selected)) {
        $classes[] = 'selected';
    }

    // get styles
    $styles = $styles ?? [];
@endphp
<a href="{{ $href ?? route('guest.index') }}"
   @if(!empty($classes))
       class="{{ implode(' ', $classes) }}"
   @endif
   @if(!empty($styles))
       style="{{ implode('; ', $styles) }};"
   @endif
>
    {{ $name ?? 'Home' }}
</a>
