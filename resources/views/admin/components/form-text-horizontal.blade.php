@php
    $id = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
@endphp
<div class="field is-horizontal">
    <div class="field-label is-normal">
        <label class="label">{{ $label ?? $name ?? '#label#' }}</label>
    </div>
    <div class="field-body">
        <div class="field">
            <div class="control">
                <span class="text-field">{{ $value ?? '' }}</span>
            </div>

            @error($name ?? 'name')
                <p class="help is-danger">{{ $message }}</p>
            @enderror

        </div>
    </div>
</div>
