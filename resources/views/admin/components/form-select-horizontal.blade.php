@php
    $id = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
    if (!empty($value) && !in_array($value, array_keys($list))) {
        $list[$value] = $value;
    }
@endphp
<div class="field is-horizontal">
    <div class="field-label">
        <label class="label" for="{{ $id }}">{!! $label ?? $name ?? '' !!}</label>
    </div>
    <div class="field-body">
        <div class="field">
            <div class="select">
                <select
                    id="{!! $id !!}"
                    name="{!! $name ?? 'name' !!}"
                    class="{!! $class ?? '' !!}"
                    @if (!empty($style))style="{!! is_array($style) ? (implode('; ', $style) . ';') : $style !!}" @endif
                    @if (!empty($autofocus))autofocus @endif
                    @if (!empty($readonly))disabled @endif
                    @if (!empty($form))form="{!! $form !!}" @endif
                    @if (!empty($multiple))multiple @endif
                    @if (!empty($required))required @endif
                    @if (!empty($size))size="{{ $size }}" @endif
                    @if (!empty($onchange))onchange="{!! $onchange !!}" @endif
                >
                    @foreach ($list as $listValue=>$listName)
                        <option value="{!! $listValue !!}" @if ($listValue == $value)selected @endif >
                            {!! $listName !!}
                        </option>
                    @endforeach
                </select>
            </div>

            @error($name ?? 'name')
                <p class="help is-danger">{!! $message !!}</p>
            @enderror

        </div>
    </div>
</div>
