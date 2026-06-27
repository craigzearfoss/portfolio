@php
    $id = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));

    $class = !empty($class)
        ? (is_array($class) ? $class : explode(' ', $class))
        : [];
    if (!in_array('textarea', $class)) $class[] = 'textarea';

    $style = !empty($style)
        ? (is_array($style) ? $style : explode(';', $style))
        : [];

    // determine width
    $width = $width ?? null;

    if (empty($width)) {
        if (in_array('textarea-description', $class)) {
            $width = '54rem';
        } elseif (in_array('textarea-notes', $class)) {
            $width = '54rem';
        } elseif (in_array('textarea-definition', $class)) {
            $width = '30rem';
        } elseif (in_array('textarea-disclaimer', $class)) {
            $width = '30rem';
        } elseif (in_array('textarea-summary', $class)) {
            $width = '30rem';
        }
    }
@endphp
<div class="field is-horizontal">
    <div class="field-label is-normal">
        <label class="label" for="{{ $id }}">{!! $label ?? $name ?? '' !!}</label>
    </div>
    <div class="field-body">
        <div class="field">
            <div class="control textarea-container"
                 @if (!empty($width))
                     style="width: {{ $width }};"
                 @endif
            >
                <textarea id="{!! $id !!}"
                          name="{!! $name ?? 'name' !!}"
                          @if (!empty($class))
                              class="{{ implode(' ', $class) }}"
                          @endif
                          @if (!empty($style))
                              style="{{ implode('; ', $style) }}"
                          @endif
                          @if (!empty($autofocus))
                              autofocus
                          @endif
                          @if (!empty($cols))
                              cols="{{ $cols }}"
                          @endif
                          @if (!empty($disabled))
                              disabled
                          @endif
                          @if (!empty($maxlength))
                              maxlength="{{ $maxlength }}"
                          @endif
                          @if (!empty($placeholder))
                              placeholder="{!! $placeholder !!}"
                          @endif
                          @if (!empty($readonly))
                              readonly
                          @endif
                          @if (!empty($required))
                              required
                          @endif
                          @if (!empty($rows))
                              rows="{{ $rows }}"
                          @endif
                          @if (!empty($size))
                              size="{{ $size }}"
                    @endif
                >{!! $value ?? '' !!}</textarea>
            </div>

            @error($name ?? 'name')
                <p class="help is-danger">{!! $message !!}</p>
            @enderror

        </div>
    </div>
</div>
