@php
    $styles = [];
    if (!empty($width)) $styles[] = 'width: '. $width . ';';
    if (!empty($minWidth)) $styles[] = 'min-width: '. $minWidth . ';';
    if (!empty($display)) $styles[] = 'display: '. $display . ';';
    if (!empty($whiteSpace)) $styles[] = 'white-space: '. $whiteSpace . ';';

    $style = !empty($styles) ? ('style="' . implode('; ', $styles) . ';"') : '';
    $class = $class ?? '';
@endphp
<div class="columns {!! $class !!}" {!! $style !!}>
    <div class="column is-2" style="min-width: 6rem;"><strong>{!! $name ?? '' !!}</strong>:</div>
    <div class="column is-10 pl-0">{!! $value ?? '' !!}</div>
</div>
