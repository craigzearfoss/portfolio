@php
    $id = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
@endphp
<div class="field">
    <label class="label">@TODO: {{ $label ?? $name ?? '#label#' }}</label>
    <div class="control">
        <label class="radio">
            <input type="radio" name="answer" />
            Yes
        </label>
        <label class="radio">
            <input type="radio" name="answer" />
            No
        </label>
    </div>

    @error($name ?? 'name')
        <p class="help is-danger">{{ $message }}</p>
    @enderror

</div>
