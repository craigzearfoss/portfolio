@extends('admin.layouts.default', [
    'title' => 'Admin: ' . $admin->username,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.homepage') ],
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
            'value' => $admin->name
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'current team',
            'label'  => $admin->team->name,
            'href'   => route('admin.system.admin-team.show', $admin->team->id)
        ])

        @include('admin.components.show-row', [
            'name'  => 'teams',
            'value' => implode(',', $admin->teams->pluck('name')->toArray())
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
                           'street'    => $admin->street ?? null,
                           'street2'   => $admin->street2 ?? null,
                           'city'      => $admin->city ?? null,
                           'state'     => $admin->state['code'] ?? null,
                           'zip'       => $admin->zip ?? null,
                           'country'   => $admin->country['iso_alpha3'] ?? null,
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
            'value' => $admin->description
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $admin->image,
            'alt'      => $admin->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($admin->name, $admin->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $admin->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $admin->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $admin->thumbnail,
            'alt'      => $admin->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($admin->name, $admin->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'  => 'status',
            'value' => \App\Models\System\User::statusName($admin->status)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $admin->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $admin->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $admin->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $admin->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $admin->disabled
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'demo',
            'checked' => $admin->demo
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
