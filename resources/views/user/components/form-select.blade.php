@php
    $id    = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
    $name  = $name ?? null;
    $label = $label ?? $name ?? null;
    $title = $title ?? null;
    $value = $value ?? '';

    $list = $list ?? [];

    // if a value was specified that's not in the options list then add it to the options list
    if (!empty($value) && !in_array($value, array_keys($list))) {
        $list[$value] = $value;
    }

    $required = $required ?? false;

    $class = !empty($class) ? (!is_array($class) ? explode(' ', $class) : $class) : [];
    if (!in_array('form-select', $class)) $class[] = 'form-select';

    $style = !empty($style) ? (!is_array($style) ? explode(';', $style) : $style) : [];

    $labelClass = [ 'label' ];
    if ($required && !in_array('label-required', $labelClass)) $labelClass[] = 'label-required';
@endphp

<div class="field">

    @if(isset($label) && ($label !== ''))

        <label
            @if($id)
                for="{{ $id }}"
            @endif
            class="{{ implode(' ', $labelClass) }}"
            @if($title)
                title="{{ $title }}"
            @endif
        >{!! $label !!}</label>

    @endif

    <div class="select">

        @include('user.components.select-list', [
            'id'        => $id,
            'name'      => $name,
            'value'     => $value,
            'list'      => $list,
            'class='    => $class,
            'style'     => $style,
            'autofocus' => $autofocus ?? false,
            'readonly'  => $readonly ?? false,
            'form'      => $form ?? null,
            'hasIcon'   => $hasIcon ?? false,
            'multiple'  => $multiple ?? false,
            'onchange'  => $onchange ?? null,
            'required'  => $required ?? false,
            'size'      => $size ?? null,
        ])

    </div>
</div>
