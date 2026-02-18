@php
    $class = !empty($class) ? (is_array($class) ? implode(' ', $class) : $class) : 'is-small is-dark my-0';
    $style = !empty($style) ? (is_array($style) ? implode('; ', $style) : $style) : '';
@endphp
@if(empty($href))
    <span class="{!! $class !!}"
          @if (!empty($style))
              style="{!! $style !!}"
        @endif
    >
        {!! !empty($icon) ? '<i class="fa ' . $icon . '"></i>' : '' !!}
        {!! $name ?? '' !!}
    </span>
@else
    <a href="{{ $href ?? '' }}"
       class="{!! $class !!}"
       @if (!empty($style))
           style="{!! $style !!}"
       @endif
       @if (!empty($target ?? ''))
           target="{!! $target !!}"
        @endif
    >
        {!! !empty($icon) ? '<i class="fa ' . $icon . '"></i>' : '' !!}
        {!! $name ?? '' !!}
    </a>
@endif
