@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $framework   = $framework ?? null;

    $title    = 'Dictionary: ' . $framework->name . ' (framework)';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Frameworks',       'href' => route('admin.dictionary.framework.index') ],
        [ 'name' => $framework->name ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($framework, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.dictionary.framework.edit', $framework)])->render();
    }
    if (canCreate($framework, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Framework', 'href' => route('admin.dictionary.framework.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.dictionary.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $framework->id,
            'hide'  => !$isRootAdmin,
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $framework->owner->username,
            'hide'  => !$isRootAdmin,
        ])

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => htmlspecialchars($framework->full_name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($framework->name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $framework->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => htmlspecialchars($framework->abbreviation)
        ])

        @include('admin.components.show-row', [
            'name'  => 'definition',
            'value' => htmlspecialchars($framework->definition)
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'open source',
            'checked' => $framework->open_source
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'proprietary',
            'checked' => $framework->proprietary
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'compiled',
            'checked' => $framework->compiled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $framework->owner
        ])

        @include('admin.components.show-row-link', [
            'link_name' => 'wikipedia',
            'name'      => $framework->wikipedia,
            'href'      => $framework->wikipedia,
            'target'    => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'link_name' => 'link',
            'name'      => $framework->link,
            'href'      => $framework->link,
            'target'    => '_blank',
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $framework->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($framework->description)
        ])

        @include('admin.components.show-row-images', [
            'resource' => $framework,
            'upload'   => true,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-visibility', [
            'resource' => $framework,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($framework->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($framework->updated_at)
        ])

    </div>

@endsection
