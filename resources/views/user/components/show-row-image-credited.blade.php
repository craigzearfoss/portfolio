<div class="columns">
    <span class="column is-2"><strong>{{ $name ?? '' }}</strong>:</span>
    <span class="column is-10 pl-0">
        @include('user.components.image', [
            'src'      => $src ?? '',
            'alt'      => htmlspecialchars($alt ?? ''),
            'class'    => $class ?? '',
            'style'    => $style ?? [],
            'width'    => $width ?? '',
            'height'   => $height ?? '',
            'download' => $download ?? false,
            'filename' => $filename ?? '',
        ])
        <br>
        <span>
            @if(!empty($image_credit))
                <span class="mr-2">
                    <i>credit: {{ $image_credit ?? '' }}</i>
                </span>
            @endif
            @if(!empty($image_credit))
                <span>
                    <i> source: {{ $image_source ?? '' }}</i>
                </span>
            @endif
        </span>
    </span>
</div>
