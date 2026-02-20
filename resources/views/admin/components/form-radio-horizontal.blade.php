@php
    $id = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
@endphp
<div class="field is-horizontal">
    <div class="field-label">
        <label class="label">@TODO: {!! $label ?? $name ?? '' !!}</label>
    </div>
    <div class="field-body">
        <div class="field is-narrow">
            <div class="control">
                <label class="radio" for="inputMemberYes">
                    <input type="radio" id="inputMemberYes" name="member">
                    Yes
                </label>
                <label class="radio" for="inputMemberNo">
                    <input type="radio" id="inputMemberNo" name="member">
                    No
                </label>

                @error($name ?? 'name')
                    <p class="help is-danger">{!! $message !!}</p>
                @enderror

            </div>
        </div>
    </div>
</div>
