@extends('admin.layouts.default', [
    'title' => 'Recipe Ingredient: ' . $recipeIngredient->ingredient->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',                  'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard',       'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',              'href' => route('admin.personal.index') ],
        [ 'name' => 'Recipes',               'href' => route('admin.personal.recipe.index') ],
        [ 'name' => 'Ingredients',           'href' => route('admin.personal.recipe-ingredient.index') ],
        [ 'name' => $recipeIngredient->name, 'href' => route('admin.personal.recipe-ingredient.show', $recipeIngredient->id) ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.personal.recipe-ingredient.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.personal.recipe-ingredient.update', $recipeIngredient) }}" method="POST">
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

            @if(isRootAdmin())
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $recipeIngredient->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
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
                'list'     => \App\Models\Personal\Recipe::listOptions([], 'id', 'name', true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'ingredient_id',
                'label'    => 'ingredient',
                'value'    => old('ingredient_id') ?? $recipeIngredient->ingredient_id,
                'required' => true,
                'list'     => \App\Models\Personal\Ingredient::listOptions([], 'id', 'name', true),
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
                'list'    => \App\Models\Personal\Unit::listOptions([], 'id', 'name', false),
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
                'image'   => old('image') ?? $recipeIngredient->image,
                'credit'  => old('image_credit') ?? $recipeIngredient->image_credit,
                'source'  => old('image_source') ?? $recipeIngredient->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'thumbnail',
                'value'     => old('thumbnail') ?? $recipeIngredient->thumbnail,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field" style="flex-grow: 0;">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'public',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('public') ?? $recipeIngredient->public,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'readonly',
                                'label'           => 'read-only',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('readonly') ?? $recipeIngredient->readonly,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'root',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('root') ?? $recipeIngredient->root,
                                'disabled'        => !isRootAdmin(),
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'disabled',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('disabled') ?? $recipeIngredient->disabled,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'demo',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('demo') ?? $recipeIngredient->demo,
                                'message'         => $message ?? '',
                            ])

                            <div style="display: inline-block; width: 10em;">
                                <label class="label" style="display: inline-block !important;">sequence</label>
                                <span class="control ">
                                    <input class="input"
                                           style="margin-top: -4px;"
                                           type="number"
                                           id="inputSequence"
                                           name="sequence"
                                           min="0"
                                           value="{{ old('sequence') ?? $recipeIngredient->sequence }}"
                                    >
                                </span>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.personal.recipe-ingredient.index')
            ])

        </form>

    </div>

@endsection
