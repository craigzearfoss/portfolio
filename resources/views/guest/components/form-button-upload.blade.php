@php
    $class = !empty($class) ? (is_array($class) ? implode(' ', $class) : $class) : 'button is-small is-dark my-0';
    $style = !empty($style) ? (is_array($style) ? implode('; ', $style) : $style) : '';
@endphp
<button type="button"
        class="{!! $class !!}"
        @if (!empty($style))style="{!! $style !!}" @endif
>
    <i class="fa fa-upload mr-1"></i>
    {!! $name ?? '' !!}
</button>
