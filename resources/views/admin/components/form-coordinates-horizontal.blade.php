@php
    $class   = !empty($class)
        ? $class = is_array($class) ? $class : explode('; ', $class)
        : [];
    if (!in_array('input', $class)) $class[] = 'input';
    if (!in_array('input-coordinate', $class)) $class[] = 'input-coordinate';

    $style = !empty($style)
        ? is_array($style) ? $style : explode('; ', $style)
        : [];
@endphp
<div class="field is-horizontal">
    <div class="field-label">
        <label class="label" for="inputLatitude">{!! $label ?? 'coordinates' !!}</label>
    </div>
    <div class="field-body">

        <div class="content mb-0 mr-2">
            <div class="control">
                <input class="{{ implode(' ', $class) }}@error('role') is-invalid @enderror"
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
                <input class="{{ implode(' ', $class) }}@error('role') is-invalid @enderror"
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
