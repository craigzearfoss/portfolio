@extends('admin.layouts.default', [
    'title' => $job->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Jobs',            'url' => route('admin.career.job.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'url' => route('admin.career.job.edit', $job) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Job',   'url' => route('admin.career.job.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'url' => route('admin.career.job.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $job->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'company',
            'value' => $job->company
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $job->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'city',
            'value' => $job->city
        ])

        @include('admin.components.show-row', [
            'name'  => 'state',
            'value' => $job->state
        ])

        @include('admin.components.show-row', [
            'name'  => 'role',
            'value' => $job->role
        ])

        @include('admin.components.show-row', [
            'name'  => 'start_date',
            'value' => (!empty($job->start_month) ? date('F', mktime(0, 0, 0, $job->start_month, 10)) : '') . ' ' . $job->start_year
        ])

        @include('admin.components.show-row', [
            'name'  => 'end_date',
            'value' => (!empty($job->end_month) ? date('F', mktime(0, 0, 0, $job->end_month, 10)) : '') . ' ' . $job->end_year
        ])


        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $job->summary
        ])

        @include('admin.components.show-row-list', [
            'name'  => 'tasks',
            'values' => $job->tasks->pluck('summary')
        ])

        @include('admin.components.show-row-list', [
            'name'  => 'coworkers',
            'values' => $job->coworkers->pluck('name')
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'link',
            'url'    => $job->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $job->link_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $job->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'src'   => $job->image,
            'alt'   => $job->name,
            'width' => '300px',
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image_credit',
            'value' => $job->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image_source',
            'value' => $job->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'src'   => $job->thumbnail,
            'alt'   => $job->name,
            'width' => '40px',
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

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($job->deleted_at)
        ])

    </div>

@endsection
