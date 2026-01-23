@php
    $buttons = [];
    if (canUpdate($award, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.award.edit', $award)])->render();
    }
    if (canCreate('award', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Award', 'href' => route('admin.portfolio.award.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.award.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Award: ' . $award->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Award',           'href' => route('admin.portfolio.award.index') ],
        [ 'name' => $award->name ],
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

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $award->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $award->owner->username
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $award->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'category',
            'value' => $award->category
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $award->nominated_work
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $award->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $award->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $award->summary
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $award->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'date received',
            'value' => longDate($award->received)
        ])

        @include('admin.components.show-row-images', [
            'resource' => $award,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $award->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($award->link_name) ? $award->link_name ?? 'link',
            'href'   => $award->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $award->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $award->disclaimer
                       ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $award,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $award,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($award->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($award->updated_at)
        ])

    </div>

@endsection
