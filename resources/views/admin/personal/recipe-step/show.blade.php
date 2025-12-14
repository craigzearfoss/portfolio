@php
    $buttons = [];
    if (canUpdate($recipeStep)) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.personal.recipe-step.edit', $recipeStep) ];
    }
    if (canCreate($recipeStep)) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Recipe Step', 'href' => route('admin.personal.recipe-step.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.personal.recipe-step.index') ];
@endphp
@extends('admin.layouts.default', [
    'title' => $recipeStep->recipe['name'] . ' - step ' . $recipeStep->step,
    'breadcrumbs' => [
        [ 'name' => 'Home',                      'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard',           'href' => route('admin.dashboard')],
        [ 'name' => 'Personal',                  'href' => route('admin.personal.index') ],
        [ 'name' => 'Recipes',                   'href' => route('admin.personal.recipe.index') ],
        [ 'name' => $recipeStep->recipe['name'], 'href' => route('admin.personal.recipe.show', $recipeStep->recipe) ],
        [ 'name' => 'Step ' . $recipeStep->step ],
    ],
    'buttons' => $buttons,
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $recipeStep->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $recipeStep->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $recipeStep->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'recipe',
            'value' => view('admin.components.link', [
                'name' => $recipeStep->recipe['name'],
                'href' => route('admin.personal.recipe.show', $recipeStep->recipe['id'])
            ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'step',
            'value' => $recipeStep->step
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($recipeStep->description ?? '')
        ])

        @include('admin.components.show-row-images', [
            'resource' => $recipeStep,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
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

@endsection
