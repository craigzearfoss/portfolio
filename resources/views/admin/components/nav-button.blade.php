@php
    $class = !empty($class) ? (is_array($class) ? implode(' ', $class) : $class) : 'button is-small is-dark my-0';
    $style = !empty($style) ? (is_array($style) ? implode('; ', $style) : '') : '';
@endphp
<a href="{{ $href ?? '' }}"
   @if (!empty($target ?? ''))target="{!! $target !!}" @endif
   class="{!! $class !!}"
   @if (!empty($style))style="{!! $style !!}" @endif
>
    {!! !empty($icon) ? '<i class="fa ' . $icon . ' mr-1"></i>' : '' !!}
    {!! $name ?? '' !!}
</a>
