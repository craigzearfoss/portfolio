@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $recipeStep  = $recipeStep ?? null;

    $title    = getResourcePageTitle($recipeStep);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                                        'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                             'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                                     'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Personal',                                       'href' => route('admin.personal.index') ];
    $breadcrumbs[] = [ 'name' => 'Recipes',                                        'href' => route('admin.personal.recipe.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($recipeStep->recipe, false), 'href' => route('admin.personal.recipe.show', $recipeStep->recipe) ];
    $breadcrumbs[] = [ 'name' => 'Step '. $recipeStep->step ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($recipeStep, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.personal.recipe-step.edit', $recipeStep) ])->render();
    }
    if (canCreate($recipeStep, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Recipe Step',
                                                                  'href' => route('admin.personal.recipe-step.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.personal.recipe-step.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $recipeStep->id,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $recipeStep->owner->username,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'recipe',
                'value' => view('admin.components.link', [
                    'name' => $recipeStep->recipe['name'] ?? '',
                    'href' => route('admin.personal.recipe.show', $recipeStep->recipe['id'])
                ])
            ])

            @include('admin.components.show-row', [
                'name'  => 'step',
                'value' => $recipeStep->step
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $recipeStep->description
            ])

            @include('admin.components.show-row-images', [
                'resource' => $recipeStep,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $recipeStep,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($recipeStep->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($recipeStep->updated_at)
            ])

        </div>
    </div>

@endsection
