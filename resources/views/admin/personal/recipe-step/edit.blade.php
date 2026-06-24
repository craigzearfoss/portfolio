@php
    use App\Models\Personal\Recipe;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $recipeStep  = $recipeStep ?? null;

    $title    = 'Edit ' . getResourcePageTitle($recipeStep);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                                        'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                             'href' => route('admin.dashboard') ]
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                                     'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Personal',                                       'href' => route('admin.personal.index') ];
    $breadcrumbs[] = [ 'name' => 'Recipes',                                        'href' => route('admin.personal.recipe.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($recipeStep->recipe, false), 'href' => route('admin.personal.recipe.show', $recipeStep->recipe) ];
    $breadcrumbs[] = [ 'name' => 'Step '. $recipeStep->step,                       'href' => route('admin.personal.recipe-step.show', $recipeStep) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.personal.recipe-step.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.personal.recipe-step.update', array_merge([$recipeStep], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.personal.recipe-step.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $recipeStep->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $recipeStep->id,
                    'hide'  => !$isRootAdmin,
                ])

                <?php /* note that you CANNOT change the owner of a recipe step */ ?>
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $recipeStep->owner_id
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'     => 'recipe_id',
                    'label'    => 'recipe',
                    'value'    => old('recipe_id') ?? $recipeStep->recipe_id,
                    'required' => true,
                    'list'     => new Recipe()->listOptions([], 'id', 'name', true),
                    'message'  => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'number',
                    'name'      => 'step',
                    'value'     => old('step') ?? $recipeStep->step,
                    'required'  => true,
                    'min'       => 1,
                    'message'   => $message ?? '',
                    'style'     => [ 'width: 4rem' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ??  $recipeStep->description,
                    'message' => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.show-row-images', [
                    'resource' => $recipeStep,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $recipeStep->is_public,
                    'is_readonly' => old('is_readonly') ?? $recipeStep->is_readonly,
                    'is_root'     => old('is_root')     ?? $recipeStep->root,
                    'is_disabled' => old('is_disabled') ?? $recipeStep->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $recipeStep->is_demo,
                    'sequence'    => old('sequence')    ?? $recipeStep->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.personal.recipe-step.index')
        ])

    </form>

@endsection
