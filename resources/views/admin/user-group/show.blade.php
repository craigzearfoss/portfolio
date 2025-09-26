@extends('admin.layouts.default', [
    'title' => $adminGroup->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Admins',          'url' => route('admin.admin.index') ],
        [ 'name' => 'Admin Groups',    'url' => route('admin.admin-group.index') ],
        [ 'name' => 'Show' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',       'url' => route('admin.admin-group.edit', $adminGroup) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Admin Group', 'url' => route('admin.admin-group.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',          'url' => referer('admin.admin-group.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $adminGroup->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'team',
            'value' => $adminGroup->team['name'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $adminGroup->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $adminGroup->description
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $adminGroup->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'admin',
            'value' => $adminGroup->admin['username'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($adminGroup->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($adminGroup->updated_at)
        ])

    </div>

@endsection
