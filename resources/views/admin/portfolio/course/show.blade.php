@php
    $buttons = [];
    if (canUpdate($course, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.course.edit', $course)])->render();
    }
    if (canCreate('course', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Course', 'href' => route('admin.portfolio.course.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.course.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Course: ' . $course->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('home') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Courses',         'href' => route('admin.portfolio.course.index') ],
        [ 'name' => $course->name ],
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

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $course->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $course->owner->username
            ])
        @endif

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

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $course->summary
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

        @include('admin.components.show-row', [
            'name'  => 'duration hours',
            'value' => $course->duration_hours
        ])

        @include('admin.components.show-row', [
            'name' => 'academy',
            'value' => view('admin.components.link', [
                'name' => $course->academy['name'] ?? '',
                'href' => !empty($course->academy)
                                ? route('admin.portfolio.academy.show', $course->academy)
                                : ''
                            ])
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

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $course->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($course->link_name) ? $course->link_name : 'link',
            'href'   => $course->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $course->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $course->disclaimer
                       ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $course,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $course,
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
