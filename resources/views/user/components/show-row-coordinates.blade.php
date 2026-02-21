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
        $styles = array_merge($styles, $styleArray);
    }
    $resource = $resource ?? null;
@endphp
@if($resource->hasAttribute('latitude') || $resource->hasAttribute('longitude'))

    <div @if(!empty($classes))
         class="{!! implode(' ', $classes) !!}"
         @endif
         @if(!empty($styles))
             style="{!! implode(' ', $styles) !!}"
         @endif
    >
        <div class="column is-2 label">
            <strong>coordinates</strong>
        </div>
        <div class="column is-10 value">
            <div>

                <div class="container" style="display: flex; gap: 1em;">

                    <div class="item" style="max-width: 12em; flex: 1; white-space: nowrap;">
                        <span><strong>latitude:</strong></span>
                        <span>{{ $resource->latitude ?? '' }}</span>
                    </div>

                    <div class="item" style="max-width: 12em; flex: 1; white-space: nowrap;">
                        <span><strong>longitude:</strong></span>
                        <span>{{ $resource->longitude ?? '' }}</span>
                    </div>

                </div>

            </div>

        </div>
    </div>

@endif
