@php
    $buttons = [];
    if (canUpdate($art, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.art.edit', $art)])->render();
    }
    if (canCreate('art', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Art', 'href' => route('admin.portfolio.art.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.art.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Art: ' . $art->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Art',             'href' => route('admin.portfolio.art.index') ],
        [ 'name' => $art->name ],
    ],
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
            'value' => $art->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $art->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $art->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'artist',
            'value' => $art->artist
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $art->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $art->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $art->summary
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $art->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $art->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => $art->link_name ?? 'link',
            'href'   => $art->link ?? '',
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $art->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $art->disclaimer
                       ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $art,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $art,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($art->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($art->updated_at)
        ])

    </div>

@endsection
