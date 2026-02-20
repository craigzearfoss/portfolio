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
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'username',
                'value' => $admin->username,
                'style' => 'white-space: nowrap;',
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

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($admin->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($admin->updated_at),
                'style' => 'white-space: nowrap;',
            ])

        </div>
        <div class="show-container card floating-div">

            @include('admin.components.show-row-images', [
                'resource' => $admin,
                'download' => true,
                'external' => true,
            ])

        </div>
    </div>

@endsection
