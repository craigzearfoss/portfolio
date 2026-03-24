@php
    $role  = $role ?? request()->query('role');
@endphp
@include('admin.components.input-basic', [
    'name'    => 'role',
    'value'   => $role,
    'message' => $message ?? '',
])
