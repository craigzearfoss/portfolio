@php
    use \App\Enums\PermissionEntityTypes;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Job Boards',      'href' => route('admin.career.job-board.index') ],
        [ 'name' => $jobBoard->name ]
    ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $jobBoard, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.career.job-board.edit', $jobBoard)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'job-board', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job Board', 'href' => route('admin.career.job-board.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.career.job-board.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Job Board: ' . $jobBoard->name,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $jobBoard->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $jobBoard->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $jobBoard->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'primary',
            'checked' => $jobBoard->primary
        ])

        @include('admin.components.show-row', [
            'name'  => 'coverage area',
            'value' => implode(', ', $jobBoard->coverageAreas ?? [])
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'local',
            'checked' => $jobBoard->local
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'regional',
            'checked' => $jobBoard->regional
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'national',
            'checked' => $jobBoard->national
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'international',
            'checked' => $jobBoard->international
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($jobBoard->link_name) ? $jobBoard->link_name : 'link',
            'href'   => $jobBoard->link,
            'target' => '_blank'
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

        @include('admin.components.show-row-settings', [
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
