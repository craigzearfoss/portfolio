@extends('admin.layouts.default', [
    'title' => $industry->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Industries',      'url' => route('admin.career.industry.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',    'url' => route('admin.career.industry.edit', $industry) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Industry', 'url' => route('admin.career.industry.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',       'url' => route('admin.career.industry.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $industry->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $industry->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $industry->abbreviation
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'link',
            'url'    => $industry->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $industry->link_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $industry->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'value' => $industry->image
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image credit',
            'value' => $industry->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $industry->image_source
        ])

        @include('admin.components.show-row', [
            'name'  => 'thumbnail',
            'value' => $industry->thumbnail
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $industry->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $industry->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'readonly',
            'label'   => 'read-only',
            'checked' => $industry->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $industry->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $industry->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($industry->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($industry->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($industry->deleted_at)
        ])

    </div>

@endsection
