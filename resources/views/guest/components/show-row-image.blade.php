<div class="columns">
    <span class="column is-2"><strong>{{ $name ?? '#name#' }}</strong>:</span>
    <span class="column is-10 pl-0">
        @include('guest.components.image', [
            'src'      => $src ?? '',
            'alt'      => htmlspecialchars($alt ?? ''),
            'class'    => $class ?? '',
            'style'    => $style ?? [],
            'width'    => $width ?? '',
            'height'   => $height ?? '',
            'download' => $download ?? false,
            'filename' => $filename ?? '',
        ])
    </span>
</div>
