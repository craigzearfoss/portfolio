@extends('admin.layouts.default', [
    'title' => $admin->username,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Admins']
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'url' => route('admin.admin.edit', $admin) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Admin', 'url' => route('admin.admin.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'url' => route('admin.admin.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card">

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $admin->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'user name',
            'value' => $admin->username
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

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $admin->thumbnail
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $admin->root
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

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($admin->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($admin->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($admin->deleted_at)
        ])

    </div>

@endsection
