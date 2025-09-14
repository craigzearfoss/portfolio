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
            'name'  => 'name',
            'value' => $job->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $job->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'role',
            'value' => $job->role
        ])

        @include('admin.components.show-row', [
            'name'  => 'start_date',
            'name'  => 'start date',
            'value' => longDate($job->start_date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'end_date',
            'name'  => 'end date',
            'value' => longDate($job->end_date)
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
