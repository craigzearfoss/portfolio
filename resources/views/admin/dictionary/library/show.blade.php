@php
    $buttons = [];
    if (canUpdate($library, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.dictionary.library.edit', $library) ];
    }
    if (canCreate($library, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Resume', 'href' => route('admin.dictionary.library.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.dictionary.library.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => $library->name . ' (library)',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Libraries',       'href' => route('admin.dictionary.library.index') ],
        [ 'name' => $library->name ],
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
            'value' => $library->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => htmlspecialchars($library->full_name ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($library->name ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $library->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => htmlspecialchars($library->abbreviation ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'definition',
            'value' => $library->definition ?? ''
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $library->open_source
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $library->proprietary
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'compiled',
            'checked' => $library->compiled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => htmlspecialchars($library->owner ?? ''_
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'    => $library->wikipedia,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => htmlspecialchars($library->link_name ?? 'link'),
            'href'   => htmlspecialchars($library->link ?? ''),
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $library->description ?? ''
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $library->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($library->name, $library->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $library->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $library->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $library->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($library->name . '-thumb', $library->thumbnail)
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $library,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($library->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($library->updated_at)
        ])

    </div>

@endsection
