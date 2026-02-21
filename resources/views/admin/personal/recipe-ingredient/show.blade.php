@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Recipe Ingredient: ' . $recipeIngredient->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard')],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Recipes',         'href' => route('admin.personal.recipe.index') ],
        [ 'name' => 'Ingredients',     'href' => route('admin.personal.recipe-ingredient.index') ],
        [ 'name' => $recipeIngredient->name ],
    ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $recipeIngredient, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.personal.recipe-ingredient.edit', $recipeIngredient)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'recipe-ingredient', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Recipe Ingredient', 'href' => route('admin.personal.recipe-ingredient.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.personal.recipe-ingredient.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
])

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
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
                'value'  => $recipeIngredient->amount,
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

            @include('admin.components.show-row-visibility', [
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
    </div>

@endsection
