@php
    $city  = $city ?? request()->query('city');
@endphp
    @include('user.components.input-basic', [
        'name'    => 'city',
        'value'   => $city,
        'message' => $message ?? '',
    ])
