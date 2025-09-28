@extends('admin.layouts.default', [
    'title' => $ingredient->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Ingredients',     'href' => route('admin.personal.ingredient.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',      'url' => route('admin.personal.ingredient.edit', $ingredient) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Ingredient', 'url' => route('admin.personal.ingredient.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',         'url' => referer('admin.personal.ingredient.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $ingredient->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'full_name',
            'value' => $ingredient->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $ingredient->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $ingredient->slug
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'label'  => $ingredient->link_name,
            'url'    => $ingredient->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($ingredient->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $ingredient->image,
            'alt'      => $ingredient->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($ingredient->name, $ingredient->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $ingredient->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $ingredient->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $ingredient->thumbnail,
            'alt'      => $ingredient->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($ingredient->name, $ingredient->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $ingredient->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $ingredient->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $ingredient->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $ingredient->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $ingredient->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($ingredient->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($ingredient->updated_at)
        ])

    </div>

@endsection
