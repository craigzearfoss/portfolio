@php
    $buttons = [];
    if (canUpdate($recipeIngredient, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.personal.recipe-ingredient.edit', $recipeIngredient) ];
    }
    if (canCreate($recipeIngredient, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Recipe Ingredient', 'href' => route('admin.personal.recipe-ingredient.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.personal.recipe-ingredient.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Recipe Ingredient: ' . $recipeIngredient->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard')],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Recipes',         'href' => route('admin.personal.recipe.index') ],
        [ 'name' => 'Ingredients',     'href' => route('admin.personal.recipe-ingredient.index') ],
        [ 'name' => $recipeIngredient->name ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $recipeIngredient->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $recipeIngredient->owner->username ?? ''
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
            'value'  => htmlspecialchars($recipeIngredient->amount),
        ])

        @include('admin.components.show-row', [
            'name'  => 'unit',
            'value' => $recipeIngredient->unit->name ?? ''
        ])

        @include('admin.components.show-row', [
            'name'   => 'qualifier',
            'value'  => $recipeIngredient->qualifier,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($recipeIngredient->description ?? '')
        ])

        @include('admin.components.show-row-images', [
            'resource' => $recipeIngredient,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $recipeIngredient,
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
