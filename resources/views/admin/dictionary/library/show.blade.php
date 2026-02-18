@php
    use App\Enums\PermissionEntityTypes;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Libraries',       'href' => route('admin.dictionary.library.index') ],
        [ 'name' => $language->name ]
    ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $library, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.dictionary.library.edit', $library)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'library', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Library', 'href' => route('admin.dictionary.library.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.dictionary.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => 'Dictionary: ' . $library->name . ' (library)',
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $library->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => $library->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $library->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $library->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $library->abbreviation
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
            'value' => $library->owner
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'    => $library->wikipedia,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($library->link_name) ? $library->link_name : 'link',
            'href'   => $library->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $library->description
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
