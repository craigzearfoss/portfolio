@extends('admin.layouts.default', [
    'title' => 'My Profile',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'My Profile' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-key"></i> Change Password', 'url' => route('admin.profile.change-password') ],
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',  'url' => route('admin.profile.edit') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'username',
            'value' => $admin->username
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $admin->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'phone',
            'value' => $admin->phone
        ])

        @include('admin.components.show-row', [
            'name'  => 'email',
            'value' => $admin->email
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
            'name'  => 'created at',
            'value' => longDateTime($admin->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($admin->updated_at)
        ])

    </div>

@endsection
