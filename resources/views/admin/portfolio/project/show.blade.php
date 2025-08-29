@extends('admin.layouts.default', [
    'title' => $project->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Projects' ,       'url' => route('admin.portfolio.project.index') ],
        [ 'name' => 'Show' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',   'url' => route('admin.portfolio.project.edit', $project) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Project', 'url' => route('admin.portfolio.project.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',      'url' => route('admin.portfolio.project.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $project->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $project->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'professional',
            'checked' => $project->professional
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'personal',
            'checked' => $project->personal
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $project->year
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'repository',
            'url'    => $project->repository,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'sample link',
            'url'    => $project->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $project->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $project->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $project->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $project->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $project->admin['username'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($project->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($project->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($project->deleted_at)
        ])

    </div>

@endsection
