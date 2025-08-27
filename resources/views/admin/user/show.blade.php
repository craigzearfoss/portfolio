@extends('admin.layouts.default', [
    'title' => $user->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Users', 'url' => route('admin.user.index')],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-key"></i>Change Password', 'url' => route('admin.user.change_password', $user->id) ],
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'url' => route('admin.user.edit', $user) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New User',  'url' => route('admin.user.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'url' => route('admin.user.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card">

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $user->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'street',
            'value' => $user->street
        ])

        @include('admin.components.show-row', [
            'name'  => 'street2',
            'value' => $user->street2
        ])

        @include('admin.components.show-row', [
            'name'  => 'city',
            'value' => $user->city
        ])

        @include('admin.components.show-row', [
            'name'  => 'state',
            'value' => \App\Models\State::getName($user->state)
        ])

        @include('admin.components.show-row', [
            'name'  => 'zip',
            'value' => $user->zip
        ])

        @include('admin.components.show-row', [
            'name'  => 'country',
            'value' => \App\Models\Country::getName($user->country)
        ])

        @include('admin.components.show-row', [
            'name'  => 'phone',
            'value' => $user->phone
        ])

        @include('admin.components.show-row', [
            'name'  => 'email',
            'value' => $user->email
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'website',
            'url'    => $user->website,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'status',
            'value' => \App\Models\User::statusName($user->status)
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $user->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'email verified at',
            'value' => longDateTime($user->email_verified_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($user->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($user->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($user->deleted_at)
        ])

    </div>

@endsection
