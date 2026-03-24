@php
    $role  = $role ?? request()->query('role');
@endphp
    @include('user.components.input-basic', [
        'name'    => 'role',
        'value'   => $role,
        'message' => $message ?? '',
    ])
