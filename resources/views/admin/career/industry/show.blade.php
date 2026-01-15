@php
    $buttons = [];
    if (canUpdate($industry, loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.career.industry.edit', $industry) ];
    }
    if (canCreate($industry, loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Industry', 'href' => route('admin.career.industry.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.career.industry.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Industry: ' . $industry->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Industries',      'href' => route('admin.career.industry.index') ],
        [ 'name' => $industry->name ],
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
            'value' => $industry->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $industry->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $industry->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $industry->abbreviation
        ])

    </div>

@endsection
