@php
    $buttons = [];
    if (canUpdate($project)) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.project.edit', $project) ];
    }
    if (canCreate($project)) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Project', 'href' => route('admin.portfolio.project.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.portfolio.project.index') ];
@endphp
@extends('admin.layouts.default', [
    'title' => 'Project: ' . $project->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Projects' ,       'href' => route('admin.portfolio.project.index') ],
        [ 'name' => $project->name ]
    ],
    'buttons' => $buttons,
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
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
            'value' => htmlspecialchars($project->name)
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
            'value' => $project->summary
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $project->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'language',
            'value' => $project->language
        ])

        @include('admin.components.show-row', [
            'name'  => 'language version',
            'value' => $project->language_version
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'repository',
            'href'    => $project->repository_url,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'repository name',
            'value' => htmlspecialchars($project->repository_name),
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br(htmlspecialchars($project->notes))
        ])

        @if(!empty($project->link))
            @include('admin.components.show-row-link', [
                'name'   => $project->link_name,
                'href'   => $project->link,
                'target' => '_blank'
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($project->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $project->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $project->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug(htmlspecialchars($project->name), $project->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => htmlspecialchars($project->image_credit)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => htmlspecialchars($project->image_source)
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $project->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug(htmlspecialchars($project->name) . '-thumb', $project->thumbnail)
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
            'name'  => 'created at',
            'value' => longDateTime($project->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($project->updated_at)
        ])

    </div>

@endsection
