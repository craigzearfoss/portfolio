@php
    $style = !empty($style)
        ? (is_array($style) ? $style : explode(';', $style))
        : [];

    // get styles for defined properties
    $styleArray = [];
    if (!empty($width)) $styleArray[] = 'width: '. $width . ';';
    if (!empty($minWidth)) $styleArray[] = 'min-width: '. $minWidth . ';';
    if (!empty($display)) $styleArray[] = 'display: '. $display . ';';
    if (!empty($whiteSpace)) $styleArray[] = 'white-space: '. $whiteSpace . ';';
    if (!empty($styleArray)) {
        $style = array_merge($style, $styleArrayt);
    }

    $style = implode(' ', $style);
    $class = !empty($class) ? (is_array($class) ? implode(' ', $class) : $class) : '';
@endphp
<div class="columns {!! $class !!}" {!! $style !!}>
    <div class="column is-2" style="min-width: 6rem;">
        @if(!empty($name))
            <strong>{!! $name !!}</strong>:
        @endif
    </div>
    <div class="column is-10 pl-0">{!! $value ?? '' !!}</div>
</div>
