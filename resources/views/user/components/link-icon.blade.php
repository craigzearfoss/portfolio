@php
    $class = !empty($class)
        ? $class . ' button is-small px-1 py-0'
        : 'button is-small px-1 py-0';
@endphp
<a @if (!empty($title))title="{{ $title }}" @endif
   class="button is-small px-1 py-0"
   @if (!empty($class))class="{{ is_array($class) ? implode('; ', $class) . ';' : $class }}" @endif
   @if (!empty($style))style="{!! is_array($style) ? implode('; ', $style) . ';' : $style !!}" @endif
   @if (!empty($disabled))style="cursor: default; opacity: 0.5;" @endif
   @if (!empty($target))target="{{ $target }}" @endif
   @if (!empty($href))href="{{ $href }}" @endif
   @if (!empty($onclick))
       onclick="{{ $onclick }}"
  @endif
>
    <i class="fa-solid {{ !empty($icon) ? $icon : 'fa-circle' }}"></i>
</a>
