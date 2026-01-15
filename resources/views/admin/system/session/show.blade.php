@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Session: ' . $session->id,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.index') ],
        [ 'name' => 'Sessions',        'href' => route('root.session.index') ],
        [ 'name' => $session->id ],
    ],
    'buttons'          => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('root.session.index') ],
    ],
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
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
            'value' => $session->ip_address ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'last_activity',
            'value' => $session->last_activity
        ])

    </div>

@endsection
