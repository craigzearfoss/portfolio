@php
$class   = !empty($class) ? $class : '';
if (!empty($style)) {
    $style = is_array($style) ? implode('; ', $style) . ';' : $style;
} else {
    $style = '';
}
@endphp
<div class="field is-horizontal">
    <div class="field-label">
        <label class="label" for="inputLink" style="min-width: 8em;">{!! $label ?? 'link' !!}</label>
    </div>
    <div class="field-body">

        <div class="content mb-0 mr-2">
            <div class="control">
                <input class="input {!! $class !!} @error('role') is-invalid @enderror"
                       type="text"
                       id="inputLink"
                       name="link"
                       value="{!! $link !!}"
                       placeholder="url"
                       maxlength="255"
                >
            </div>

            @error('link')
                <p class="help is-danger">{!! $message ?? '' !!}</p>
            @enderror

        </div>

        <div class="content mb-0 ">
            <div class="control">
                <input class="input {!! $class !!} @error('role') is-invalid @enderror"
                       type="text"
                       id="inputLink_name"
                       name="link_name"
                       value="{!! $name !!}"
                       placeholder="name"
                       maxlength="255"
                >
            </div>

            @error('link_name')
                <p class="help is-danger">{!! $message ?? '' !!}</p>
            @enderror

        </div>

    </div>
</div>
