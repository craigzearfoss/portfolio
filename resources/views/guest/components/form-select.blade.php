@php
    $id = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
    $name = $name ?? null;
    $label = $label ?? $name ?? null;
    $title = $title ?? null;
    if (!empty($value) && !in_array($value, array_keys($list))) {
        $list[$value] = $value;
    }

    $class = !empty($class) ? (!is_array($class) ? explode(' ', $class) : $class) : [];
    $class[] = 'form-select';
    $style = !empty($style) ? (!is_array($style) ? explode(';', $style) : $style) : [];
@endphp
<div class="field">
    @if(isset($label) && ($label === ''))
    @else
        <label class="label"
               @if(!empty($id))
                   for="{{ $id }}"
               @endif
               @if($title)
                   title="{{ $title }}"
               @endif
        >
            {!! $label !!}
        </label>

    @endif
    <div class="select">
        <select
            @if(!empty($id))
                id="{{ $id }}"
            @endif
            @if(!empty($name))
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
            @if (!empty($disabled))
                disabled
            @endif
            @if (!empty($readonly))
                readonly
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
    </div>

    @error($name ?? 'name')
        <p class="help is-danger">{!! $message !!}</p>
    @enderror

</div>
