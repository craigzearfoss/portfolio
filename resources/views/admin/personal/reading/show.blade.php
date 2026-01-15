@php
    $buttons = [];
    if (canUpdate($reading, loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.personal.reading.edit', $reading) ];
    }
    if (canCreate($reading, loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Reading', 'href' => route('admin.personal.reading.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.personal.reading.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Reading: ' . $reading->title,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Readings',        'href' => route('admin.personal.reading.index') ],
        [ 'name' => $reading->title ],
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $reading->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $reading->owner->username
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'title',
            'value' => $reading->title
        ])

        @include('admin.components.show-row', [
            'name'  => 'author',
            'value' => $reading->author
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $reading->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $reading->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $reading->summary
        ])

        @include('admin.components.show-row', [
            'name'  => 'publication year',
            'value' => $reading->publication_year
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'fiction',
            'checked' => $reading->fiction
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'nonfiction',
            'checked' => $reading->nonfiction
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'paper',
            'checked' => $reading->paper
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'audio',
            'checked' => $reading->audio
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'wishlist',
            'checked' => $reading->wishlist
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $reading->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($reading->link_name) ? $reading->link_name : 'link',
            'href'   => $reading->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $reading->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $reading->disclaimer
                       ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $reading,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $reading,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($reading->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($reading->updated_at)
        ])

    </div>

@endsection
