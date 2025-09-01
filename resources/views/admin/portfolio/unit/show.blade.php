@extends('admin.layouts.default', [
    'title' => $unit->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Units',           'url' => route('admin.portfolio.unit.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',   'url' => route('admin.portfolio.unit.edit', $unit) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Unit', 'url' => route('admin.portfolio.unit.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',      'url' => route('admin.portfolio.unit.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $unit->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $unit->slug
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $unit->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $unit->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'value' => $unit->image
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $unit->thumbnail
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $unit->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $unit->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $unit->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $unit->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $unit->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($unit->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($unit->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($unit->deleted_at)
        ])

    </div>

@endsection
