@extends('admin.layouts.default', [
    'title' => $ingredient->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Ingredients',     'url' => route('admin.portfolio.ingredient.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'url' => route('admin.portfolio.ingredient.edit', $ingredient) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Ingredient', 'url' => route('admin.portfolio.ingredient.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'url' => route('admin.portfolio.ingredient.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $ingredient->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $ingredient->slug
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $ingredient->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $ingredient->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'value' => $ingredient->image
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $ingredient->thumbnail
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $ingredient->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $ingredient->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $ingredient->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $ingredient->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $ingredient->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($ingredient->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($ingredient->updated_at)
        ])

    </div>

@endsection
