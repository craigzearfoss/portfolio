@extends('admin.layouts.default', [
    'title' => 'Resource',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Resources',       'url' => route('admin.resource.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',    'url' => route('admin.resource.edit', $resource) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Resource', 'url' => route('admin.resource.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',       'url' => referer('admin.resource.index') ],
    ],
    'errors'  => $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $resource->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'database',
            'value' => $resource->database->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'table',
            'value' => $resource->table
        ])

        @include('admin.components.show-row', [
            'name'  => 'title',
            'value' => $resource->title
        ])

        @include('admin.components.show-row', [
            'name'  => 'plural',
            'value' => $resource->plural
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'guest',
            'checked' => $resource->guest
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'user',
            'checked' => $resource->user
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'admin',
            'checked' => $resource->admin
        ])

        @include('admin.components.show-row-icon', [
            'name' => 'icon',
            'icon' => $resource->icon
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $resource->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $resource->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $resource->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $resource->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $resource->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($resource->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($resource->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($resource->deleted_at)
        ])

    </div>

@endsection
