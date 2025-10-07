@extends('admin.layouts.default', [
    'title' => 'Job: ' . $job->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('guest.homepage') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Jobs',            'href' => route('admin.portfolio.job.index') ],
        [ 'name' => $job->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.job.edit', $job) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Job',   'href' => route('admin.portfolio.job.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.portfolio.job-task.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
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
                'value' => $job->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'company',
            'value' => $job->company
        ])

        @include('admin.components.show-row', [
            'name'  => 'role',
            'value' => $job->role
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
            'value' => $job->summary
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
            'value' => $job->locationType['name'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $job->notes
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                           'street'    => $job->street ?? null,
                           'street2'   => $job->street2 ?? null,
                           'city'      => $job->city ?? null,
                           'state'     => $job->state['code'] ?? null,
                           'zip'       => $job->zip ?? null,
                           'country'   => $job->country['iso_alpha3'] ?? null,
                       ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'latitude',
            'value' => $job->latitude
        ])

        @include('admin.components.show-row', [
            'name'  => 'longitude',
            'value' => $job->longitude
        ])

        @include('admin.portfolio.job.coworker.panel', [
            'coworkers' => $job->coworkers ?? [],
            'job'  => $job
        ])

        @include('admin.portfolio.job.task.panel', [
            'tasks' => $job->tasks ?? [],
            'job'   => $job
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $job->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $job->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'   => 'link name',
            'value'  => $job->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($job->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $job->image,
            'alt'      => $job->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($job->name, $job->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image_credit',
            'value' => $job->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image_source',
            'value' => $job->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $job->thumbnail,
            'alt'      => $job->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($job->name, $job->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $job->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $job->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'readonly',
            'label'   => 'read-only',
            'checked' => $job->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $job->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $job->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($job->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($job->updated_at)
        ])

    </div>

@endsection
