@php
    $buttons = [];
    if (canUpdate($link, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.link.edit', $link) ];
    }
    if (canCreate($link, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Link', 'href' => route('admin.portfolio.link.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.portfolio.link.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Link: ' . $link->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Links',           'href' => route('admin.portfolio.link.index') ],
        [ 'name' => $link->name ],
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
            'value' => $link->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $link->owner->username
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $link->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $link->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $link->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $link->summary
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'url',
            'href'    => $link->url,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $link->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($link->link_name) ? $link->link_name : 'link',
            'href'   => $link->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $link->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $link->disclaimer
                       ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $link,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $link,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($link->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($link->updated_at)
        ])

    </div>

@endsection
