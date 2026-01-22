@php
    $icon = $icon ?? false;
    $dataTarget = $dataTarget ?? false;

    // get name
    $name = $name ?? '';

    // get classes
    $class = isset($class)
        ? (is_array($class) ? implode(' ', $class) : $class)
        : 'button is-small is-dark my-0';

    // get styles
    $style = isset($style)
        ? (is_array($style) ? implode('; ', $style) : '')
        : '';

    // get icon
    $icon = ($icon === false)
        ? ''
        : (false === strpos($icon, '<') ? '<i class="fa ' . $icon . '"></i>' : $icon);
@endphp
<a @if(isset($href) && ($href !== false))href="{!! $href !!}" @endif
   @if (!empty($target ?? ''))target="{!! $target !!}" @endif
   @if (!empty($class))class="{!! $class !!}" @endif
   @if (!empty($style))style="{!! $style !!}" @endif
   @if(!empty($dataTarget))data-target="{{ $dataTarget }}" @endif
>
    {!! $icon !!}
    {!! $name !!}
</a>
