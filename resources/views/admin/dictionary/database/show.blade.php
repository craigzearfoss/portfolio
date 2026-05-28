@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $database    = $database ?? null;

    $title    = 'Dictionary: ' . $database->name . ' (database)';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Databases',       'href' => route('admin.dictionary.database.index') ],
        [ 'name' => $database->name ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($database, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.dictionary.database.edit', $database)])->render();
    }
    if (canCreate($database, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Database', 'href' => route('admin.dictionary.database.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.dictionary.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $database->id,
            'hide'  => !$isRootAdmin,
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $database->owner->username,
            'hide'  => !$isRootAdmin,
        ])

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => htmlspecialchars($database->full_name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($database->name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $database->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => htmlspecialchars($database->abbreviation)
        ])

        @include('admin.components.show-row', [
            'name'  => 'definition',
            'value' => htmlspecialchars($database->definition)
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'open source',
            'checked' => $database->open_source
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'proprietary',
            'checked' => $database->proprietary
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'compiled',
            'checked' => $database->compiled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $database->owner
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $database->wikipedia,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $database->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'   => 'link name',
            'label'  => 'link_name',
            'value'  => htmlspecialchars($database->link_name),
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $database->description
        ])

        @include('admin.components.show-row-images', [
            'resource' => $database,
            'upload'   => true,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-visibility', [
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
