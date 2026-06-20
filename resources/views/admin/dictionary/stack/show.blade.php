@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $stack       = $stack ?? null;

    $title    = 'Dictionary: ' . $stack->name . ' (stack)';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Stacks',          'href' => route('admin.dictionary.stack.index') ],
        [ 'name' => $stack->name ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($stack, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.dictionary.stack.edit', $stack)])->render();
    }
    if (canCreate($stack, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Stack', 'href' => route('admin.dictionary.stack.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.dictionary.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $stack->id,
            'hide'  => !$isRootAdmin,
        ])

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => htmlspecialchars($stack->full_name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($stack->name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $stack->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => htmlspecialchars($stack->abbreviation)
        ])

        @include('admin.components.show-row', [
            'name'  => 'definition',
            'value' => htmlspecialchars($stack->definition)
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'open source',
            'checked' => $stack->open_source
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'proprietary',
            'checked' => $stack->proprietary
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'compiled',
            'checked' => $stack->compiled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $stack->owner
        ])

        @include('admin.components.show-row', [
            'name'  => 'wikipedia',
            'value' => $stack->wikipedia
                       . (!empty($stack->link)
                            ? view('admin.components.link-icon', [
                                  'title'  => 'open link in new window',
                                  'href'   => $stack->wikipedia,
                                  'icon'   => 'fa-external-link',
                                  'border' => false,
                                  'target' => '_blank',
                                  'style'  => [ 'margin-top: -4px' ]
                              ])
                           : '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'link',
            'value' => $stack->link
                       . (!empty($stack->link)
                            ? view('admin.components.link-icon', [
                                  'title'  => 'open link in new window',
                                  'href'   => $stack->link,
                                  'icon'   => 'fa-external-link',
                                  'border' => false,
                                  'target' => '_blank',
                                  'style'  => [ 'margin-top: -4px' ]
                              ])
                           : '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $stack->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($stack->description)
        ])

        @include('admin.components.show-row-images', [
            'resource' => $stack,
            'upload'   => true,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-visibility', [
            'resource' => $stack,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($stack->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($stack->updated_at)
        ])

    </div>

@endsection
