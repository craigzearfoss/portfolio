@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'My Profile',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.index') ],
        [ 'name' => 'My Profile' ],
    ],
    'buttons'          => [
        view('admin.components.nav-button', ['name' => 'Change Password', 'icon'=>'fa-key', 'href' => route('admin.profile.change-password')])->render(),
        view('admin.components.nav-button-edit', ['href' => route('admin.profile.edit')])->render()
    ],
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
            'alt'      => 'image',
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
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($admin->name . '-thumb', $admin->thumbnail)
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
