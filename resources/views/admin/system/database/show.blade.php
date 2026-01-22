@php
    $buttons = [];
    if (canUpdate($database, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.system.database.edit', $database)])->render();
    }
    if (canCreate('database', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Database', 'href' => route('admin.system.database.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.system.database.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Database: ' . $database->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('home') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.index') ],
        [ 'name' => 'Databases',       'href' => route('admin.system.database.index') ],
        [ 'name' => $database->name ],
    ],
    'buttons'          => $buttons,
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
            'name'  => 'id',
            'value' => $database->id
        ])

        @if($admin->root)
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
