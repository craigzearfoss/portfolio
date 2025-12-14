@php
    $buttons = [];
    if (isRootAdmin()) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',    'href' => route('admin.dictionary.language.edit', $language) ];
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Language', 'href' => route('admin.dictionary.language.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back',       'href' => referer('admin.dictionary.index') ];
@endphp
@extends('admin.layouts.default', [
    'title' => $language->name . ' (language)',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Languages',       'href' => route('admin.dictionary.language.index') ],
        [ 'name' => $language->name ],
    ],
    'buttons' => $buttons,
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $language->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => $language->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $language->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $language->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $language->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'definition',
            'value' => $language->definition
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $language->open_source
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $language->proprietary
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'compiled',
            'checked' => $language->compiled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $language->owner
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $language->wikipedia,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'label'  => $language->link_name,
            'href'   => $language->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($language->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $language->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($language->name, $language->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $language->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $language->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $language->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($language->name . '-thumb', $language->thumbnail)
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $language,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($language->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($language->updated_at)
        ])

    </div>

@endsection
