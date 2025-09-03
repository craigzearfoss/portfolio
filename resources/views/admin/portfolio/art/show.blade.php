@extends('admin.layouts.default', [
    'title' => $art->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Art',             'url' => route('admin.portfolio.art.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'url' => route('admin.portfolio.art.edit', $art) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Art',   'url' => route('admin.portfolio.art.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'url' => route('admin.portfolio.art.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $art->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $art->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'professional',
            'checked' => $art->professional
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'personal',
            'checked' => $art->personal
        ])

        @include('admin.components.show-row', [
            'name'  => 'artist',
            'value' => $art->artist
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $art->year
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $art->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $art->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $art->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'value' => $art->image
        ])

        @include('admin.components.show-row', [
            'name'  => 'image_credit',
            'value' => $art->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image_source',
            'value' => $art->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $art->thumbnail
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $art->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $art->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $art->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $art->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $art->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'admin',
            'value' => $art->admin['username'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($art->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($art->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($art->deleted_at)
        ])

    </div>

@endsection
