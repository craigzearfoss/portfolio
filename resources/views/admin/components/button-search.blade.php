@php
    $type  = $type ?? 'button';

    // get label
    $label = $label ?? 'Search';

    // get value
    $value = $value ?? null;

    // get id
    $id = $id ?? null;

    // get name
    $name = $name ?? null;

    // get classes
    $class = !empty($class)
        ? (is_array($class) ? $class : explode(' ', $class)) : [];
    $class[] = 'search-button';
    $class = implode(' ', $class);

    // get styles
    $style = isset($style)
        ? (is_array($style) ? implode('; ', $style) : $style)
        : '';

    // get icon
    $icon = $icon ?? 'fa-search';

    // get onclick method
    $onclick = $onclick ?? null;
@endphp
<button
    type="{{ $type }}"
    @if($id)
       id="{{ $id }}"
    @endif
    @if(!empty($class))
        class="{!! $class !!}"
    @endif
    @if(!empty($style))
        style="{!! $style !!}"
    @endif
    @if($value)
        value="{!! $value !!}"
    @endif
    @if($onclick)
        onclick="{!! $onclick !!}"
    @endif
>
    @if($icon)
        <i class="fa {{ $icon }}"></i>
    @endif
    {!! $label !!}
</button>
