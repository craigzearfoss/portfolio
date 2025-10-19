@php
$download = isset($download) ? boolval($download) : false;
@endphp
@if (!empty($href) || !empty($name))

    <a
        @if (!empty($href))href="{{ $href }}" @endif
        @if (!empty($target))target="{{ $target }}" @endif
        @if (!empty($class))class="{{ $class }}" @endif
        @if (!empty($style))style="{{ is_array($style) ? implode('; ', $style) . ';' : $style }}" @endif
        @if (!empty($onclick))
            onclick="{{ $onclick }}"
        @endif
    >
        @if(!empty($icon))<i class="fa-solid {{ $icon }}"></i> @endif
        {!! $name ?? $href ?? '#name#' !!}
    </a>

    @if ($download && !empty($href))
        <a class="text-xl"
           title="download"
           href="{{ $href }}"
           download="resume"
           <?php /* onclick="downloadFile('{{ $href }}', '{{ basename($href) }}');" */ ?>
        ><i class="fa-solid fa-download"></i></a>
    @endif

@endif
