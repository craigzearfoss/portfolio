@extends('admin.layouts.default', [
    'title' => $course->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Courses',         'url' => route('admin.portfolio.course.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',  'url' => route('admin.portfolio.course.edit', $course) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Course', 'url' => route('admin.portfolio.course.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',     'url' => referer('admin.portfolio.course.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $course->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $course->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $course->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $course->featured
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'professional',
            'checked' => $course->professional
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'personal',
            'checked' => $course->personal
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $course->year
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'completed',
            'checked' => $course->completed
        ])

        @include('admin.components.show-row', [
            'name'  => 'completion date',
            'value' => longDate($course->completion_date)
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'duration hours',
            'checked' => $course->duration_hours
        ])

        @include('admin.components.show-row', [
            'name'  => 'academy',
            'value' => $course->academy['name'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'school',
            'value' => $course->school
        ])

        @include('admin.components.show-row', [
            'name'  => 'instructor',
            'value' => $course->instructor
        ])

        @include('admin.components.show-row', [
            'name'  => 'sponsor',
            'value' => $course->sponsor
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'certificate url',
            'src'      => $course->certificate_url,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($course->name, $course->certificate_url)
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $course->link,
            'label'  => $course->link_name,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($course->description ?? '')
        ])

        <?php /*
        @include('admin.components.show-row', [
            'name'     => 'image',
            'src'      => $course->image,
            'alt'      => $course->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($course->name, $course->image)
        ])
        */ ?>

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $course->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $course->image_source
        ])

        <?php /*
        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $course->thumbnail,
            'alt'      => $course->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($course->name, $course->thumbail)
        ])
        */ ?>

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $course->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $course->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $course->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $course->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $course->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'admin',
            'value' => $course->admin['username'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($course->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($course->updated_at)
        ])

    </div>

@endsection
