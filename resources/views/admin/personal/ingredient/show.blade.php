@extends('admin.layouts.default', [
    'title' => 'Ingredient: ' . $ingredient->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Ingredients',     'href' => route('admin.personal.ingredient.index') ],
        [ 'name' => $ingredient->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',      'href' => route('admin.personal.ingredient.edit', $ingredient) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Ingredient', 'href' => route('admin.personal.ingredient.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',         'href' => referer('admin.personal.ingredient.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $ingredient->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'full_name',
            'value' => htmlspecialchars($ingredient->full_name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($ingredient->name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $ingredient->slug
        ])

        @if(!empty($ingredient->link))
            @include('admin.components.show-row-link', [
                'name'   => $ingredient->link_name,
                'href'   => $ingredient->link,
                'target' => '_blank'
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($ingredient->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $ingredient->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug(htmlspecialchars($ingredient->name), $ingredient->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => htmlspecialchars($ingredient->image_credit)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => htmlspecialchars($ingredient->image_source)
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $ingredient->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug(htmlspecialchars($ingredient->name) . '-thumb', $ingredient->thumbnail)
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
