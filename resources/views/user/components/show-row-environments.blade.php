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
<div @if(!empty($classes))
         class="{!! implode(' ', $classes) !!}"
     @endif
     @if(!empty($styles))
         style="{!! implode(' ', $styles) !!}"
     @endif
>
    <div class="column is-2 label">
        <strong>environments</strong>:
    </div>
    <div class="column is-10 value">
        <div>

            <div class="floating-div-container settings">

                @foreach(['guest', 'user', 'admin', 'global'] as $setting)

                    @if($resource->hasAttribute($setting))

                        <div class="show-container card floating-div">
                            <span>
                                @include('user.components.checkbox', [ 'checked' => !empty($resource->{$setting}) ])
                            </span>
                            <span><strong>{{ $setting == 'readonly' ? 'read-only' : $setting }}</strong></span>
                        </div>

                    @endif

                @endforeach

            </div>

        </div>

    </div>
</div>
