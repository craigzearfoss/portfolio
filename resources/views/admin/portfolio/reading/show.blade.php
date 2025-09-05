@extends('admin.layouts.default', [
    'title' => $reading->title,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Readings',        'url' => route('admin.portfolio.reading.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',   'url' => route('admin.portfolio.reading.edit', $reading) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Reading', 'url' => route('admin.portfolio.reading.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',      'url' => route('admin.portfolio.reading.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $reading->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $reading->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'professional',
            'checked' => $reading->professional
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'personal',
            'checked' => $reading->personal
        ])

        @include('admin.components.show-row', [
            'name'  => 'author',
            'value' => $reading->author
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'paper',
            'checked' => $reading->paper
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'audio',
            'checked' => $reading->audio
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'wishlist',
            'label'   => 'wish list',
            'checked' => $reading->wishlist
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $reading->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $reading->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $reading->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'value' => $reading->image
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image credit',
            'value' => $reading->image_credit
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image source',
            'value' => $reading->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $reading->thumbnail
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $reading->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $reading->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $reading->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $reading->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $reading->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'admin',
            'value' => $reading->admin['username'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($reading->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($reading->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($reading->deleted_at)
        ])

    </div>

@endsection
