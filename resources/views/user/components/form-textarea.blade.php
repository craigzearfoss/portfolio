@php
    $id = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
@endphp
<div class="mb-3">
    <label for="{{ $id }}" class="form-label mb-1">{{ $label ?? $name ?? '#label#' }}</label>
    <textarea
        id="{{ $id }}"
        name="{{ $name ?? 'name' }}"
        class="form-control {{ $class ?? '' }}"
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
    @error($name ?? 'name')
        <div class="form-text text-danger">{{ $message }}</div>
    @enderror
</div>
