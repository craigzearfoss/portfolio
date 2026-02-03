@php
    $buttons = [];
    if (canUpdate($certification, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.certification.edit', $certification)])->render();
    }
    if (canCreate('certification', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Certification', 'href' => route('admin.portfolio.certification.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.certification.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Certification: ' . $certification->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Certifications',  'href' => route('admin.portfolio.certification.index') ],
        [ 'name' => $certification->name ],
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
            'value' => $certification->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $certification->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $certification->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $certification->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'type',
            'value' => $certification->certificationType->name ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'organization',
            'value' => $certification->organization
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $certification->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($certification->link_name) ? $certification->link_name :'link',
            'href'   => $certification->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $certification->description
        ])

        @include('admin.components.show-row-images', [
            'resource' => $certification,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $certification,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($certification->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($certification->updated_at)
        ])

    </div>

@endsection
