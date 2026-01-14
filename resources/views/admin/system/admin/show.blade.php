@php
    $buttons = [];
    if (canDelete($admin, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => adminRoute('admin.admin.edit', $admin) ];
    }
    if (canCreate($admin, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Admin', 'href' => adminRoute('admin.admin.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.system.admin.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Admin: ' . $admin->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => adminRoute('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => adminRoute('admin.dashboard') ],
        [ 'name' => 'System',          'href' => adminRoute('admin.index') ],
        [ 'name' => 'Admins',          'href' => route('admin.admin.index') ],
        [ 'name' => $admin->username ]
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $admin->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'user name',
            'value' => $admin->username
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $admin->name
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'current team',
            'label'  => htmlspecialchars($admin->team->name ?? ''),
            'href'   => adminRoute('admin.admin-team.show', [$admin, $admin->team->id])
        ])

        @include('admin.components.show-row', [
            'name'  => 'teams',
            'value' => implode(',', $admin->teams->pluck('name')->toArray())
        ])


        @include('admin.components.show-row', [
            'name'  => 'salutation',
            'value' => $admin->salutation
        ])

        @include('admin.components.show-row', [
            'name'  => 'title',
            'value' => $admin->title
        ])

        @include('admin.components.show-row', [
            'name'  => 'role',
            'value' => $admin->role
        ])

        @include('admin.components.show-row', [
            'name'  => 'employer',
            'value' => $admin->employer
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                           'street'          => $admin->street,
                           'street2'         => $admin->street2,
                           'city'            => $admin->city,
                           'state'           => $admin->state->code ?? '',
                           'zip'             => $admin->zip,
                           'country'         => $admin->country->iso_alpha3 ?? '',
                           'streetSeparator' => '<br>',
                       ])
        ])

        @include('admin.components.show-row-coordinates', [
            'resource' => $admin
        ])

        @include('admin.components.show-row', [
            'name'  => 'phone',
            'value' => $admin->phone
        ])

        @include('admin.components.show-row', [
            'name'  => 'email',
            'value' => $admin->email
        ])

        @include('admin.components.show-row', [
            'name'  => 'email verified at',
            'value' => longDateTime($admin->email_verified_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'birthday',
            'value' => longDate($admin->birthday),
        ])

        @include('admin.components.show-row-link', [
            'name'   => $admin->link_name ?? 'link',
            'href'   => $admin->link ?? '',
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'bio',
            'value' => $admin->bio
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $admin->description
        ])

        @include('admin.components.show-row-images', [
            'resource' => $admin,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row', [
            'name'  => 'status',
            'value' => \App\Models\System\User::statusName($admin->status)
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $admin,
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'requires re-login',
            'checked' => $admin->requires_relogin
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($admin->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($admin->updated_at)
        ])

    </div>

@endsection
