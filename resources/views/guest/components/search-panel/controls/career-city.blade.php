@php
    $city  = $city ?? request()->query('city');
@endphp
    @include('guest.components.input-basic', [
        'name'    => 'city',
        'value'   => $city,
        'message' => $message ?? '',
    ])
