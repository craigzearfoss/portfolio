@php
    $imageUrl = !empty($src) ? imageUrl($src) : $src;
@endphp
@if (!empty($imageUrl))
    <img
        @if (!empty($src))src="{!! $imageUrl !!}" @endif
        @if (!empty($alt))alt="{!! $alt !!}" @endif
        @if (!empty($class))class="{!! $class !!}" @endif
        @if (!empty($style))style="{!! is_array($style) ? implode('; ', $style) . ';' : $style !!}" @endif
        @if (!empty($width))width="{!! $width !!}" @endif
        @if (!empty($height))height="{!! $height !!}" @endif
        @if (!empty($onclick))
            onclick="{!! $onclick !!}"
        @endif
    >

    @if (!empty($download))
        <a class="download-link text-xl"
            title="download file"
            data-url="{!! $imageUrl !!}"
            data-filename="{!! $filename ?? '' !!}"
        >
            <i class="fa-solid fa-download"></i>
        </a>
    @endif
    @if (!empty($external))
        <a title="open file in a new window"
           class="certificate text-xl"
	       href="{!! $imageUrl !!}"
           target="_blank"
        >
            <i class="fa-solid fa-external-link"></i>
        </a>
    @endif

@endif
