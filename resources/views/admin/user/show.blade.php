@extends('admin.layouts.default', [
    'title' => $user->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Users',           'href' => route('admin.user.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-key"></i>Change Password', 'url' => route('admin.user.change-password', $user->id) ],
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'url' => route('admin.user.edit', $user) ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'url' => referer('admin.user.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

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
            'value' => \App\Models\User::statusName($user->status)
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

    </div>

@endsection
