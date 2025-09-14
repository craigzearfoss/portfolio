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
@endif
