@php
    $buttons = [];
    if (canUpdate($category, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.dictionary.category.edit', $category)])->render();
    }
    if (canCreate('category', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Category', 'href' => route('admin.dictionary.category.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.dictionary.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => 'Dictionary: ' . $category->name . ' (category)',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('home') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Categories',      'href' => route('admin.dictionary.category.index') ],
        [ 'name' => $category->name ],
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $category->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => $category->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $category->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $category->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $category->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'definition',
            'value' => $category->definition
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $category->open_source
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $category->proprietary
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'compiled',
            'checked' => $category->compiled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $category->owner
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $category->wikipedia,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($category->link_name) ? $category->link_name : 'link',
            'href'   => $category->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $category->description
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $category->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($category->name, $category->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $category->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $category->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $category->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($category->name . '-thumb', $category->thumbnail)
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $category,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($category->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($category->updated_at)
        ])

    </div>

@endsection
