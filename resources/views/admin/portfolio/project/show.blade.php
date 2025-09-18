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
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',      'url' => Request::header('referer') ?? route('admin.portfolio.project.index') ],
    ],
    'errors'  => $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $project->id
        ])

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
            'name'   => 'link',
            'url'    => $project->link,
            'label'  => $project->link_name,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $project->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'src'   => $project->image,
            'alt'   => $project->name,
            'width' => '300px',
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $project->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $project->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'src'   => $project->thumbnail,
            'alt'   => $project->name,
            'width' => '40px',
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
            'name'    => 'read-only',
            'checked' => $project->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $project->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $project->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'admin',
            'value' => $project->name
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
