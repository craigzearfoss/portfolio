@if (!empty($url))
    <img
        @if (!empty($url))src="{{ $url }}" @endif
        @if (!empty($class))class="{{ $class }}" @endif
        @if (!empty($style))style="{{ is_array($style) ? implode('; ', $style) . ';' : $style }}" @endif
        @if (!empty($onclick))
            onclick="{{ $onclick }}"
        @endif
    />
@endif
