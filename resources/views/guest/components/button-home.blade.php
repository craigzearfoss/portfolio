@php
    $classes = $classes ?? [
        'has-text-light',
         'p-1',
         'pl-2',
         'pr-2',
    ];
    $styles = $styles ?? [
        'font-size: 1.2em',
        'font-weight: 700;',
        'border-radius: 10px',
    ];
    if (!empty($selected)) {
        $styles[] ='background-color: #727c8f';
    }
@endphp
<a href="{{ $href ?? route('guest.index') }}"
   class="{{ implode(' ', $classes) }}"
   style="{{ implode('; ', $styles) }};"
>
    {{ $name ?? 'Home' }}
</a>
