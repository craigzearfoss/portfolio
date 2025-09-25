<div class="columns">
    <span class="column is-2"><strong>{{ $name ?? '#name#' }}</strong>:</span>
    <span class="column is-10 pl-0">
        @include('front.components.image', [
            'src'    => $src ?? '',
            'alt'    => $alt ?? '',
            'class'  => $class ?? '',
            'style'  => $style ?? [],
            'width'  => $width ?? '',
            'height' => $height ?? '',
        ])
    </span>
</div>
