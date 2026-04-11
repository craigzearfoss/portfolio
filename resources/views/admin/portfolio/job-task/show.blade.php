@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $job         = $job ?? null;
    $jobTask     = $jobTask ?? null;

    $title    = $pageTitle ?? 'Job Task';
    $subtitle = $title;

    // set navigation buttons
    $breadcrumbs = [
        [ 'name' => 'Home',              'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',   'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',         'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs',              'href' => route('admin.portfolio.job.index') ],
        [ 'name' => $jobTask->job->name, 'href' => route('admin.portfolio.job.show', $jobTask->job) ],
        [ 'name' => 'Tasks',             'href' => route('admin.portfolio.job-task.index', ['job_id' => $jobTask->job->id]) ],
        [ 'name' => 'Show' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($jobTask, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.job-task.edit', $jobTask)])->render();
    }
    if (canCreate($jobTask, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job Task', 'href' => route('admin.portfolio.job-task.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.job-task.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $jobTask->id,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $jobTask->owner->username,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'job',
                'value' =>  view('admin.components.link', [
                    'name' => $jobTask->job->name ?? '',
                    'href' => route('admin.portfolio.job.show', $jobTask->job)
                ])
            ])

            @include('admin.components.show-row', [
                'name'  => 'company',
                'value' => $jobTask->job->company ?? ''
            ])

            @include('admin.components.show-row', [
                'name'  => 'summary',
                'value' => $jobTask->summary
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => $jobTask->notes
            ])

            @include('admin.components.show-row-link', [
                'name'   => 'link',
                'href'   => $jobTask->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row', [
                'name'   => 'link name',
                'label'  => 'link_name',
                'value'  => $jobTask->link_name,
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $jobTask->description
            ])

            @include('admin.components.show-row', [
                'name'  => 'disclaimer',
                'value' => view('admin.components.disclaimer', [
                                'value' => $jobTask->disclaimer
                           ])
            ])

            @include('admin.components.show-row-images', [
                'resource' => $jobTask,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row-visibility', [
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
    </div>

@endsection
