@php
    use App\Models\Personal\Ingredient;
    use App\Models\Personal\Recipe;
    use App\Models\Personal\Unit;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin            = $admin ?? null;
    $owner            = $owner ?? null;
    $isRootAdmin      = $isRootAdmin ?? false;
    $recipeIngredient = $recipeIngredient ?? null;

    $title    = 'Edit ' . getResourcePageTitle($recipeIngredient);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                                              'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                                   'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                                           'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Personal',                                             'href' => route('admin.personal.index') ];
    $breadcrumbs[] = [ 'name' => 'Recipes',                                              'href' => route('admin.personal.recipe.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($recipeIngredient->recipe, false), 'href' => route('admin.personal.recipe.show', $recipeIngredient->recipe) ];
    $breadcrumbs[] = [ 'name' => $recipeIngredient->ingredient['name'],                  'href' => route('admin.personal.recipe-ingredient.show', $recipeIngredient) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.personal.recipe-ingredient.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form
        action="{{ route('admin.personal.recipe-ingredient.update', array_merge([$recipeIngredient], request()->all())) }}"
        class="admin-form"
        method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.personal.recipe-ingredient.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $recipeIngredient->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $recipeIngredient->id,
                    'hide'  => !$isRootAdmin,
                ])

                <?php /* note that you CANNOT change the owner of a recipe ingredient */ ?>
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $recipeIngredient->owner_id
                ])

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

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $recipeIngredient->description,
                    'message' => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.show-row-images', [
                    'resource' => $recipeIngredient,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $recipeIngredient->is_public,
                    'is_readonly' => old('is_readonly') ?? $recipeIngredient->is_readonly,
                    'is_root'     => old('is_root')     ?? $recipeIngredient->root,
                    'is_disabled' => old('is_disabled') ?? $recipeIngredient->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $recipeIngredient->is_demo,
                    'sequence'    => old('sequence')    ?? $recipeIngredient->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.personal.recipe-ingredient.index')
        ])

    </form>

@endsection
