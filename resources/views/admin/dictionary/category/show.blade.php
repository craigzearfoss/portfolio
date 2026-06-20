@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $category    = $category ?? null;

    $title    = 'Dictionary: ' . $category->name . ' (category)';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Categories',      'href' => route('admin.dictionary.category.index') ],
        [ 'name' => $category->name ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($category, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.dictionary.category.edit', $category)])->render();
    }
    if (canCreate($category, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Category', 'href' => route('admin.dictionary.category.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.dictionary.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $category->id,
            'hide'  => !$isRootAdmin,
        ])

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => htmlspecialchars($category->full_name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($category->name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $category->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => htmlspecialchars($category->abbreviation)
        ])

        @include('admin.components.show-row', [
            'name'  => 'definition',
            'value' => htmlspecialchars($category->definition)
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'open source',
            'checked' => $category->open_source
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'proprietary',
            'checked' => $category->proprietary
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'compiled',
            'checked' => $category->compiled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $category->owner
        ])

        @include('admin.components.show-row', [
            'name'  => 'wikipedia',
            'value' => $category->wikipedia
                       . (!empty($category->wikipedia)
                            ? view('admin.components.link-icon', [
                                  'title'  => 'open link in new window',
                                  'href'   => $category->wikipedia,
                                  'icon'   => 'fa-external-link',
                                  'border' => false,
                                  'target' => '_blank',
                                  'style'  => [ 'margin-top: -4px' ]
                              ])
                           : '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'link',
            'value' => $category->link
                       . (!empty($category->link)
                            ? view('admin.components.link-icon', [
                                  'title'  => 'open link in new window',
                                  'href'   => $category->link,
                                  'icon'   => 'fa-external-link',
                                  'border' => false,
                                  'target' => '_blank',
                                  'style'  => [ 'margin-top: -4px' ]
                              ])
                           : '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $category->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($category->description)
        ])

        @include('admin.components.show-row-images', [
            'resource' => $category,
            'upload'   => true,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-visibility', [
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
