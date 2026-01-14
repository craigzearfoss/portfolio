@php
    $id = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
@endphp
<div class="field is-horizontal">
    <div class="field-label">
        <label class="label">{!! $label ?? $name ?? '' !!}</label>
    </div>
    <div class="field-body">
        <div class="control">
            <div class="control pt-1">
                    <input type="hidden" name="{!! $name ?? 'name' !!}" value="{!! $unchecked_value ?? '0' !!}">
                    <input
                        type="checkbox"
                        id="{!! $id !!}"
                        name="{!! $name ?? 'name' !!}"
                        value="{!! $value ?? '0' !!}"
                        @if (!empty($checked))checked @endif
                        class="form-check-input {!! $class ?? '' !!}"
                        @if (!empty($style))style="{!! is_array($style) ? implode('; ', $style) . ';' : $style !!}" @endif
                        @if (!empty($autofocus))autofocus @endif
                        @if (!empty($disabled) || !empty($readonly))disabled @endif
                        @if (!empty($form))form="{!! $form !!}" @endif
                        @if (!empty($readonly))readonly @endif
                        @if (!empty($required))required @endif
                    >
            </div>
        </div>

        @error($name ?? 'name')
            <p class="help is-danger">{!! $message !!}</p>
        @enderror

    </div>
</div>
