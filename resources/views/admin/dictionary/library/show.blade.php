@php
    use App\Enums\PermissionEntityTypes;

    $title    = 'Dictionary: ' . $library->name . ' (library)';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Libraries',       'href' => route('admin.dictionary.library.index') ],
        [ 'name' => $language->name ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($library, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.dictionary.library.edit', $library)])->render();
    }
    if (canCreate($library, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Library', 'href' => route('admin.dictionary.library.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.dictionary.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $library->id,
            'hide'  => !$isRootAdmin,
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $library->owner->username,
            'hide'  => !$isRootAdmin,
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

        @include('admin.components.show-row-checkmark', [
            'name'    => 'open source',
            'checked' => $library->open_source
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'proprietary',
            'checked' => $library->proprietary
        ])

        @include('admin.components.show-row-checkmark', [
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
            'name'   => 'link',
            'href'   => $library->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'   => 'link name',
            'label'  => 'link_name',
            'value'  => $library->link_name,
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
            'filename' => generateDownloadFilename($library)
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
            'filename' => generateDownloadFilename($library, '-thumbnail')
        ])

        @include('admin.components.show-row-visibility', [
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
