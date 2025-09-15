@php
    $id = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
@endphp
<div class="field">
    <label for="{{ $id }}" class="label">{{ $label ?? $name ?? '#label#' }}</label>
    <div class="control">
        {{ $value ?? '' }}
    </div>

    @error($name ?? 'name')
        <p class="help is-danger">{{ $message }}</p>
    @enderror

</div>
