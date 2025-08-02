@if (!empty($url) || !empty($name))
    <a
        @if (!empty($url))href="{{ $url }}" @endif
        @if (!empty($target))target="{{ $target }}" @endif
        @if (!empty($class))class="{{ $class }}" @endif
        @if (!empty($style))style="{{ is_array($style) ? implode('; ', $style) . ';' : $style }}" @endif
        @if (!empty($onclick))
            onclick="{{ $onclick }}"
        @endif
    >
        {{ $name ?? $url ?? '#name#' }}
    </a>
@endif;
