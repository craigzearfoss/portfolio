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

    $menu       = $menu ?? 0;
    $menu_level = $menu_level ?? 0;
@endphp
<div @if(!empty($classes))
         class="{!! implode(' ', $classes) !!}"
     @endif
     @if(!empty($styles))
         style="{!! implode(' ', $styles) !!}"
     @endif
>
    <div class="column is-2 label">
        <strong>menu</strong>:
    </div>
    <div class="column is-10 value">
        <div>

            <div class="floating-div-container settings">

                <div class="show-container card floating-div">
                    <span>
                        @include('admin.components.checkbox', [ 'checked' => !empty($menu) ])
                    </span>
                    <span><strong>include</strong></span>
                </div>

                <div class="item show-container card floating-div">
                    <span><strong>sequence:</strong></span>
                    <span>{{ $menu_level }}</span>
                </div>

            </div>

        </div>

    </div>
</div>
