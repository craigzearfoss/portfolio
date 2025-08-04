@php
    $id = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
@endphp
<div class="mb-3">
    <input type="hidden" name="{{ $name ?? 'name' }}" value="{{ $unchecked_value ?? '0' }}">
    <input
        type="checkbox"
        id="{{ $id }}"
        name="active"
        value="{{ $value ?? '0' }}"
        @if (!empty($checked))checked @endif
        class="form-check-input {{ $class ?? '' }}"
        @if (!empty($style))style="{{ is_array($style) ? implode('; ', $style) . ';' : $style }}" @endif
        @if (!empty($autofocus))autofocus="{{ $autofocus }}" @endif
        @if (!empty($disabled) || !empty($readonly))disabled @endif
        @if (!empty($form))form="{{ $form }}" @endif
        @if (!empty($readonly))readonly @endif
        @if (!empty($required))required @endif
    >
    <label for="{{ $id }}" class="form-check-label mb-1 font-semibold">{{ $label ?? $name ?? '#label#' }}</label>
    @error($name ?? 'name')
        <div class="form-text text-danger">{{ $message }}</div>
    @enderror
</div>
