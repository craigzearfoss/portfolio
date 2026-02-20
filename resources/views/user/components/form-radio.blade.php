@php
    $id = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
@endphp
<div class="field">
    <label class="label">@TODO: {!! $label ?? $name ?? '' !!}</label>
    <div class="control">
        <label class="radio" for="inputAnswerYes">
            <input type="radio" id="inputAnswerYes" name="answer" />
            Yes
        </label>
        <label class="radio" for="inputAnswerNo">
            <input type="radio" id="inputAnswerNo" name="answer" />
            No
        </label>
    </div>

    @error($name ?? 'name')
        <p class="help is-danger">{!! $message !!}</p>
    @enderror

</div>
