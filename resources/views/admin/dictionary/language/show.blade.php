@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $language    = $language ?? null;

    $title    = 'Dictionary: ' . $language->name . ' (language)';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Languages',       'href' => route('admin.dictionary.language.index') ],
        [ 'name' => $language->name ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($language, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.dictionary.language.edit', $language)])->render();
    }
    if (canCreate($language, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Language', 'href' => route('admin.dictionary.language.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.dictionary.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $language->id,
            'hide'  => !$isRootAdmin,
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $language->owner->username,
            'hide'  => !$isRootAdmin,
        ])

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => htmlspecialchars($language->full_name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($language->name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $language->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => htmlspecialchars($language->abbreviation)
        ])

        @include('admin.components.show-row', [
            'name'  => 'definition',
            'value' => htmlspecialchars($language->definition)
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'open source',
            'checked' => $language->open_source
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'proprietary',
            'checked' => $language->proprietary
        ])

        @include('admin.components.show-row-checkmark', [
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
            'href'   => $language->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'   => 'link name',
            'label'  => 'link_name',
            'value'  => htmlspecialchars($language->link_name),
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $language->description
        ])

        @include('admin.components.show-row-images', [
            'resource' => $language,
            'upload'   => true,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-visibility', [
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
