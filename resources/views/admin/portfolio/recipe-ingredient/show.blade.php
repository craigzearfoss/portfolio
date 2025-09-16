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
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',                'url' => Request::header('referer') ?? route('admin.portfolio.recipe-ingredient.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'recipe',
            'value' => $recipeIngredient->recipe['name']
        ])

        @include('admin.components.show-row', [
            'name'  => 'ingredient',
            'value' => $recipeIngredient->ingredient['name']
        ])

        @include('admin.components.show-row', [
            'name'   => 'amount',
            'value'  => $recipeIngredient->amount,
        ])

        @include('admin.components.show-row', [
            'name'  => 'unit',
            'value' => $recipeIngredient->unit['name'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'   => 'qualifier',
            'value'  => $recipeIngredient->qualifier,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $recipeIngredient->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'src'   => $recipeIngredient->image,
            'alt'   => $recipeIngredient->name,
            'width' => '300px',
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $recipeIngredient->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $recipeIngredient->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'src'   => $recipeIngredient->thumbnail,
            'alt'   => $recipeIngredient->name,
            'width' => '40px',
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
