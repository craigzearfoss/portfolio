@php
    $download = isset($download) && boolval($download);

    $class = !empty($class) ? (!is_array($class) ? explode(' ', $class) : $class) : [];
    $style = !empty($style) ? (!is_array($style) ? explode(';', $style) : $style) : [];
@endphp
@if (!empty($href) || !empty($name))

    <a @if (!empty($href))href="{!! $href !!}" @endif
        @if (!empty($target))
            target="{!! $target !!}"
       @endif
        @if (!empty($class))
            class="{{ implode(' ' , $class) }}"
       @endif
       @if (!empty($style))
           style="{{ implode(' ' , $style) }}"
       @endif
       @if (!empty($onclick))
            onclick="{!! $onclick !!}"
        @endif
    >
        @if (!empty($icon))
            <i class="fa-solid {{ $icon }}"></i>
        @endif
        {!! $name ?? $href ?? '' !!}
</a>

@if ($download && !empty($href))
    <a class="text-xl"
       title="download"
       href="{!! $href !!}"
       download="resume"
       <?php /* onclick="downloadFile('{!! $href !!}', '{!! basename($href) !!}');" */ ?>
    ><i class="fa-solid fa-download"></i></a>
@endif

@endif
