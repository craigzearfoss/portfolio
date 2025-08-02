<div class="mb-3">
    <label for="input{{ !empty($name) ? ucfirst($name) : 'Name' }}" class="form-label mb-1">{{ $label ?? $name ?? '#label#' }}</label>
    <input
        type="{{ $type ?? 'text' }}"
        id="input{{ !empty($name) ? ucfirst($name) : 'Name' }}"
        name="{{ $name ?? 'name' }}"
        value="{{ $value ?? '' }}"
        class="form-control {{ $class ?? '' }} @error('role') is-invalid @enderror"
        @if (!empty($style))style="{{ is_array($style) ? implode('; ', $style) . ';' : $style }}" @endif
        @if (!empty($autocomplete))autocomplete="{{ $autocomplete }}" @endif
        @if (!empty($autofocus))autofocus="{{ $autofocus }}" @endif
        @if (!empty($disabled))disabled @endif
        @if (!empty($form))form="{{ $form }}" @endif
        @if (!empty($height))height="{{ $height }}" @endif
        @if (!empty($max))max="{{ $max }}" @endif
        @if (!empty($maxlength))maxlength="{{ $maxlength }}" @endif
        @if (!empty($min))min="{{ $min }}" @endif
        @if (!empty($minlength))minlength="{{ $minlength }}" @endif
        @if (!empty($placeholder))placeholder="{{ $placeholder }}" @endif
        @if (!empty($readonly))readonly @endif
        @if (!empty($required))required @endif
        @if (!empty($width))width="{{ $width }}" @endif
    >
    @error($name ?? 'name')
        <div class="form-text text-danger">{{ $message }}</div>
    @enderror
</div>
