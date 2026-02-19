@php
    use App\Models\Personal\Ingredient;
    use App\Models\Personal\Recipe;
    use App\Models\Personal\Unit;
    use App\Models\System\Owner;
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Recipe Ingredient: ' . $recipeIngredient->ingredient->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',                  'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',       'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',              'href' => route('admin.personal.index') ],
        [ 'name' => 'Recipes',               'href' => route('admin.personal.recipe.index') ],
        [ 'name' => 'Ingredients',           'href' => route('admin.personal.recipe-ingredient.index') ],
        [ 'name' => $recipeIngredient->name, 'href' => route('admin.personal.recipe-ingredient.show', $recipeIngredient) ],
        [ 'name' => 'Edit' ],
    ],
    'buttons'          => [
        view('admin.components.nav-button-back', ['href' => referer('admin.personal.recipe-ingredient.index')])->render(),
    ],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form
            action="{{ route('admin.personal.recipe-ingredient.update', array_merge([$recipeIngredient], request()->all())) }}"
            method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.personal.recipe-ingredient.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $recipeIngredient->id
            ])

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $recipeIngredient->owner_id,
                    'required' => true,
                    'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $recipeIngredient->owner_id
                ])
            @endif

            @include('admin.components.form-select-horizontal', [
                'name'     => 'recipe_id',
                'label'    => 'recipe',
                'value'    => old('recipe_id') ?? $recipeIngredient->recipe_id,
                'required' => true,
                'list'     => new Recipe()->listOptions([], 'id', 'name', true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'ingredient_id',
                'label'    => 'ingredient',
                'value'    => old('ingredient_id') ?? $recipeIngredient->ingredient_id,
                'required' => true,
                'list'     => new Ingredient()->listOptions([], 'id', 'name', true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'amount',
                'value'     => old('amount') ?? $recipeIngredient->amount,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'unit_id',
                'label'   => 'unit',
                'value'   => old('unit_id') ?? $recipeIngredient->unit_id,
                'list'    => new Unit()->listOptions([], 'id', 'name', false),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'qualifier',
                'value'     => old('qualifier') ?? $recipeIngredient->qualifier,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $recipeIngredient->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $recipeIngredient->image,
                'credit'  => old('image_credit') ?? $recipeIngredient->image_credit,
                'source'  => old('image_source') ?? $recipeIngredient->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $recipeIngredient->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'      => old('public')   ?? $recipeIngredient->public,
                'readonly'    => old('readonly') ?? $recipeIngredient->readonly,
                'root'        => old('root')     ?? $recipeIngredient->root,
                'disabled'    => old('disabled') ?? $recipeIngredient->disabled,
                'demo'        => old('demo')     ?? $recipeIngredient->demo,
                'sequence'    => old('sequence') ?? $recipeIngredient->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.personal.recipe-ingredient.index')
            ])

        </form>

    </div>

@endsection
