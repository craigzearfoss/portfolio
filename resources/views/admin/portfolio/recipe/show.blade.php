@extends('admin.layouts.default', [
    'title' => $recipe->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Recipes',         'url' => route('admin.portfolio.recipe.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'url' => route('admin.portfolio.recipe.edit', $recipe) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Recipe', 'url' => route('admin.portfolio.recipe.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'url' => route('admin.portfolio.recipe.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $recipe->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $recipe->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'professional',
            'checked' => $recipe->professional
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'personal',
            'checked' => $recipe->personal
        ])

        @include('admin.components.show-row', [
            'name'  => 'source',
            'value' => $recipe->source
        ])

        @include('admin.components.show-row', [
            'name'  => 'author',
            'value' => $recipe->author
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $recipe->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $recipe->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $recipe->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'value' => $recipe->image
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $recipe->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $recipe->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $recipe->thumbnail
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $recipe->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $recipe->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $recipe->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $recipe->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $recipe->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'admin',
            'value' => $recipe->admin['username'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($recipe->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($recipe->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($recipe->deleted_at)
        ])





        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $recipe->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $recipe->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'value' => $recipe->image
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $recipe->thumbnail
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $recipe->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $recipe->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $recipe->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $recipe->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $recipe->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($recipe->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($recipe->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($recipe->deleted_at)
        ])

    </div>

@endsection
