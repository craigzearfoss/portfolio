@php
    $download = $download ?? false;
    $external = $external ?? false;

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
    if (!empty($whiteSpace)) $styleArray[] = 'white-space: '. $whiteSpace . ';';

    if (!empty($display)) {
        $styleArray[] = 'display: '. $display;
    } elseif (!empty($hide)) {
        $styleArray[] = 'display: none';
    }

    if (!empty($styleArray)) {
        $styles = array_merge($styles, $styleArray);
    }
@endphp
<div class="property-list columns">
    <div class="column is-2 label">
        @if(!empty($name))
            <strong>{!! $name !!}</strong>:
        @endif
    </div>
    <div class="column is-10 value">
        <div style="display: inline-block;">
            @include('guest.components.image', [
                'name'     => 'image',
                'src'      => $src,
                'filename' => $filename ?? null,
                'alt'      => $alt ?? null,
                'width'    => $width ?? null,
                'height'   => $height ?? null,
                'class'    => $class ?? [],
                'style'    => $style ?? [],
                'onclick'  => $onclick ?? null,
                'download' => $download,
                'external' => $external,
            ])
        </div>
    </div>
</div>
