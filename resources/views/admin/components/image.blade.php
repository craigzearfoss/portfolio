@php
    $download = $download ?? false;
    $external = $external ?? false;

    $imageUrl  = !empty($src) ? imageUrl($src) : $src;
    $extension = pathinfo($imageUrl, PATHINFO_EXTENSION);
    $filename  = ($filename ?? 'download') . (!empty($extension) ? '.'. $extension : '');
@endphp
@if (!empty($imageUrl))
    <img
        @if (!empty($src))
            src="{!! $imageUrl !!}"
        @endif
        @if (!empty($alt))
            alt="{!! $alt !!}"
        @endif
        @if (!empty($class))
            class="{!! is_array($class) ? implode(' ', $class) : $class !!}"
        @endif
        @if (!empty($style))
            style="{!! is_array($style) ? implode('; ', $style) . ';' : $style !!}"
        @endif
        @if (!empty($width))
            width="{!! $width !!}"
        @endif
        @if (!empty($height))
            height="{!! $height !!}"
        @endif
        @if (!empty($onclick))
            onclick="{!! $onclick !!}"
        @endif
    >

    @if (!empty($download) || !empty($external))

        <div id="download-image-controls" class="has-text-right">

            @if (!empty($download))
                <a class="download-link text-xl"
                    title="{!! $title ?? 'download file'!!}"
                    data-url="{!! $imageUrl !!}"
                    data-filename="{!! $filename ?? '' !!}"
                >
                    <i class="fa-solid fa-download"></i>
                </a>
            @endif
            @if (!empty($external))
                <a class="certificate text-xl"
               href="{!! $imageUrl !!}"
                   title="{{ $title ?? 'open file in a new window' }}"
                   target="_blank"
                >
                    <i class="fa-solid fa-external-link"></i>
                </a>
            @endif

        </div>

    @endif

@endif
