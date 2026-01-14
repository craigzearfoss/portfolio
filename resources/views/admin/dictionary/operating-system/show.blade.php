@php
    $buttons = [];
    if (canUpdate($operatingSystem, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.dictionary.operating-system.edit', $operatingSystem) ];
    }
    if (canCreate($operatingSystem, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Resume', 'href' => route('admin.dictionary.operating-system.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.dictionary.operating-system.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => $operatingSystem->name . ' (operating system)',
    'breadcrumbs'   => [
        [ 'name' => 'Home',              'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',   'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',        'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Operating Systems', 'href' => route('admin.dictionary.operating-system.index') ],
        [ 'name' => $operatingSystem->name ],
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
            'value' => $operatingSystem->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => htmlspecialchars($operatingSystem->full_name ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($operatingSystem->name ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $operatingSystem->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => htmlspecialchars($operatingSystem->abbreviation ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'definition',
            'value' => $operatingSystem->definition ?? ''
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $operatingSystem->open_source ?? ''
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $operatingSystem->proprietary
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'compiled',
            'checked' => $operatingSystem->compiled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => htmlspecialchars($operatingSystem->owner ?? '')
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $operatingSystem->wikipedia,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => htmlspecialchars($operatingSystem->link_name ?? 'link'),
            'href'   => htmlspecialchars($operatingSystem->link ?? ''),
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $operatingSystem->description ?? ''
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $operatingSystem->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($operatingSystem->name, $operatingSystem->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $operatingSystem->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $operatingSystem->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $operatingSystem->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($operatingSystem->name . '-thumb', $operatingSystem->thumbnail)
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $operatingSystem,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($operatingSystem->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($operatingSystem->updated_at)
        ])

    </div>

@endsection
