@extends('admin.layouts.default', [
    'title' => 'User: ' . $user->username,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('guest.homepage') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Users',           'href' => route('admin.system.user.index') ],
        [ 'name' => $user->username ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-key"></i>Change Password', 'href' => route('admin.system.user.change-password', $user->id) ],
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.system.user.edit', $user) ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.system.user.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
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
            'value' => $user->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'title',
            'value' => $user->title
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                           'street'    => $user->street ?? null,
                           'street2'   => $user->street2 ?? null,
                           'city'      => $user->city ?? null,
                           'state'     => $user->state['code'] ?? null,
                           'zip'       => $user->zip ?? null,
                           'country'   => $user->country['iso_alpha3'] ?? null,
                       ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'latitude',
            'value' => $user->latitude
        ])

        @include('admin.components.show-row', [
            'name'  => 'longitude',
            'value' => $user->longitude
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

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'label'  => $user->link,
            'href'   => $user->link_name,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $user->description
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $user->image,
            'alt'      => $user->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($user->name, $user->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $user->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $user->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $user->thumbnail,
            'alt'      => $user->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($user->name, $user->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'  => 'status',
            'value' => \App\Models\System\User::statusName($user->status)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $user->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $user->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $user->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $user->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $user->disabled
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
