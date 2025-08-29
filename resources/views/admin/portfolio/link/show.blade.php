@extends('admin.layouts.default', [
    'title' => $link->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Links',           'url' => route('admin.portfolio.link.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'url' => route('admin.portfolio.link.edit', $link) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Link',  'url' => route('admin.portfolio.link.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'url' => route('admin.portfolio.link.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $link->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $link->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'professional',
            'checked' => $link->professional
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'personal',
            'checked' => $link->personal
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'url',
            'url'    => $link->url,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'website',
            'value' => $link->website
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $link->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $link->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $link->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $link->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $link->admin['username'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($link->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($link->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($link->deleted_at)
        ])

    </div>

@endsection
