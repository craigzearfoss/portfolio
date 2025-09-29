@extends('admin.layouts.default', [
    'title' => 'Show Database',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Databases',       'href' => route('admin.database.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',    'url' => route('admin.database.edit', $database) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Database', 'url' => route('admin.database.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',       'url' => referer('admin.database.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $database->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $database->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'database',
            'value' => $database->database
        ])

        @include('admin.components.show-row', [
            'name'  => 'tag',
            'value' => $database->tag
        ])

        @include('admin.components.show-row', [
            'name'  => 'title',
            'value' => $database->title
        ])

        @include('admin.components.show-row', [
            'name'  => 'plural',
            'value' => $database->plural
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'guest',
            'checked' => $database->guest
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'user',
            'checked' => $database->user
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'admin',
            'checked' => $database->admin
        ])

        @include('admin.components.show-row-icon', [
            'name' => 'icon',
            'icon' => $database->icon
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $database->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $database->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $database->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $database->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $database->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($database->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($database->updated_at)
        ])

    </div>

@endsection
