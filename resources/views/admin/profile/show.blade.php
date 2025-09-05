@extends('admin.layouts.default', [
    'title' => 'My Profile',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'My Profile' ],
    ],
    'buttons' => [],
    'errors' => $errors ?? [],
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
            'name'  => 'image',
            'value' => $admin->image
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
            'name'  => 'thumbnail',
            'value' => $admin->thumbnail
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
