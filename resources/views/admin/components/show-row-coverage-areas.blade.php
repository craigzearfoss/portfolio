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
    if (!empty($whiteSpace)) $styleArray[] = 'white-space: '. $whiteSpace . ';';

    if (!empty($display)) {
        $styleArray[] = 'display: '. $display;
    } elseif (!empty($hide)) {
        $styleArray[] = 'display: none';
    }

    if (!empty($styleArray)) {
        $styles = array_merge($styles, $styleArray);
    }

    $columns = [
        'local'         => 'local',
        'regional'      => 'regional',
        'national'      => 'national',
        'international' => 'international',
    ];
@endphp
<div @if (!empty($classes))
         class="{!! implode(' ', $classes) !!}"
     @endif
     @if (!empty($styles))
         style="{!! implode(' ', $styles) !!}"
     @endif
>
    <div class="column is-2 label">
        <strong>coverage area</strong>:
        <br>
        <span class="pl-4" style="font-weight: 400;">(loc, reg, nat, intl)</span>
    </div>
    <div class="column left-align is-10 value pr-4 mb-3 mr-4">
        <div>

            <div class="floating-div-container visibility-checkboxes-container settings">

                @foreach ($columns as $column=>$label)

                    @if ($resource->hasAttribute($column))

                        <div class="show-container card floating-div" style="max-width: 9rem; width: 9rem;">
                            <span>
                                @include('admin.components.checkmark', [ 'checked' => !empty($resource->{$column}) ])
                            </span>
                            <span><strong>{{ $label }}</strong></span>
                        </div>

                    @endif

                @endforeach

            </div>

        </div>

    </div>
</div>
