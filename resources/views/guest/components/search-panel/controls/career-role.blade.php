@php
    $role  = $role ?? request()->query('role');
@endphp
    @include('guest.components.input-basic', [
        'name'    => 'role',
        'value'   => $role,
        'message' => $message ?? '',
    ])
