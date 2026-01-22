@php
    $buttons = [];
    if (canUpdate($academy, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.academy.edit', $academy)])->render();
    }
    if (canCreate('academy', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Academy', 'href' => route('admin.portfolio.academy.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.academy.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Academy: ' . $academy->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('home') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Academies',       'href' => route('admin.portfolio.academy.index') ],
        [ 'name' => $academy->name ],
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
            'value' => $academy->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $academy->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $academy->slug
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($academy->link_name) ? $academy->link_name : 'link',
            'href'   => $academy->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $academy->description
        ])

        @include('admin.components.show-row-images', [
            'resource' => $academy,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $academy,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($academy->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($academy->updated_at)
        ])

    </div>

@endsection
