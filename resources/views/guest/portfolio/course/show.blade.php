@extends('guest.layouts.default', [
    'title' => $title ?? 'Course: ' . $course->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',      'href' => route('guest.homepage') ],
        [ 'name' => 'Portfolio', 'href' => route('guest.portfolio.index') ],
        [ 'name' => 'Course',    'href' => route('guest.portfolio.course.index') ],
        [ 'name' => $course->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.portfolio.course.index') ],
    ],
    'errors'  => $errors->any()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $course->name
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
                            'href' => $course->academy['link'] ?? null,
                            'target' =>'_blank'
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

        @if(!empty($course->certificate_url))
            @include('admin.components.show-row-image', [
                'name'     => 'certificate url',
                'src'      => imageUrl($course->certificate_url),
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($course->name, $course->certificate_url)
            ])
        @endif

        @if(!empty($course->link))
            @include('admin.components.show-row-link', [
                'name'   => 'link',
                'href'   => $course->link,
                'target' => '_blank'
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($course->description ?? '')
        ])

    </div>

@endsection
