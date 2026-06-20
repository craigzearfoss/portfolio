@php
    $href = $href ?? '';
    $class      = !empty($class)
                      ? array_merge((!is_array($class) ? explode(' ', $class) : $class), [ 'button', 'is-small', 'px-1', 'py-0' ])
		      : [ 'button', 'is-small', 'px-1', 'py-0' ];

    $style      = !empty($style)
                      ? (is_array($style) ? $style : explode(';', $style))
                      : [];
    $icon       = $icon ?? null;
    $href       = $href ?? '';
    $target     = $target ?? '';
    $title      = $title ?? '';
    $attributes = $attributes ?? [];
    $border     = $border ?? true;
    if ($disabled ?? false) {
        $style[] = 'cursor: default';
        $style[] = 'opacity: 0.5';
    }

    if (!$border) {
        $style[] = 'background-color: inherit !important';
        $style[] = 'border-width: 0 !important';
    }
@endphp
<a @if (!empty($href))
       href="{!! $href !!}"
   @endif
   @if (!empty($target))
       target="{!! $target !!}"
   @endif
   @if (!empty($title))
       title="{{ $title }}"
   @endif
   @if (!empty($class))
       class="{{ implode(' ' , $class) }}"
   @endif
   @if (!empty($style))
       style="{!! implode('; ', $style) !!}"
   @endif
    @if (!empty($onclick))
       onclick="{!! $onclick !!}"
   @endif
   @if (!empty($attributes))
       @foreach ($attributes as $key=>$value)
           {{ $key }}="{!! $value !!}"
       @endforeach
   @endif
>
    <i class="fa {{ !empty($icon) ? $icon : 'fa-circle' }}"></i>
</a>
