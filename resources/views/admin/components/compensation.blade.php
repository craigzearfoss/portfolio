@php
    $symbol = !empty($symbol) ? $symbol : '$';
    $min = !empty($min) ? $min : null;
    $max = !empty($max) ? $max : null;
    $unit = !empty($unit) ? $unit : null;

    if (!is_null($short) && boolval($short)) {
        if (!empty($min)) {
            $min = ($min > 999) ? number_format(floor($min / 1000)) . 'k' : floor($min) . 'k';
        }
        if (!empty($max)) {
            $max = ($max > 999) ? number_format(floor($max / 1000)) . 'k' : floor($max) . 'k';
        }
    } else {
        $min = number_format($min);
        $max = number_format($max);
    }

    if (!empty($min) && !empty($max)) {
        $val = $symbol . $min . ' / ' . $symbol . $max . (!empty($unit) ? ' ' . $unit : '');
    } elseif (!empty($min)) {
        $val = $symbol . $min . (!empty($unit) ? ' ' . $unit : '');
    } elseif (!empty($max)) {
        $val = $symbol . $max . (!empty($unit) ? ' ' . $unit : '');
    } else {
        $val = '';
    }
@endphp
{{ $val }}
