@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',              'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',   'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',        'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Operating Systems', 'href' => route('admin.dictionary.operating-system.index') ],
        [ 'name' => $operatingSystem->name ]
    ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $operatingSystem, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.dictionary.operating-system.edit', $operatingSystem)])->render();
    }
    if (canCreate(\App\Enums\PermissionEntityTypes::RESOURCE, 'operating-system', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Operating-System', 'href' => route('admin.dictionary.operating-system.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.dictionary.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => 'Dictionary: ' . $operatingSystem->name . ' (operating system)',
    'breadcrumbs'      => $breadcrumbs,
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

        <div style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $operatingSystem->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => $operatingSystem->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $operatingSystem->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $operatingSystem->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $operatingSystem->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'definition',
            'value' => $operatingSystem->definition
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $operatingSystem->open_source
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
            'value' => $operatingSystem->owner
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $operatingSystem->wikipedia,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($operatingSystem->link_name) ? $operatingSystem->link_name : 'link',
            'href'   => $operatingSystem->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $operatingSystem->description
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
