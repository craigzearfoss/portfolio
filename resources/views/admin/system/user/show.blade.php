@php
    $buttons = [];
    if (canDelete($user)) {
        $buttons[] = [ 'name' => '<i class="fa fa-key"></i>Change Password', 'href' => route('admin.system.user.change-password', $user->id) ];
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.system.user.edit', $user) ];
    }
    if (canCreate($user, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New User', 'href' => route('admin.system.user.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.system.user.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'User: ' . $user->username,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Users',           'href' => route('admin.system.user.index') ],
        [ 'name' => $user->username ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $user->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'user name',
            'value' => $user->username
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($user->name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'title',
            'value' => htmlspecialchars($user->title)
        ])

        @include('admin.components.show-row', [
            'name'  => 'role',
            'value' => htmlspecialchars($user->role)
        ])

        @include('admin.components.show-row', [
            'name'  => 'employer',
            'value' => htmlspecialchars($user->employer)
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                           'street'          => htmlspecialchars($user->street),
                           'street2'         => htmlspecialchars($user->street2 ),
                           'city'            => htmlspecialchars($user->city),
                           'state'           => $user->state->code ?? '',
                           'zip'             => htmlspecialchars($user->zip),
                           'country'         => $user->country->iso_alpha3 ?? '',
                           'streetSeparator' => '<br>',
                       ])
        ])

        @include('admin.components.show-row-coordinates', [
            'resource' => $user
        ])

        @include('admin.components.show-row', [
            'name'  => 'phone',
            'value' => htmlspecialchars($user->phone)
        ])

        @include('admin.components.show-row', [
            'name'  => 'email',
            'value' => htmlspecialchars($user->email)
        ])

        @include('admin.components.show-row', [
            'name'  => 'email verified at',
            'value' => longDateTime($user->email_verified_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'birthday',
            'value' => longDate($user->birthday),
        ])

        @include('guest.components.show-row-link', [
            'name'   => $user->link_name ?? 'link',
            'href'   => $user->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($user->description)
        ])

        @include('admin.components.show-row', [
            'name'  => 'bio',
            'value' => $user->bio
        ])

        @include('admin.components.show-row-images', [
            'resource' => $user,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row', [
            'name'  => 'status',
            'value' => \App\Models\System\User::statusName($user->status)
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $user,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($user->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($user->updated_at)
        ])

    </div>

@endsection
