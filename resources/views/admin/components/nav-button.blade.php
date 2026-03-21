@php
    $icon = $icon ?? false;
    $dataTarget = $dataTarget ?? false;

    // get name
    $name = $name ?? '';

    // get classes
    $class = !empty($class)
        ? (is_array($class) ? $class : explode(' ', $class)) : ['is-small is-dark my-0'];
    if ($active ?? false) $class[] = 'has-text-primary';
    $class = implode(' ', $class);

    // get styles
    $style = isset($style)
        ? (is_array($style) ? implode('; ', $style) : $style)
        : '';

    // get icon
    $icon = empty($icon)
        ? ''
        : (!str_contains($icon, '<') ? '<i class="fa ' . $icon . '"></i>' : $icon);
@endphp
<a @if(isset($href) && ($href !== false))href="{!! $href !!}" @endif
   @if(!empty($class))
       class="{!! $class !!}"
   @endif
   @if(!empty($style))
       style="{!! $style !!}"
   @endif
   @if(!empty($dataTarget))
       data-target="{{ $dataTarget }}"
   @endif
   @if (!empty($target ?? ''))
       target="{!! $target !!}"
    @endif
>
    {!! $icon !!}
    {!! $name !!}
</a>
