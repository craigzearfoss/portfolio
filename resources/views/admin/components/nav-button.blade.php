@php
    $icon = $icon ?? false;
    $dataTarget = $dataTarget ?? false;

    // get id
    $id = $id ?? null;

    // get name
    $name = $name ?? '';

    // get classes
    $class = !empty($class)
        ? (is_array($class) ? $class : explode(' ', $class)) : ['is-small is-dark my-0'];
    if ($active ?? false) $class[] = 'has-text-primary';
    $class[] = 'nav-button';
    $class = implode(' ', $class);

    // get styles
    $style = isset($style)
        ? (is_array($style) ? implode('; ', $style) : $style)
        : '';

    // get icon
    $icon = empty($icon)
        ? ''
        : (!str_contains($icon, '<') ? '<i class="fa ' . $icon . '"></i>' : $icon);

    $target = $target ?? null;

    // get onclick method
    $onclick = $onclick ?? null;

    $attributes = $attributes ?? [];
@endphp
<a @if($id)
       id="{{ $id }}"
   @endif
   @if(isset($href) && ($href !== false))
       href="{!! $href !!}"
   @endif
   @if(!empty($class))
       class="{!! $class !!}"
   @endif
   @if(!empty($style))
       style="{!! $style !!}"
   @endif
   @if(!empty($dataTarget))
       data-target="{{ $dataTarget }}"
   @endif
   @if(!empty($target))
       target="{!! $target !!}"
    @endif
    @if($onclick)
        onclick="{!! $onclick !!}"
    @endif
    @if(!empty($attributes))
        @php
            foreach ($attributes as $key=>$value) {
                echo $key . '="' . $value  . '"';
            }
        @endphp
    @endif
>
    {!! $icon !!}
    {!! $name !!}
</a>
