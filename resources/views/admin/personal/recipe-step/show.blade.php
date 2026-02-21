@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? $recipeStep->recipe['name'] . ' - step ' . $recipeStep->step;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                      'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',           'href' => route('admin.dashboard')],
        [ 'name' => 'Personal',                  'href' => route('admin.personal.index') ],
        [ 'name' => 'Recipes',                   'href' => route('admin.personal.recipe.index') ],
        [ 'name' => $recipeStep->recipe['name'], 'href' => route('admin.personal.recipe.show', $recipeStep->recipe) ],
        [ 'name' => 'Step ' . $recipeStep->step ],
    ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $recipeStep, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.personal.recipe-step.edit', $recipeStep)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'recipe-step', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Recipe Step', 'href' => route('admin.personal.recipe-step.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.personal.recipe-step.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
                @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
            </div>

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $recipeStep->id
            ])

            @if($admin->root)
                @include('admin.components.show-row', [
                    'name'  => 'owner',
                    'value' => $recipeStep->owner->username
                ])
            @endif

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $recipeStep->id
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
