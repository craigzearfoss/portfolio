@extends('admin.layouts.default', [
    'title' => $recipeIngredient->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Recipes',         'url' => route('admin.portfolio.recipe.index') ],
        [ 'name' => 'Ingredients',     'url' => route('admin.portfolio.recipe-ingredient.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',             'url' => route('admin.portfolio.recipe-ingredient.edit', $recipeIngredient) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Recipe Ingredient', 'url' => route('admin.portfolio.recipe-ingredient.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',                'url' => route('admin.portfolio.recipe-ingredient.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $recipeIngredient->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $recipeIngredient->slug
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $academy->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $recipeIngredient->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'value' => $recipeIngredient->image
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $recipeIngredient->thumbnail
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $recipeIngredient->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $recipeIngredient->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $recipeIngredient->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $recipeIngredient->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $recipeIngredient->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($recipeIngredient->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($recipeIngredient->updated_at)
        ])

    </div>

@endsection
