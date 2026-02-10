@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? $recipeStep->recipe['name'] . ' - step ' . $recipeStep->step,
    'breadcrumbs'      => [
        [ 'name' => 'Home',                       'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',            'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',                   'href' => route('admin.personal.index') ],
        [ 'name' => 'Recipes',                    'href' => route('admin.personal.recipe.index') ],
        [ 'name' => $recipeStep->recipe['name'],  'href' => route('admin.personal.recipe.show', $recipeStep->recipe) ],
        [ 'name' => 'Step ' . $recipeStep->step , 'href' => route('admin.personal.recipe-step.show', $recipeStep->id) ],
        [ 'name' => 'Edit' ],
    ],
    'buttons'          => [
        view('admin.components.nav-button-back', ['href' => referer('admin.personal.recipe-step.index')])->render(),
    ],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="edit-container card form-container p-4">

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

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $recipeStep->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions([],
                                                                        'id',
                                                                        'username',
                                                                        true,
                                                                        false,
                                                                        [ 'username', 'asc' ]
                                                                       ),
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

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $recipeStep->image,
                'credit'  => old('image_credit') ?? $recipeStep->image_credit,
                'source'  => old('image_source') ?? $recipeStep->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $recipeStep->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'      => old('public')   ?? $recipeStep->public,
                'readonly'    => old('readonly') ?? $recipeStep->readonly,
                'root'        => old('root')     ?? $recipeStep->root,
                'disabled'    => old('disabled') ?? $recipeStep->disabled,
                'demo'        => old('demo')     ?? $recipeStep->demo,
                'sequence'    => old('sequence') ?? $recipeStep->sequence,
                'message'     => $message ?? '',
                'isRootAdmin' => isRootAdmin(),
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.personal.recipe-step.index')
            ])

        </form>

    </div>

@endsection
