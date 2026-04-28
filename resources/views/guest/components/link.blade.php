@php
    $class      = !empty($class) ? (!is_array($class) ? explode(' ', $class) : $class) : [];
    $style      = !empty($style) ? (!is_array($style) ? explode(';', $style) : $style) : [];
    $icon       = $icon ?? null;
    $href       = $href ?? null;
    $target     = $target ?? null;
    $download   = isset($download) && boolval($download);
    $attributes = $attributes ?? []
@endphp
@if (!empty($href) || !empty($name))

    <a @if(!empty($href))
           href="{!! $href !!}"
       @endif
       @if(!empty($target))
           target="{!! $target !!}"
       @endif
       @if(!empty($class))
           class="{{ implode(' ' , $class) }}"
       @endif
       @if(!empty($style))
           style="{!! implode('; ', $style) !!}"
       @endif
       @if(!empty($onclick))
            onclick="{!! $onclick !!}"
       @endif
       @if(!empty($attributes))
           @foreach($attributes as $key=>$value)
               {{ $key }}="{!! $value !!}"
           @endforeach
       @endif
    >
        @if (!empty($icon))
            <i class="fa {{ $icon }}"></i>
        @endif
        {!! $name ?? $href ?? '' !!}
    </a>

    @if ($download && !empty($href))
        <a class="text-xl"
           title="download"
           href="{!! $href !!}"
           download="resume"
           <?php /* onclick="downloadFile('{!! $href !!}', '{!! basename($href) !!}');" */ ?>
        ><i class="fa fa-download"></i></a>
    @endif

@endif
