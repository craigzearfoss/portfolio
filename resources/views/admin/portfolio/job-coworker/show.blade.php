@extends('admin.layouts.default', [
    'title' => $jobCoworker->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Jobs',            'href' => route('admin.portfolio.job.index') ],
        [ 'name' => 'Coworkers',       'href' => route('admin.portfolio.job-coworker.index') ],
        [ 'name' => $jobCoworker->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',        'href' => route('admin.portfolio.job-coworker.edit', $jobCoworker) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Job Coworker', 'href' => route('admin.portfolio.job-coworker.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',           'href' => referer('admin.portfolio.job-coworker.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $jobCoworker->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $jobCoworker->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'job',
            'value' =>  view('admin.components.link', [
                'name' => $jobCoworker->job->name,
                'href' => route('admin.portfolio.job.show', $jobCoworker->job)
            ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $jobCoworker->name
        ])

        @include('admin.components.show-row', [
            'name' => 'job title',
            'value' => $jobCoworker->job_title
        ])

        @include('admin.components.show-row', [
            'name'  => 'level',
            'value' => $jobCoworker->level
        ])

        @include('admin.components.show-row', [
            'name'  => 'work phone',
            'value' => $jobCoworker->work_phone
        ])

        @include('admin.components.show-row', [
            'name' => 'personal phone',
            'value' => $jobCoworker->personal_phone
        ])

        @include('admin.components.show-row', [
            'name' => 'work email',
            'value' => $jobCoworker->work_email
        ])

        @include('admin.components.show-row', [
            'name' => 'personal email',
            'value' => $jobCoworker->personal_email
        ])

        @include('admin.components.show-row', [
            'name' => 'notes',
            'value' => $jobCoworker->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $jobCoworker->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $jobCoworker->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($jobCoworker->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br($jobCoworker->notes ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $jobCoworker->image,
            'alt'      => $jobCoworker->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($jobCoworker->name, $jobCoworker->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $jobCoworker->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $jobCoworker->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $jobCoworker->thumbnail,
            'alt'      => $jobCoworker->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($jobCoworker->name, $jobCoworker->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $jobCoworker->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $jobCoworker->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $jobCoworker->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $jobCoworker->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $jobCoworker->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($jobCoworker->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($jobCoworker->updated_at)
        ])

    </div>

@endsection
