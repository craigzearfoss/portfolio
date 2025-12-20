@php
    $buttons = [];
    if (canUpdate($job)) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.job.edit', $job) ];
    }
    if (canCreate($job)) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Job', 'href' => route('admin.portfolio.job.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.portfolio.job.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Job: ' . $job->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs',            'href' => route('admin.portfolio.job.index') ],
        [ 'name' => $job->name ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $job->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $job->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'company',
            'value' => htmlspecialchars($job->company)
        ])

        @include('admin.components.show-row', [
            'name'  => 'role',
            'value' => htmlspecialchars($job->role)
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $job->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $job->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => htmlspecialchars($job->summary)
        ])

        @include('admin.components.show-row', [
            'name'  => 'start',
            'value' => (!empty($job->start_month) ? date('F', mktime(0, 0, 0, $job->start_month, 10)) : '') . ' ' . $job->start_year
        ])

        @include('admin.components.show-row', [
            'name'  => 'end',
            'value' => (!empty($job->end_month) ? date('F', mktime(0, 0, 0, $job->end_month, 10)) : '') . ' ' . $job->end_year
        ])

        @include('admin.components.show-row', [
            'name'  => 'employment type',
            'value' => $job->employmentType['name'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'employment location',
            'value' => $job->locationType->name ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                           'street'          => htmlspecialchars($job->street),
                           'street2'         => htmlspecialchars($job->street2),
                           'city'            => htmlspecialchars($job->city),
                           'state'           => $job->state->code ?? '',
                           'zip'             => htmlspecialchars($job->zip),
                           'country'         => $job->country->iso_alpha3 ?? '',
                           'streetSeparator' => '<br>',
                       ])
        ])

        @include('admin.components.show-row-coordinates', [
            'resource' => $job
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br(htmlspecialchars($job->notes))
        ])

        @include('admin.components.show-row-link', [
            'name'   => $job->link_name ?? 'link',
            'href'   => $job->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($job->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $job->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $job,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $job,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($job->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($job->updated_at)
        ])

        @include('admin.portfolio.job.coworker.panel', [
            'coworkers' => $job->coworkers ?? [],
            'job'  => $job
        ])

        @include('admin.portfolio.job.task.panel', [
            'tasks' => $job->tasks ?? [],
            'job'   => $job
        ])

        @include('admin.portfolio.job.skill.panel', [
            'skills' => $job->skills ?? [],
            'job'    => $job
        ])

    </div>

@endsection
