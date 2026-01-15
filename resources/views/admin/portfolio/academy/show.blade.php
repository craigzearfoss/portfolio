@php
    $buttons = [];
    if (canUpdate($academy, loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.academy.edit', $academy) ];
    }
    if (canCreate($academy, loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Academy', 'href' => route('admin.portfolio.academy.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.portfolio.academy.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Academy: ' . $academy->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Academies',       'href' => route('admin.portfolio.academy.index') ],
        [ 'name' => $academy->name ],
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
