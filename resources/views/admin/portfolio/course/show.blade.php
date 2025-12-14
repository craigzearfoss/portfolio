@php
    $buttons = [];
    if (canUpdate($course)) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.course.edit', $course) ];
    }
    if (canCreate($course)) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Course', 'href' => route('admin.portfolio.course.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.portfolio.course.index') ];
@endphp
@extends('admin.layouts.default', [
    'title' => 'Course: ' . $course->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Courses',         'href' => route('admin.portfolio.course.index') ],
        [ 'name' => $course->name ],
    ],
    'buttons' => $buttons,
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $course->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $course->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($course->name)
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
            'value' => htmlspecialchars($course->summary)
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
            'value' => htmlspecialchars($course->school)
        ])

        @include('admin.components.show-row', [
            'name'  => 'instructor',
            'value' => htmlspecialchars($course->instructor)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sponsor',
            'value' => htmlspecialchars($course->sponsor)
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'certificate url',
            'src'      => imageUrl($course->certificate_url),
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($course->name, $course->certificate_url)
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br(htmlspecialchars($course->notes))
        ])

        @if(!empty($course->link))
            @include('admin.components.show-row-link', [
                'name'   => $course->link_name,
                'href'   => $course->link,
                'target' => '_blank'
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($course->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $course->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $course->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug(htmlspecialchars($course->name), $course->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => htmlspecialchars($course->image_credit)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => htmlspecialchars($course->image_source)
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $course->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug(htmlspecialchars($course->name) . '-thumb', $course->thumbnail)
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

    </div>

@endsection
