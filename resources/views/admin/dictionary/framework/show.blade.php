@extends('admin.layouts.default', [
    'title' => $framework->name . ' language',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'url' => route('admin.dictionary.index') ],
        [ 'name' => 'Frameworks',      'url' => route('admin.dictionary.framework.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',     'url' => route('admin.dictionary.framework.edit', $framework) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Framework', 'url' => route('admin.dictionary.framework.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',        'url' => route('admin.dictionary.framework.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card">

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => $framework->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $framework->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $framework->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $framework->abbreviation
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $framework->open_source
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $framework->proprietary
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $framework->owner
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'wiki page',
            'url'    => $framework->wikipedia,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'link',
            'url'    => $framework->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $framework->link_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $framework->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'value' => $framework->image
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $framework->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $framework->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $framework->thumbnail
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $framework->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $framework->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $framework->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $framework->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $framework->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($framework->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($framework->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($framework->deleted_at)
        ])

    </div>

@endsection
