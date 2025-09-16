@extends('admin.layouts.default', [
    'title' => $recipeStep->recipe->name . ' step ' . $recipeStep->step,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Recipes',         'url' => route('admin.portfolio.recipe.index') ],
        [ 'name' => '#Recipe Name#',   'url' => route('admin.portfolio.recipe.show') ],
        [ 'name' => 'Step #' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'url' => route('admin.portfolio.recipe-step.edit', $recipeStep) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Step',  'url' => route('admin.portfolio.recipe-step.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'url' => Request::header('referer') ?? route('admin.portfolio.recipe-step.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $video->admin['username'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'recipe',
            'value' => '<a href="' . route('admin.portfolio.recipe.show',$recipeStep->recipe ) . '">' . $recipeStep->recipe['name'] . '</a>'
        ])

        @include('admin.components.show-row', [
            'name'  => 'step',
            'value' => $recipeStep->step
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $recipeStep->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'src'   => $recipeStep->image,
            'alt'   => $recipeStep->name,
            'width' => '300px',
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $recipeStep->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $recipeStep->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'src'   => $recipeStep->thumbnail,
            'alt'   => $recipeStep->name,
            'width' => '40px',
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $recipeStep->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $recipeStep->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $recipeStep->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $recipeStep->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $recipeStep->disabled
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
