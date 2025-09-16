@extends('admin.layouts.default', [
    'title' => $library->name . ' library',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'url' => route('admin.dictionary.index') ],
        [ 'name' => 'Libraries',       'url' => route('admin.dictionary.library.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',   'url' => route('admin.dictionary.library.edit', $library) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Library', 'url' => route('admin.dictionary.library.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',      'url' => Request::header('referer') ?? route('admin.dictionary.index') ],
    ],
    'errors'  => $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $library->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => $library->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $library->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $library->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $library->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'definition',
            'value' => $library->definition
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $library->open_source
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $library->proprietary
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'compiled',
            'checked' => $library->compiled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $library->owner
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'wikipedia',
            'url'    => $library->wikipedia,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $library->link,
            'label'  => $library->link_name,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $library->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'src'   => $library->image,
            'alt'   => $library->name,
            'width' => '300px',
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $library->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $library->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'src'   => $library->thumbnail,
            'alt'   => $library->name,
            'width' => '40px',
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $library->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $library->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $library->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $library->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $library->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($library->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($library->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($library->deleted_at)
        ])

    </div>

@endsection
