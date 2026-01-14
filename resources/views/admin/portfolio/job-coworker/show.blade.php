@php
    $buttons = [];
    if (canUpdate($jobCorker, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.job-coworker.edit', $jobCoworker) ];
    }
    if (canCreate($jobCoworker, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add Coworker', 'href' => route('admin.portfolio.job-coworker.create', ['job_id' => $jobCoworker->job->id]) ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.portfolio.job-coworker.index') ];
@endphp
@extends('admin.layouts.default', [
    'title' => $pageTitle ?? $jobCoworker->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',                  'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',       'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',             'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs',                  'href' => route('admin.portfolio.job.index') ],
        [ 'name' => $jobCoworker->job->name, 'href' => route('admin.portfolio.job.show', $jobCoworker->job) ],
        [ 'name' => 'Coworkers',             'href' => route('admin.portfolio.job-coworker.index', ['job_id' => $jobCoworker->job->id]) ],
        [ 'name' => $jobCoworker->name ],
    ],
    'buttons' => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
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
                'value' => $jobCoworker->owner->username
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
            'name'   => !empty($jobCoworker->link_name) ? $jobCoworker->link_name : 'link',
            'href'   => $jobCoworker->link,
            'target' => '_blank'
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

        @include('admin.components.show-row-settings', [
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

@endsection
