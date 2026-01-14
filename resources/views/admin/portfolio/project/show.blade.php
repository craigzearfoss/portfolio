@php
    $buttons = [];
    if (canUpdate($project, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.project.edit', $project) ];
    }
    if (canCreate($project, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Project', 'href' => route('admin.portfolio.project.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.portfolio.project.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Project: ' . $project->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Projects' ,       'href' => route('admin.portfolio.project.index') ],
        [ 'name' => $project->name ]
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $project->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $project->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($project->name ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $project->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $project->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $project->summary ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $project->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'language',
            'value' => htmlspecialchars($project->language ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'language version',
            'value' => htmlspecialchars($project->language_version ?? '')
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'repository',
            'href'    => htmlspecialchars($project->repository_url ?? ''),
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'repository name',
            'value' => htmlspecialchars($project->repository_name ?? ''),
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $project->notes ?? ''
        ])

        @include('admin.components.show-row-link', [
            'name'   => htmlspecialchars($project->link_name ?? 'link'),
            'href'   => htmlspecialchars($project->link ?? ''),
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $project->description ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => htmlspecialchars($project->disclaimer ?? '')
                       ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $project,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $project,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($project->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($project->updated_at)
        ])

    </div>

@endsection
