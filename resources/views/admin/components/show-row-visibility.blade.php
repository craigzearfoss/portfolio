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

    $columns = [
        'is_public'   => 'public',
        'is_readonly' => 'read-only',
        'is_root'     => 'root',
        'is_disabled' => 'disabled',
        'is_demo'     => 'demo',
    ];
@endphp
<div @if(!empty($classes))
         class="{!! implode(' ', $classes) !!}"
     @endif
     @if(!empty($styles))
         style="{!! implode(' ', $styles) !!}"
     @endif
>
    <div class="column is-2 label">
        <strong>visibility</strong>:
    </div>
    <div class="column left-align is-10 value">
        <div>

            <div class="floating-div-container settings">

                @foreach($columns as $column=>$label)

                    @if($resource->hasAttribute($column))

                        <div class="show-container card floating-div">
                            <span>
                                @include('admin.components.checkbox', [ 'checked' => !empty($resource->{$column}) ])
                            </span>
                            <span><strong>{{ $label }}</strong></span>
                        </div>

                    @endif

                @endforeach

                @if($resource->hasAttribute('sequence'))

                    <div class="item show-container card floating-div">
                        <span><strong>sequence:</strong></span>
                        <span>{{ $resource->sequence ?? '0' }}</span>
                    </div>

                @endif

            </div>

        </div>

    </div>
</div>
