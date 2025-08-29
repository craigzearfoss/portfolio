@php
    $id = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
@endphp
<div class="field is-horizontal">
    <div class="field-label">
        <label class="label">@TODO: {{ $label ?? $name ?? '#label#' }}</label>
    </div>
    <div class="field-body">
        <div class="field is-narrow">
            <div class="control">
                <label class="radio">
                    <input type="radio" name="member">
                    Yes
                </label>
                <label class="radio">
                    <input type="radio" name="member">
                    No
                </label>

                @error($name ?? 'name')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror

            </div>
        </div>
    </div>
</div>
