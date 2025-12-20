@extends('admin.layouts.default', [
    'title'         => 'Job Task',
    'breadcrumbs'   => [
        [ 'name' => 'Home',              'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard',   'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',         'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs',              'href' => route('admin.portfolio.job.index') ],
        [ 'name' => $jobTask->job->name, 'href' => route('admin.portfolio.job.show', $jobTask->job) ],
        [ 'name' => 'Tasks',             'href' => route('admin.portfolio.job-task.index', ['job_id' => $jobTask->job->id]) ],
        [ 'name' => 'Show' ],
    ],
    'buttons'       => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.job-task.edit', $jobTask) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add Task', 'href' => route('admin.portfolio.job-task.create', ['job_id' => $jobTask->job->id]) ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.portfolio.job-task.index') ],
    ],
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $jobTask->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $jobTask->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'job',
            'value' =>  view('admin.components.link', [
                'name' => htmlspecialchars($jobTask->job->name),
                'href' => route('admin.portfolio.job.show', $jobTask->job)
            ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'company',
            'value' => htmlspecialchars($jobTask->job->company ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $jobTask->summary
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br(htmlspecialchars($jobTask->notes))
        ])

        @include('admin.components.show-row-link', [
            'name'   => $jobTask->link_name ?? 'link',
            'href'   => $jobTask->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($jobTask->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $jobTask->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $jobTask,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $jobTask,
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
