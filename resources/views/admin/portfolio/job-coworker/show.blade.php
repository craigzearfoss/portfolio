@extends('admin.layouts.default', [
    'title' => $jobCoworker->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Jobs',            'url' => route('admin.portfolio.job.index') ],
        [ 'name' => 'Coworkers',       'url' => route('admin.portfolio.job-coworker.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',        'url' => route('admin.portfolio.job-coworker.edit', $jobCoworker) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Job Coworker', 'url' => route('admin.portfolio.job-coworker.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',           'url' => referer('admin.portfolio.job-coworker.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $jobCoworker->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $jobCoworker->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'job_title',
            'label' => 'job title',
            'value' => $jobCoworker->job_title
        ])

        @include('admin.components.show-row', [
            'name'  => 'level',
            'value' => \App\Models\Portfolio\JobCoworker::getLevel($jobCoworker->level)
        ])

        @include('admin.components.show-row', [
            'name'  => 'work_phone',
            'label' => 'work phone',
            'value' => $jobCoworker->work_phone
        ])

        @include('admin.components.show-row', [
            'name'  => 'personal_phone',
            'label' => 'personal phone',
            'value' => $jobCoworker->personal_phone
        ])

        @include('admin.components.show-row', [
            'name'  => 'work_email',
            'label' => 'work email',
            'value' => $jobCoworker->work_email
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'label'  => $jobCoworker->link_name,
            'url'    => $jobCoworker->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $jobCoworker->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $jobCoworker->notes
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'src'   => $jobCoworker->image,
            'alt'   => $jobCoworker->name,
            'width' => '300px',
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image credit',
            'value' => $jobCoworker->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $jobCoworker->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'src'   => $jobCoworker->thumbnail,
            'alt'   => $jobCoworker->name,
            'width' => '40px',
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
            'name'  => 'owner',
            'value' => $jobCoworker->admin['username'] ?? ''
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
