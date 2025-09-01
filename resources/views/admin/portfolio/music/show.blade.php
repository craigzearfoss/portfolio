@extends('admin.layouts.default', [
    'title' => $music->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Music',           'url' => route('admin.portfolio.music.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'url' => route('admin.portfolio.music.edit', $music) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Music', 'url' => route('admin.portfolio.music.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'url' => route('admin.portfolio.music.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $music->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $music->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'professional',
            'checked' => $music->professional
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'personal',
            'checked' => $music->personal
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $music->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $music->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'value' => $music->image
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $music->thumbnail
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $music->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $music->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $music->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $music->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $music->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'admin',
            'value' => $music->admin['username'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($music->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($music->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($music->deleted_at)
        ])






        @include('admin.components.show-row', [
            'name'  => 'artist',
            'value' => $music->artist
        ])

        @include('admin.components.show-row', [
            'name'  => 'label',
            'value' => $music->label
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $music->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'release_date',
            'value' => longDate($music->release_date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'catalog number',
            'value' => $music->catalog_number
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $music->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $music->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'value' => $music->image
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $music->thumbnail
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $music->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $music->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $music->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $music->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $music->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($music->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($music->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($music->deleted_at)
        ])

    </div>

@endsection
