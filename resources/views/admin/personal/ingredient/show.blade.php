@php
    $buttons = [];
    if (canUpdate($ingredient, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.personal.ingredient.edit', $ingredient) ];
    }
    if (canCreate($ingredient, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Ingredient', 'href' => route('admin.personal.ingredient.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.personal.ingredient.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => $pageTitle ?? 'Ingredient: ' . $ingredient->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Ingredients',     'href' => route('admin.personal.ingredient.index') ],
        [ 'name' => $ingredient->name ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
])

@section('content')

    <div class="show-container card p-4">

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
            'name'   => $ingredient->link_name ?? 'link',
            'href'   => $ingredient->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $ingredient->description
        ])

        @include('admin.components.show-row-images', [
            'resource' => $ingredient,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $ingredient,
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
