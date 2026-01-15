@php
    $buttons = [];
    if (canDelete($database, loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.system.database.edit', $database) ];
    }
    if (canCreate($database, loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Database', 'href' => route('admin.system.database.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.system.database.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Database: ' . $database->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.index') ],
        [ 'name' => 'Databases',       'href' => route('admin.system.database.index') ],
        [ 'name' => $database->name ],
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
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
                'value' => $database->owner->username
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

        @include('admin.components.show-row-checkbox', [
            'name'    => 'menu',
            'checked' => $database->menu
        ])

        @include('admin.components.show-row', [
            'name'  => 'menu level',
            'value' => $database->menu_level
        ])

        @include('admin.components.show-row-icon', [
            'name' => 'icon',
            'icon' => $database->icon
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $database,
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
