@php
    $class = !empty($class) ? (!is_array($class) ? [$class] : $class) : ['is-small is-dark my-0'];
    if ($active ?? false) $class[] = 'has-text-white';

    $style = !empty($style) ? (!is_array($style) ? [$style] : $style) : [];
@endphp
<a href="{{ $href ?? '' }}"
   @if(!empty($class))
       class="{!! implode(' ', $class) !!}"
   @endif
   @if(!empty($style))
       style="{!! implode('; ', $style) !!}"
   @endif
   @if (!empty($target ?? ''))
       target="{!! $target !!}"
    @endif
>
    {!! !empty($icon) ? '<i class="fa ' . $icon . ' mr-1"></i>' : '' !!}
    {!! $name ?? '' !!}
</a>
