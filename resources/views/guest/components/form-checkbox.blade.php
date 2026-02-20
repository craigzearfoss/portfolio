@php
    $id = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
@endphp
<div class="field">
    <div class="control">
        <label class="label" for="{{ $id }}">
            @if(empty($nohidden))
                <input type="hidden" name="{!! $name ?? 'name' !!}" value="{!! $unchecked_value ?? '0' !!}">
            @endif
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
                @if (!empty($onclick))onchange="{!! $onclick !!}" @endif
            >
            {!! $label ?? $name ?? '' !!}
        </label>

        @error($name ?? 'name')
            <p class="help is-danger">{{ $message }}</p>
        @enderror

    </div>

    @error($name ?? 'name')
        <p class="help is-danger">{{ $message }}</p>
    @enderror

</div>
