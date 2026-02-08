@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Units',     'href' => route('admin.personal.unit.index') ],
        [ 'name' => $unit->name ]
    ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $unit, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.personal.unit.edit', $unit)])->render();
    }
    if (canCreate(\App\Enums\PermissionEntityTypes::RESOURCE, 'unit', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Unit', 'href' => route('admin.personal.unit.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.personal.unit.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Unit: ' . $unit->name,
    'breadcrumbs'      => $breadcrumbs,
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

    <div class="card p-4">

        <div style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $unit->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $unit->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $unit->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'system',
            'value' => $unit->system
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   =>$unit->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($unit->link_name) ? $unit->link_name : 'link',
            'href'   => $unit->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $unit->description
        ])

        @include('admin.components.show-row-images', [
            'resource' => $unit,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $unit,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($unit->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($unit->updated_at)
        ])

    </div>

@endsection
