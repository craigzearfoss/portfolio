@extends('admin.layouts.default', [
    'title' => $art->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Art']
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

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $art->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $art->description
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
            'name'    => 'disabled',
            'checked' => $art->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
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
