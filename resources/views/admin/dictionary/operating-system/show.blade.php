@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin           = $admin ?? null;
    $owner           = $owner ?? null;
    $isRootAdmin     = $isRootAdmin ?? false;
    $operatingSystem = $operatingSystem ?? null;

    $title    = 'Dictionary: ' . $operatingSystem->name . ' (operating system)';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',              'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',   'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',        'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Operating Systems', 'href' => route('admin.dictionary.operating-system.index') ],
        [ 'name' => $operatingSystem->name ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($operatingSystem, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.dictionary.operating-system.edit', $operatingSystem)])->render();
    }
    if (canCreate($operatingSystem, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Operating-System', 'href' => route('admin.dictionary.operating-system.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.dictionary.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $operatingSystem->id,
            'hide'  => !$isRootAdmin,
        ])

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => htmlspecialchars($operatingSystem->full_name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($operatingSystem->name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $operatingSystem->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => htmlspecialchars($operatingSystem->abbreviation)
        ])

        @include('admin.components.show-row', [
            'name'  => 'definition',
            'value' => htmlspecialchars($operatingSystem->definition)
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'open source',
            'checked' => $operatingSystem->open_source
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'proprietary',
            'checked' => $operatingSystem->proprietary
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'compiled',
            'checked' => $operatingSystem->compiled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $operatingSystem->owner
        ])

        @include('admin.components.show-row', [
            'name'  => 'wikipedia',
            'value' => $operatingSystem->wikipedia
                       . (!empty($operatingSystem->wikipedia)
                            ? view('admin.components.link-icon', [
                                  'title'  => 'open link in new window',
                                  'href'   => $operatingSystem->wikipedia,
                                  'icon'   => 'fa-external-link',
                                  'border' => false,
                                  'target' => '_blank',
                                  'style'  => [ 'margin-top: -4px' ]
                              ])
                           : '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'link',
            'value' => $operatingSystem->link
                       . (!empty($operatingSystem->link)
                            ? view('admin.components.link-icon', [
                                  'title'  => 'open link in new window',
                                  'href'   => $operatingSystem->link,
                                  'icon'   => 'fa-external-link',
                                  'border' => false,
                                  'target' => '_blank',
                                  'style'  => [ 'margin-top: -4px' ]
                              ])
                           : '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $operatingSystem->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($operatingSystem->description)
        ])

        @include('admin.components.show-row-images', [
            'resource' => $operatingSystem,
            'upload'   => true,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-visibility', [
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
