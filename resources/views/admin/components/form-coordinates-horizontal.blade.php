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
        <label class="label">{!! $label ?? 'coordinates' !!}</label>
    </div>
    <div class="field-body">

        <div class="content mb-0 mr-2">
            <div class="control">
                <input class="input {!! $class !!} @error('role') is-invalid @enderror"
                       type="text"
                       id="inputLatitude"
                       name="latitude"
                       value="{!! $latitude !!}"
                       placeholder="latitude"
                       maxlength="255"
                >
            </div>

            @error('latitude')
                <p class="help is-danger">{!! $message ?? '' !!}</p>
            @enderror

        </div>

        <div class="content mb-0 ">
            <div class="control">
                <input class="input {!! $class !!} @error('role') is-invalid @enderror"
                       type="text"
                       id="inputLongitude"
                       name="longitude"
                       value="{!! $longitude !!}"
                       placeholder="longitude"
                       maxlength="255"
                >
            </div>

            @error('longitude')
                <p class="help is-danger">{!! $message ?? '' !!}</p>
            @enderror

        </div>

    </div>
</div>
