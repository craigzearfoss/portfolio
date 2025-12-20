@extends('admin.layouts.default', [
    'title'         => 'Session: ' . $session->id,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Sessions',        'href' => route('admin.system.session.index') ],
        [ 'name' => $session->id ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.system.session.index') ],
    ],
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $session->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'user_id',
            'value' => $session->user_id
        ])

        @include('admin.components.show-row', [
            'name'  => 'admin_id',
            'value' => $session->admin_id
        ])

        @include('admin.components.show-row', [
            'name'  => 'ip_address',
            'value' => $session->ipp_address
        ])

        @include('admin.components.show-row', [
            'name'  => 'last_activity',
            'value' => $session->last_activity
        ])

    </div>

@endsection
