@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $job         = $job ?? null;
    $jobCoworker = $jobCoworker ?? null;

    $title    = $pageTitle ?? 'Job Coworker: ' . $jobCoworker->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                  'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',       'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',             'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs',                  'href' => route('admin.portfolio.job.index') ],
        [ 'name' => $jobCoworker->job->name, 'href' => route('admin.portfolio.job.show', $jobCoworker->job) ],
        [ 'name' => 'Coworkers',             'href' => route('admin.portfolio.job-coworker.index', ['job_id' => $jobCoworker->job->id]) ],
        [ 'name' => $jobCoworker->name ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($jobCoworker, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.job-coworker.edit', $jobCoworker)])->render();
    }
    if (canCreate($jobCoworker, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job Coworker', 'href' => route('admin.portfolio.job-coworker.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.job-coworker.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $jobCoworker->id,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $jobCoworker->owner->username,
                'hide'  => !$isRootAdmin,
            ])

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
                'name' => 'title',
                'value' => $jobCoworker->title
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
                'name'  => 'notes',
                'value' => $jobCoworker->notes
            ])

            @include('admin.components.show-row-link', [
                'name'   => 'link',
                'href'   => $jobCoworker->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row', [
                'name'   => 'link name',
                'label'  => 'link_name',
                'value'  => $jobCoworker->link_name,
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $jobCoworker->description
            ])

            @include('admin.components.show-row', [
                'name'  => 'disclaimer',
                'value' => view('admin.components.disclaimer', [
                                'value' => $jobCoworker->disclaimer
                           ])
            ])

            @include('admin.components.show-row-images', [
                'resource' => $jobCoworker,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $jobCoworker,
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
    </div>

@endsection
