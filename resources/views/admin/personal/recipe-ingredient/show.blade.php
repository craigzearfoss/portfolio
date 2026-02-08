@php
    $buttons = [];
    if (canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $recipeIngredient, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.personal.recipe-ingredient.edit', $recipeIngredient)])->render();
    }
    if (canCreate(\App\Enums\PermissionEntityTypes::RESOURCE, 'recipe-ingredient', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Recipe Ingredient', 'href' => route('admin.personal.recipe-ingredient.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.personal.recipe-ingredient.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Recipe Ingredient: ' . $recipeIngredient->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard')],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Recipes',         'href' => route('admin.personal.recipe.index') ],
        [ 'name' => 'Ingredients',     'href' => route('admin.personal.recipe-ingredient.index') ],
        [ 'name' => $recipeIngredient->name ],
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="card p-4">

        <div style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $recipeIngredient->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $recipeIngredient->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'recipe',
            'value' => $recipeIngredient->recipe['name'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'ingredient',
            'value' => $recipeIngredient->ingredient['name'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'   => 'amount',
            'value'  => $recipeIngredient->amount),
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
            'value' => $recipeIngredient->description
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
