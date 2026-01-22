@php
    $buttons = [];
    if (canUpdate($owner, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['Edit', 'href' => route('admin.system.admin.edit', $owner)])->render();
    }
    if (canCreate('admin', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Admin', 'href' => route('admin.system.admin.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => route('admin.system.admin.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Admin: ' . $owner->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('home') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Admins',          'href' => route('admin.system.admin.index') ],
        [ 'name' => $owner->username ]
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $owner->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'user name',
            'value' => $owner->username
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $owner->name
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'current team',
            'label'  => $owner->team->name,
            'href'   => route('admin.system.admin-team.show', [$owner->team->id])
        ])

        @include('admin.components.show-row', [
            'name'  => 'teams',
            'value' => implode(',', $owner->teams->pluck('name')->toArray())
        ])


        @include('admin.components.show-row', [
            'name'  => 'salutation',
            'value' => $owner->salutation
        ])

        @include('admin.components.show-row', [
            'name'  => 'title',
            'value' => $owner->title
        ])

        @include('admin.components.show-row', [
            'name'  => 'role',
            'value' => $owner->role
        ])

        @include('admin.components.show-row', [
            'name'  => 'employer',
            'value' => $owner->employer
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                           'street'          => $owner->street,
                           'street2'         => $owner->street2,
                           'city'            => $owner->city,
                           'state'           => $owner->state->code ?? '',
                           'zip'             => $owner->zip,
                           'country'         => $owner->country->iso_alpha3 ?? '',
                           'streetSeparator' => '<br>',
                       ])
        ])

        @include('admin.components.show-row-coordinates', [
            'resource' => $owner
        ])

        @include('admin.components.show-row', [
            'name'  => 'phone',
            'value' => $owner->phone
        ])

        @include('admin.components.show-row', [
            'name'  => 'email',
            'value' => $owner->email
        ])

        @include('admin.components.show-row', [
            'name'  => 'email verified at',
            'value' => longDateTime($owner->email_verified_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'birthday',
            'value' => longDate($owner->birthday),
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($owner->link_name) ? $owner->link_name : 'link',
            'href'   => $owner->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'bio',
            'value' => $owner->bio
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $owner->description
        ])

        @include('admin.components.show-row-images', [
            'resource' => $owner,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row', [
            'name'  => 'status',
            'value' => \App\Models\System\User::statusName($owner->status)
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $owner,
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'requires re-login',
            'checked' => $owner->requires_relogin
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($owner->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($owner->updated_at)
        ])

    </div>

@endsection
