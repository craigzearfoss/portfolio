@extends('admin.layouts.default', [
    'title' => $operatingSystem->name . ' operating system',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard',   'url' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',        'url' => route('admin.dictionary.index') ],
        [ 'name' => 'Operating Systems', 'url' => route('admin.dictionary.operating-system.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',             'url' => route('admin.dictionary.operating-system.edit', $operatingSystem) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Operating Systems', 'url' => route('admin.dictionary.operating-system.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',                'url' => route('admin.dictionary.operating-system.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => $operatingSystem->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $operatingSystem->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $operatingSystem->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $operatingSystem->abbreviation
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $operatingSystem->open_source
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $operatingSystem->proprietary
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $operatingSystem->owner
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'wiki page',
            'url'    => $operatingSystem->wikipedia,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'link',
            'url'    => $operatingSystem->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $operatingSystem->link_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $operatingSystem->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'value' => $operatingSystem->image
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $operatingSystem->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $operatingSystem->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $operatingSystem->thumbnail
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $operatingSystem->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $operatingSystem->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $operatingSystem->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $operatingSystem->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $operatingSystem->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($operatingSystem->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($operatingSystem->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($operatingSystem->deleted_at)
        ])

    </div>

@endsection
