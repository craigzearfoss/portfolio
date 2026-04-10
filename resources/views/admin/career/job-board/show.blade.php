@php
    use \App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Job Board: ' . $jobBoard->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Job Boards',      'href' => route('admin.career.job-board.index') ],
        [ 'name' => $jobBoard->name ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($jobBoard, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.career.job-board.edit', $jobBoard)])->render();
    }
    if (canCreate($jobBoard, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job Board', 'href' => route('admin.career.job-board.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.career.job-board.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $jobBoard->id,
            'hide'  => !$isRootAdmin,
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $jobBoard->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $jobBoard->slug
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'primary',
            'checked' => $jobBoard->primary
        ])

        @include('admin.components.show-row', [
            'name'  => 'coverage area',
            'value' => implode(', ', $jobBoard->coverageAreas ?? [])
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'local',
            'checked' => $jobBoard->local
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'regional',
            'checked' => $jobBoard->regional
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'national',
            'checked' => $jobBoard->national
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'international',
            'checked' => $jobBoard->international
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $jobBoard->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'   => 'link name',
            'label'  => 'link_name',
            'value'  => $jobBoard->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $jobBoard->description
        ])

        @include('admin.components.show-row-images', [
            'resource' => $jobBoard,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-visibility', [
            'resource' => $jobBoard,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($jobBoard->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($jobBoard->updated_at)
        ])

    </div>

@endsection
