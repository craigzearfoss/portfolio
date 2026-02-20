@php
    $classes = !empty($class)
        ? (is_array($class) ? $class : explode(' ', $class))
        : [];
    $classes[] ='property-list';
    $classes[] ='columns';

    $styles = !empty($style)
        ? (is_array($style) ? $style : explode(';', $style))
        : [];

    // get styles for defined properties
    $styleArray = [];
    if (!empty($width)) $styleArray[] = 'width: '. $width . ';';
    if (!empty($minWidth)) $styleArray[] = 'min-width: '. $minWidth . ';';
    if (!empty($display)) $styleArray[] = 'display: '. $display . ';';
    if (!empty($whiteSpace)) $styleArray[] = 'white-space: '. $whiteSpace . ';';
    if (!empty($styleArray)) {
        $styles = array_merge($styles, $styleArrayt);
    }
@endphp
<div @if(!empty($classes))
         class="{!! implode(' ', $classes) !!}"
     @endif
     @if(!empty($styles))
         style="{!! implode(' ', $styles) !!}"
     @endif
>
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
