@extends('admin.layouts.default', [
    'title' => $recipeIngredient->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard')],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Recipes',         'href' => route('admin.personal.recipe.index') ],
        [ 'name' => 'Ingredients',     'href' => route('admin.personal.recipe-ingredient.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',             'href' => route('admin.personal.recipe-ingredient.edit', $recipeIngredient) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Recipe Ingredient', 'href' => route('admin.personal.recipe-ingredient.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',                'href' => referer('admin.personal.recipe-ingredient.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $recipeIngredient->owner['username'] ?? ''
            ])
        @endif

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
            'value' => nl2br($recipeIngredient->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $recipeIngredient->image,
            'alt'      => $recipeIngredient->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($recipeIngredient->name, $recipeIngredient->image)
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
            'name'     => 'thumbnail',
            'src'      => $recipeIngredient->thumbnail,
            'alt'      => $recipeIngredient->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($recipeIngredient->name, $recipeIngredient->image)
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
