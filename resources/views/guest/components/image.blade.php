@if (!empty($src))
    <img
        @if (!empty($src))src="{{ $src }}" @endif
        @if (!empty($alt))alt="{{ $alt }}" @endif
        @if (!empty($class))class="{{ $class }}" @endif
        @if (!empty($style))style="{{ is_array($style) ? implode('; ', $style) . ';' : $style }}" @endif
        @if (!empty($width))width="{{ $width }}" @endif
        @if (!empty($height))height="{{ $height }}" @endif
        @if (!empty($onclick))
            onclick="{{ $onclick }}"
        @endif
    >

    @if (!empty($src))
        @if (!empty($download))
            <a class="download-link text-xl"
                title="download file"
                @if(!empty($alt))alt="{{ $alt }}" @endif
                data-url="{{ $src }}"
                data-filename="{{ $filename ?? '' }}"
            >
                <i class="fa-solid fa-download"></i>
            </a>
        @endif
        @if (!empty($external))
            <a title="open file in a new window"
               class="certificate text-xl" href="{{ $src }}"
               @if(!empty($alt))alt="{{ $alt }}" @endif
               target="_blank">
                <i class="fa-solid fa-external-link"></i>{{-- link--}}
            </a>
        @endif
    @endif

@endif
