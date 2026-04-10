@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Industry: ' . $industry->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Industries',      'href' => route('admin.career.industry.index') ],
        [ 'name' => $industry->name ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($industry, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.career.industry.edit', $industry)])->render();
    }
    if (canCreate($industry, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Industry', 'href' => route('admin.career.industry.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.career.industry.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $industry->id,
            'hide'  => !$isRootAdmin,
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
