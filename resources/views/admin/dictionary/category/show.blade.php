@php
    $buttons = [];
    if (canUpdate($category, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.dictionary.category.edit', $category) ];
    }
    if (canCreate($category, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Resume', 'href' => route('admin.dictionary.category.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.dictionary.category.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => $category->name . ' (category)',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Categories',      'href' => route('admin.dictionary.category.index') ],
        [ 'name' => $category->name ],
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
