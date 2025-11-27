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
        <label class="label">{{ $label ?? 'location' }}</label>
    </div>
    <div class="field-body">

        <div class="field">
            <div class="control">
                <input class="input {{ $class }} @error('role') is-invalid @enderror"
                       type="text"
                       id="inputStreet"
                       name="street"
                       value="{{ $street }}"
                       placeholder="street"
                       maxlength="255"
                >
            </div>

            @error('street')
                <p class="help is-danger">{{ $message ?? '' }}</p>
            @enderror

        </div>

    </div>
</div>

<div class="field is-horizontal">
    <div class="field-label">
        <label class="label"></label>
    </div>
    <div class="field-body">

       <div class="field">
            <div class="control">
                <input class="input {{ $class }} @error('role') is-invalid @enderror"
                       type="text"
                       id="inputStreet2"
                       name="street2"
                       value="{{ $street2 }}"
                       placeholder="street2"
                       maxlength="255"
                >
            </div>

            @error('street2')
            <p class="help is-danger">{{ $message ?? '' }}</p>
            @enderror

        </div>

    </div>
</div>

<div class="field is-horizontal mb-0">
    <div class="field-label mb-2">
        <label class="label" style="min-width: 10em !important;"></label>
    </div>
    <div class="field-body has-text-left">

        <div class="mb-0 mr-2 mb-2">
            <input class="input {{ $class }} @error('role') is-invalid @enderror"
                   type="text"
                   id="inputCity"
                   name="city"
                   value="{{ $city }}"
                   placeholder="city"
                   maxlength="255"
            >

            @error('city')
                <p class="help is-danger">{{ $message ?? '' }}</p>
            @enderror

       </div>

        <div class="mb-0 mr-2 mb-2">
            <div class="select">
                <select
                    id="inputState_id"
                    name="state_id"
                    class="form-select {{ $class ?? '' }}"
                >
                    @foreach ($states as $stateValue=>$stateName)
                        <option value="{{ $stateValue }}" @if ($stateValue == $state_id)selected @endif >
                            {{ $stateName }}
                        </option>
                    @endforeach
                </select>

                @error('state_id')
                    <p class="help is-danger">{{ $message ?? '' }}</p>
                @enderror

            </div>
        </div>

        <div class="field mb-0 mr-0 mb-2">
            <div class="control">
                <input class="input {{ $class }} @error('role') is-invalid @enderror"
                       type="text"
                       id="inputZip"
                       name="zip"
                       value="{{ $zip }}"
                       placeholder="zip"
                       maxlength="20"
                >
            </div>

            @error('zip')
                <p class="help is-danger">{{ $message ?? '' }}</p>
            @enderror

        </div>
    </div>

</div>

<div class="field is-horizontal">
    <div class="field-label">
        <label class="label" style="min-width: 10em !important;"></label>
    </div>
    <div class="field-body">

        <div class="field mb-0">
            <div class="select">
                <select
                    id="inputCountry_id"
                    name="country_id"
                    class="form-select {{ $class ?? '' }}"
                >
                    @foreach ($countries as $countryValue=>$countryName)
                        <option value="{{ $countryValue }}" @if ($countryValue == $country_id)selected @endif >
                            {{ $countryName }}
                        </option>
                    @endforeach
                </select>

                @error('country_id')
                    <p class="help is-danger">{{ $message ?? '' }}</p>
                @enderror

            </div>

        </div>
    </div>

</div>
