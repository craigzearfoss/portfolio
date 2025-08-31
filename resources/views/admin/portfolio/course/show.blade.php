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
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',     'url' => route('admin.portfolio.course.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $course->admin['username'] ?? ''
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

        @include('admin.components.show-row', [
            'name'  => 'completed',
            'value' => longDate($course->completed)
        ])

        @include('admin.components.show-row', [
            'name'  => 'academy',
            'value' => $course->academy->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'website',
            'value' => $course->website
        ])

        @include('admin.components.show-row', [
            'name'  => 'instructor',
            'value' => $course->instructor
        ])

        @include('admin.components.show-row', [
            'name'  => 'sponsor',
            'value' => $course->sponsor
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'link',
            'value' => $course->link
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $course->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'value' => $course->image
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $course->thumbnail
        ])

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
            'name'  => 'created at',
            'value' => longDateTime($course->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($course->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($course->deleted_at)
        ])

    </div>

@endsection
