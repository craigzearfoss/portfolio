@php
    $buttons = [];
    if (isRootAdmin()) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',    'href' => route('admin.dictionary.database.edit', $database) ];
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Database', 'href' => route('admin.dictionary.database.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back',       'href' => referer('admin.dictionary.index') ];
@endphp
@extends('admin.layouts.default', [
    'title' => $database->name . ' (database)',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Databases',       'href' => route('admin.dictionary.database.index') ],
        [ 'name' => $database->name  ],
    ],
    'buttons' => $buttons,
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

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $database->open_source
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $database->proprietary
        ])

        @include('admin.components.show-row-checkbox', [
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
            'name'   => $database->link_name ?? 'link',
            'href'   => $database->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($database->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $database->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($database->name, $database->image)
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
            'filename' => getFileSlug($database->name . '-thumb', $database->thumbnail)
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
