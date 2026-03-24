@php
    $city  = $city ?? request()->query('city');
@endphp
    @include('admin.components.input-basic', [
        'name'    => 'city',
        'value'   => $city,
        'message' => $message ?? '',
    ])
