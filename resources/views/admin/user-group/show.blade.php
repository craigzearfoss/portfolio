@extends('admin.layouts.default', [
    'title' => $userGroup->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Admins',          'url' => route('admin.admin.index') ],
        [ 'name' => 'Admin Groups',    'url' => route('admin.admin-group.index') ],
        [ 'name' => 'Show' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',       'url' => route('admin.admin-group.edit', $userGroup) ],
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
            'value' => $userGroup->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'team',
            'value' => $userGroup->team['name'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $userGroup->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $userGroup->description
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $userGroup->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'admin',
            'value' => $userGroup->admin['username'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($userGroup->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($userGroup->updated_at)
        ])

    </div>

@endsection
