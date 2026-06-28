@php
    $class   = !empty($class)
        ? $class = is_array($class) ? $class : explode('; ', $class)
        : [];

    $style = !empty($style)
        ? is_array($style) ? $style : explode('; ', $style)
        : [];
@endphp
<div class="field is-horizontal">
    <div class="field-label">
        <label class="label" for="inputStreet">{!! $label ?? 'location' !!}</label>
    </div>
    <div class="field-body">

        <div class="field">
            @include('user.components.input', [
                'name'        => 'street',
                'id'          => 'inputStreet',
                'value'       => $street,
                'placeholder' => 'street',
                'maxlength'   => 255,
                'class'       => array_merge($class, [ 'input', 'input-street' ])
            ])
            @error('street')
                <p class="help is-danger">{!! $message ?? '' !!}</p>
            @enderror

        </div>

    </div>
</div>

<div class="field is-horizontal">
    <div class="field-label">
        <label class="label" for="inputStreet2"></label>
    </div>
    <div class="field-body">

       <div class="field">
            @include('user.components.input', [
                'name'        => 'street2',
                'id'          => 'inputStreet2',
                'value'       => $street2,
                'placeholder' => 'street2',
                'maxlength'   => 255,
                'class'       => array_merge($class, [ 'input', 'input-street' ])
            ])
            @error('street2')
                <p class="help is-danger">{!! $message ?? '' !!}</p>
            @enderror

        </div>

    </div>
</div>

<div class="field is-horizontal">
    <div class="field-label">
        <label class="label" for="inputCity" style="min-width: 10em !important;"></label>
    </div>
    <div class="field-body has-text-left">

        <div>
            @include('user.components.input', [
                'name'        => 'city',
                'id'          => 'inputCity',
                'value'       => $city,
                'placeholder' => 'city',
                'maxlength'   => 255,
                'class'       => array_merge($class, [ 'input', 'input-city' ])
            ])
            @error('city')
                <p class="help is-danger">{!! $message ?? '' !!}</p>
            @enderror

        </div>

        @include('user.components.select-list-with-typeahead', [
            'name'        => 'state_id',
            'list'        => $states,
            'value'       => $state_id ?? null,
            'placeholder' => 'state',
            'class'       => array_merge($class, [ 'select', 'select-state' ])
        ])

        <div class="field">
            @include('user.components.input', [
                'name'        => 'zip',
                'id'          => 'inputZip',
                'value'       => $zip,
                'placeholder' => 'zip',
                'maxlength'   => 20,
                'class'       => array_merge($class, [ 'input', 'input-zip' ])
            ])
            @error('zip')
                <p class="help is-danger">{!! $message ?? '' !!}</p>
            @enderror

        </div>
    </div>

</div>

<div class="field is-horizontal">
    <div class="field-label">
        <label class="label" for="inputCountry_id" style="min-width: 10em !important;"></label>
    </div>
    <div class="field-body">

        @include('user.components.select-list-with-typeahead', [
            'name'        => 'country_id',
            'list'        => $countries,
            'value'       => $country_id ?? null,
            'placeholder' => 'country',
            'class'       => array_merge($class, [ 'select', 'select-country' ]),
            'style'       => [ 'width: 20rem' ],
        ])

    </div>

</div>
