@extends('admin.layouts.default', [
    'title' => $language->name . ' language',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'url' => route('admin.dictionary.index') ],
        [ 'name' => 'Languages',       'url' => route('admin.dictionary.language.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',    'url' => route('admin.dictionary.language.edit', $language) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Language', 'url' => route('admin.dictionary.language.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',       'url' => Request::header('referer') ?? route('admin.dictionary.index') ],
    ],
    'errors'  => $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $language->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => $language->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $language->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $language->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $language->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'definition',
            'value' => $language->definition
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $language->open_source
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $language->proprietary
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'compiled',
            'checked' => $language->compiled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $language->owner
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'wikipedia',
            'url'    => $language->wikipedia,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $language->link,
            'label'  => $language->link_name,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $language->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'src'   => $language->image,
            'alt'   => $language->name,
            'width' => '300px',
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $language->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' =>$language->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'src'   => $language->thumbnail,
            'alt'   => $language->name,
            'width' => '40px',
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $language->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $language->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $language->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $language->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $language->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($language->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($language->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($language->deleted_at)
        ])

    </div>

@endsection
