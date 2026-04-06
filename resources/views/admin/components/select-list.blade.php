@php
    $id  = $id ?? $name ?? '';
    $name = $name ?? null;
    if (!empty($value) && !in_array($value, array_keys($list))) {
        $list[$value] = $value;
    }
    $label = $label ?? $name ?? null;
    $title = $title ?? null;

    $class = !empty($class) ? (!is_array($class) ? explode(' ', $class) : $class) : [];
    $class[] = 'form-select';
    $style = !empty($style) ? (!is_array($style) ? explode(';', $style) : $style) : [];
@endphp
<select
    @if($id)
        id="{{ $id }}"
    @endif
    @if($name)
        name="{{ $name }}"
    @endif
    @if(!empty($class))
        class="{{ implode(' ', $class) }}"
    @endif
    @if (!empty($style))
        style="{{ implode('; ', $style) }}"
    @endif
    @if (!empty($autofocus))
        autofocus
    @endif
    @if (!empty($readonly))
        disabled
    @endif
    @if (!empty($form))
        form="{!! $form !!}"
    @endif
    @if (!empty($multiple))
        multiple
    @endif
    @if (!empty($required))
        required
    @endif
    @if (!empty($size))
        size="{{ $size }}"
    @endif
    @if (!empty($onchange))
        onchange="{!! $onchange !!}"
    @endif
>
    @foreach ($list as $listValue=>$listName)
        <option value="{!! $listValue !!}"
                {{ $listValue == $value ? 'selected' : '' }}
        >
            {!! $listName !!}
        </option>
    @endforeach
</select>

@error($name ?? 'name')
    <p class="help is-danger">{!! $message !!}</p>
@enderror
