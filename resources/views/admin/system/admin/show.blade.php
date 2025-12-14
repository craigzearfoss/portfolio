@extends('admin.layouts.default', [
    'title' => 'Admin: ' . $admin->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Admins',          'href' => route('admin.system.admin.index') ],
        [ 'name' => $admin->username ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.system.admin.edit', $admin) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Admin', 'href' => route('admin.system.admin.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.system.admin.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
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
            'value' => htmlspecialchars($admin->name)
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'current team',
            'label'  => htmlspecialchars($admin->team->name),
            'href'   => route('admin.system.admin-team.show', $admin->team->id)
        ])

        @include('admin.components.show-row', [
            'name'  => 'teams',
            'value' => htmlspecialchars(implode(',', $admin->teams->pluck('name')->toArray()))
        ])

        @include('admin.components.show-row', [
            'name'  => 'title',
            'value' => htmlspecialchars($admin->title)
        ])

        @include('admin.components.show-row', [
            'name'  => 'role',
            'value' => htmlspecialchars($admin->role)
        ])

        @include('admin.components.show-row', [
            'name'  => 'employer',
            'value' => htmlspecialchars($admin->employer)
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                           'street'          => htmlspecialchars($admin->street),
                           'street2'         => htmlspecialchars($admin->street2),
                           'city'            => htmlspecialchars($admin->city),
                           'state'           => $admin->state->code ?? '',
                           'zip'             => htmlspecialchars($admin->zip),
                           'country'         => $admin->country->iso_alpha3 ?? '',
                           'streetSeparator' => '<br>',
                       ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'latitude',
            'value' => $admin->latitude
        ])

        @include('admin.components.show-row', [
            'name'  => 'longitude',
            'value' => $admin->longitude
        ])

        @include('admin.components.show-row', [
            'name'  => 'phone',
            'value' => htmlspecialchars($admin->phone)
        ])

        @include('admin.components.show-row', [
            'name'  => 'email',
            'value' => htmlspecialchars($admin->email)
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
            'name'   => 'link',
            'label'  => $admin->link,
            'href'   => $admin->link_name,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'bio',
            'value' => $admin->bio
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($admin->description)
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
