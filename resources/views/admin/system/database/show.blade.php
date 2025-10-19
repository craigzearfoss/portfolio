@extends('admin.layouts.default', [
    'title' => 'Database: ' . $database->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('guest.homepage') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Databases',       'href' => route('admin.system.database.index') ],
        [ 'name' => $database->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',    'href' => route('admin.system.database.edit', $database) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Database', 'href' => route('admin.system.database.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',       'href' => referer('admin.system.database.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $database->id
        ])

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

        @include('admin.components.show-row-checkbox', [
            'name'    => 'global',
            'checked' => $database->global
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
