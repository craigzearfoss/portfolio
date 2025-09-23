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
        @if(!empty($icon))<i class="fa-solid {{ $icon }}"></i> @endif
        {{ $name ?? $url ?? '#name#' }}
    </a>

    @if (!empty($url))
        <a class="text-xl"
           title="download"
           href="{{ $url }}"
           download="resume"
           <?php /* onclick="downloadFile('{{ $url }}', '{{ basename($url) }}');" */ ?>
        ><i class="fa-solid fa-download"></i></a>
    @endif

@endif
