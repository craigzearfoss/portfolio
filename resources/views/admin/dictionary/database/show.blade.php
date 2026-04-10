@php
    use App\Enums\PermissionEntityTypes;

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
            'value' => $database->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $database->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $database->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $database->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'definition',
            'value' => $database->definition
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
            'value'  => $database->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $database->description
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $database->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => generateDownloadFilename($database)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $database->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $database->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $database->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => generateDownloadFilename($database, '-thumbnail')
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
