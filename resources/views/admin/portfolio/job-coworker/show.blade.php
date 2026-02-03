@php
    $buttons = [];
    if (canUpdate($jobCorker, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.job-coworker.edit', $jobCorker)])->render();
    }
    if (canCreate('job-coworker', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job Coworker', 'href' => route('admin.portfolio.job-coworker.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.job-coworker.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? $jobCoworker->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',                  'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',       'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',             'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs',                  'href' => route('admin.portfolio.job.index') ],
        [ 'name' => $jobCoworker->job->name, 'href' => route('admin.portfolio.job.show', $jobCoworker->job) ],
        [ 'name' => 'Coworkers',             'href' => route('admin.portfolio.job-coworker.index', ['job_id' => $jobCoworker->job->id]) ],
        [ 'name' => $jobCoworker->name ],
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        <div style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $jobCoworker->id
        ])

        @if($admin->root)
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
