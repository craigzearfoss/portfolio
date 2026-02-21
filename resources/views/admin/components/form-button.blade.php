@php
    $class = !empty($class) ? (!is_array($class) ? explode(' ', $class) : $class) : [];
    $class[] = 'button';

    $style = !empty($style) ? (!is_array($style) ? explode(';', $style) : $style) : [];

    $propsArray = [];
    foreach ($props ?? [] as $key=>$value) {
        $propsArray[] = "{$key}={$value}";
    }
@endphp

<button
    type="{{ $type ?? 'submit' }}"
    @if (!empty($name))
        name="{{ $name }}"
    @endif
    @if (!empty($id))
        id="{{ $id }}"
    @endif
    @if (!empty($class))
        class="{{ implode(' ' , $class) }}"
    @endif
    @if (!empty($style))
        style="{{ implode(' ' , $class) }}"
    @endif
    @if (!empty($onclick))
        onclick="{!! $onclick !!}"
    @endif
    @if(!empty($disabled) || !empty($readonly))
        disabled
    @endif
    @if (!empty($propsArray))
        {!! implode(' ', $propsArray) !!}
    @endif
>
    @if (!empty($icon))
        <i class="fa-solid {{ $icon }}"></i>
    @endif
    {!! $label ?? 'Submit' !!}
</button>
