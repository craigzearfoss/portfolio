@extends('admin.layouts.default', [
    'title' => $recipeStep->recipe['name'] . ' - step ' . $recipeStep->step,
    'breadcrumbs' => [
        [ 'name' => 'Home',                      'href' => route('guest.homepage') ],
        [ 'name' => 'Admin Dashboard',           'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',                  'href' => route('admin.personal.index') ],
        [ 'name' => 'Recipes',                   'href' => route('admin.personal.recipe.index') ],
        [ 'name' => $recipeStep->recipe['name'], 'href' => route('admin.personal.recipe.show', $recipeStep->recipe) ],
        [ 'name' => 'Edit Step ' . $recipeStep->step ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.personal.recipe-step.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card form-container p-4">

        <form action="{{ route('admin.personal.recipe-step.update', $recipeStep) }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.personal.recipe-step.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $recipeStep->id
            ])

            @if(isRootAdmin())
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $recipeStep->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $recipeStep->owner_id
                ])
            @endif

            @include('admin.components.form-select-horizontal', [
                'name'     => 'recipe_id',
                'label'    => 'recipe',
                'value'    => old('recipe_id') ?? $recipeStep->recipe_id,
                'required' => true,
                'list'     => \App\Models\Personal\Recipe::listOptions([], 'id', 'name', true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'number',
                'name'      => 'step',
                'value'     => old('step') ?? $recipeStep->step,
                'required'  => true,
                'min'       => 1,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ??  $recipeStep->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'image',
                'value'   => old('image') ??  $recipeStep->image,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'image_credit',
                'label'     => 'image credit',
                'value'     => old('image_credit') ?? $recipeStep->image_credit,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'image_source',
                'label'     => 'image source',
                'value'     => old('image_source') ?? $recipeStep->image_source,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'thumbnail',
                'value'   => old('thumbnail') ??  $recipeStep->thumbnail,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'sequence',
                'value'       => old('seq') ??  $recipeStep->sequence,
                'min'         => 0,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'public',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('public') ?? $recipeStep->public,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'readonly',
                'label'           => 'read-only',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('readonly') ?? $recipeStep->readonly,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'root',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('root') ?? $recipeStep->root,
                'disabled'        => !Auth::guard('admin')->user()->root,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'disabled',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('disabled') ?? $recipeStep->disabled,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.personal.recipe-step.index')
            ])

        </form>

    </div>

@endsection
