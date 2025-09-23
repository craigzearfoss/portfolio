@extends('admin.layouts.default', [
    'title' => $database->name . ' database',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'url' => route('admin.dictionary.index') ],
        [ 'name' => 'Databases',       'url' => route('admin.dictionary.database.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',    'url' => route('admin.dictionary.database.edit', $database) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Database', 'url' => route('admin.dictionary.database.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',       'url' => referer('admin.dictionary.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

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
            'url'    => $database->wikipedia,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $database->link,
            'label'  => $database->link_name,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($database->description)
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'src'   => $database->image,
            'alt'   => $database->name,
            'width' => '300px',
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
            'name'  => 'thumbnail',
            'src'   => $database->thumbnail,
            'alt'   => $database->name,
            'width' => '40px',
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
