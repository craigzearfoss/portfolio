@php
    $buttons = [];
    if (canDelete($user)) {
//@TODO: Need to add these admin user pages
        $buttons[] = [ 'name' => '<i class="fa fa-key"></i>Change Password', 'href' => route('root.user.change-password', $user->id) ];
//        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('root.user.edit', $user) ];
    }
    if (canCreate($user, getAdminId())) {
//        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New User', 'href' => route('root.user.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('root.user.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => $pageTitle ?? 'User: ' . $user->username,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.index') ],
        [ 'name' => 'Users',           'href' => route('root.user.index') ],
        [ 'name' => $user->username ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
])

@section('content')

    <div class="show-container card p-4">

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
            'value' => $user->name
        ])
<?php /* @TODO
        @include('admin.components.show-row', [
            'name'  => 'teams',
            'value' => implode(',', $user->teams->pluck('name')->toArray())
        ])
*/ ?>

        @include('admin.components.show-row', [
            'name'  => 'salutation',
            'value' => $user->salutation
        ])

        @include('admin.components.show-row', [
            'name'  => 'title',
            'value' => $user->title
        ])

        @include('admin.components.show-row', [
            'name'  => 'role',
            'value' => $user->role
        ])

        @include('admin.components.show-row', [
            'name'  => 'employer',
            'value' => $user->employer
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                           'street'          => $user->street,
                           'street2'         => $user->street2,
                           'city'            => $user->city,
                           'state'           => $user->state->code ?? '',
                           'zip'             => $user->zip,
                           'country'         => $user->country->iso_alpha3 ?? '',
                           'streetSeparator' => '<br>',
                       ])
        ])

        @include('admin.components.show-row-coordinates', [
            'resource' => $user
        ])

        @include('admin.components.show-row', [
            'name'  => 'phone',
            'value' => $user->phone
        ])

        @include('admin.components.show-row', [
            'name'  => 'email',
            'value' => $user->email
        ])

        @include('admin.components.show-row', [
            'name'  => 'email verified at',
            'value' => longDateTime($user->email_verified_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'birthday',
            'value' => longDate($user->birthday),
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($user->link_name) ? $user->link_name : 'link',
            'href'   => $user->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $user->description
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
            'value' => \App\Models\System\User::statusName($user->status) ?? ''
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
