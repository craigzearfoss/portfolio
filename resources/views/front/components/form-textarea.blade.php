@php
    $id = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
@endphp
<div class="field">
    <label for="{{ $id }}" class="label">{{ $label ?? $name ?? '#label#' }}</label>
    <div class="control">
        <textarea class="textarea {{ $class ?? '' }}"
                  id="{{ $id }}"
                  name="{{ $name ?? 'name' }}"
                  @if (!empty($style))style="{{ is_array($style) ? implode('; ', $style) . ';' : $style }}" @endif
                  @if (!empty($autofocus))autofocus="{{ $autofocus }}" @endif
                  @if (!empty($cols))size="{{ $cols }}" @endif
                  @if (!empty($disabled))disabled @endif
                  @if (!empty($maxlength))maxlength="{{ $maxlength }}" @endif
                  @if (!empty($placeholder))placeholder="{{ $placeholder }}" @endif
                  @if (!empty($readonly))readonly @endif
                  @if (!empty($required))required @endif
                  @if (!empty($rows))size="{{ $rows }}" @endif
                  @if (!empty($size))size="{{ $size }}" @endif
        >{{ $value ?? '' }}</textarea>
    </div>

    @error($name ?? 'name')
        <p class="help is-danger">{{ $message }}</p>
    @enderror

</div>
