@extends('guest.layouts.default', [
    'title' => $title ?? 'Course: ' . $course->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.admin.portfolio.show', $admin) ],
        [ 'name' => 'Courses',    'href' => route('guest.admin.portfolio.course.index', $admin) ],
        [ 'name' => $course->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.admin.portfolio.course.index', $admin) ],
    ],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $course->name
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $course->featured
        ])

        @include('guest.components.show-row', [
            'name'  => 'summary',
            'value' => $course->summary
        ])

        @include('guest.components.show-row', [
            'name'  => 'year',
            'value' => $course->year
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'completed',
            'checked' => $course->completed
        ])

        @include('guest.components.show-row', [
            'name'  => 'completion date',
            'value' => longDate($course->completion_date)
        ])

        @include('guest.components.show-row', [
            'name'  => 'duration hours',
            'value' => $course->duration_hours
        ])

        @include('guest.components.show-row', [
            'name' => 'academy',
            'value' => view('guest.components.link', [
                            'name' => $course->academy['name'] ?? '',
                            'href' => $course->academy['link'] ?? null,
                            'target' =>'_blank'
                        ])
        ])

        @include('guest.components.show-row', [
            'name'  => 'school',
            'value' => $course->school
        ])

        @include('guest.components.show-row', [
            'name'  => 'instructor',
            'value' => $course->instructor
        ])

        @include('guest.components.show-row', [
            'name'  => 'sponsor',
            'value' => $course->sponsor
        ])

        @if(!empty($course->certificate_url))
            @include('guest.components.show-row-image', [
                'name'     => 'certificate url',
                'src'      => imageUrl($course->certificate_url),
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($course->name, $course->certificate_url)
            ])
        @endif

        @if(!empty($course->link))
            @include('guest.components.show-row-link', [
                'name'   => $course->link_name,
                'href'   => $course->link,
                'target' => '_blank'
            ])
        @endif

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($course->description ?? '')
        ])

        @if(!empty($course->image))

            @include('guest.components.show-row-image', [
                'name'     => 'image',
                'src'      => $course->image,
                'alt'      => $course->name . ', ' . $course->artist,
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($course->name . '-by-' . $course->artist, $course->image)
            ])

            @if(!empty($course->image_credit))
                @include('guest.components.show-row', [
                    'name'  => 'image credit',
                    'value' => $course->image_credit
                ])
            @endif

            @if(!empty($course->image_source))
                @include('guest.components.show-row', [
                    'name'  => 'image source',
                    'value' => $course->image_source
                ])
            @endif

        @endif

        @if(!empty($course->thumbnail))

            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $course->thumbnail,
                'alt'      => $course->name . ', ' . $course->artist,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($course->name . '-by-' . $course->artist, $course->thumbnail)
            ])

        @endif

    </div>

@endsection
