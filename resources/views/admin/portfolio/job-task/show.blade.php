@extends('admin.layouts.default', [
    'title' => $jobTask->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Jobs',            'href' => route('admin.portfolio.job.index') ],
        [ 'name' => 'Tasks',           'href' => route('admin.portfolio.job-task.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',        'href' => route('admin.portfolio.job-task.edit', $jobTask) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Job Coworker', 'href' => route('admin.portfolio.job-task.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',           'href' => referer('admin.portfolio.job-task.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $jobTask->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $jobTask->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'company',
            'value' => $jobTask->job['company'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $jobTask->summary
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $jobTask->link,
            'label'  => $jobTask->link_name,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($jobTask->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br($jobTask->notes ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $jobTask->image,
            'alt'      => $jobTask->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($jobTask->name, $jobTask->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $jobTask->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $jobTask->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $jobTask->thumbnail,
            'alt'      => $jobTask->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($jobTask->name, $jobTask->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'    => 'sequence',
            'checked' => $jobTask->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $jobTask->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'     => 'readonly',
            'readonly' => 'read-only',
            'checked'  => $jobTask->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $jobTask->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $jobTask->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($jobTask->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($jobTask->updated_at)
        ])

    </div>

@endsection
