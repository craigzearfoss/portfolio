@php
    $name = $name ?? 'favorite_count';
    $label = $label ?? $name;
    $id    = $id ?? 'input' . ucfirst($name);

    $class = !empty($class)
        ? (!is_array($class) ? explode(' ', $class) : $class)
        : [];
    if (!in_array('input', $class)) $class[] = 'input';
    if (!in_array('has-text-centered', $class)) $class[] = 'has-text-centered';

    $style = !empty($style)
        ? (!is_array($style) ? explode(';', $style) : $style)
        : [];
    if (!in_array('has-text-centered', $class)) $class[] = 'has-text-centered';
@endphp
<div class="card favorites-box m-1" style="width: 6rem;display: block; position: absolute; top: 0; right: 0;">
    <div class="card-header pl-2 pr-1 has-text-centered has-background-grey-light" style="width: 100%;">
        <label class="has-text-centered"
               style="width: 100%;"
               for="{{ $id }}"
        >{{ $label }}</label>
    </div>
    <div class="card-body has-background-white has-text-centered" style="width: 100%;">
        @include('guest.components.input', [
            'type'  => 'number',
            'name'  => $name,
            'label' => $label,
            'min'   => 0,
            'value' => $value,
            'class' => $class,
            'style' => [ 'width: 100%' ],
        ])
    </div>
</div>
