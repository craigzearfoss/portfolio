@php

    $class = !empty($class) ? (!is_array($class) ? explode(' ', $class) : $class) : [];
    $class[] = 'form-select';
    $style = !empty($style) ? (!is_array($style) ? explode(';', $style) : $style) : [];

    $sort = $sort ?? '';
@endphp
<div class="control sort-control">
    <div class="field">
        <div class="label">Sort by</div>
        <div class="{{ implode(' ', array_merge([ 'select' ], $class)) }}"
             @if(!empty($style))
                 style="{{ implode('; ', $style) }}"
             @endif
        >
            @include('guest.components.select-list', [
                'name'                 => 'sort',
                'label'                => null,
                'value'                => $sort ?? '',
                'list'                 => $list ?? [],
                'class'                => $class ?? [],
                'style'                => $style ?? [],
                'add_undefined_option' => false,
            ])
        </div>
    </div>
</div>
