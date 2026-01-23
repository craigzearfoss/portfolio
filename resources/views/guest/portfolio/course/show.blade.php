@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? 'Course: ' . $course->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Users',      'href' => route('guest.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Courses',    'href' => route('guest.portfolio.course.index', $owner) ],
        [ 'name' => $course->name ],
    ],
    'buttons'          => [
        view('guest.components.nav-button-back', ['href' => referer('guest.admin.portfolio.course.index', $owner)])->render(),
    ],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $course->disclaimer ])

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $course->name
        ])

        <?php /*
        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $course->featured
        ])
        */ ?>

        @if(!empty($course->summary))
            @include('guest.components.show-row', [
                'name'  => 'summary',
                'value' => $course->summary
            ])
        @endif

        @if(!empty($course->summary))
            @include('guest.components.show-row', [
                'name'  => 'year',
                'value' => $course->year
            ])
        @endif

        @include('guest.components.show-row-checkbox', [
            'name'    => 'completed',
            'checked' => $course->completed
        ])

        @if(!empty($course->date))
            @include('guest.components.show-row', [
                'name'  => 'completion date',
                'value' => longDate($course->completion_date)
            ])
        @endif

        @if(!empty($course->duration_hours))
            @include('guest.components.show-row', [
                'name'  => 'duration hours',
                'value' => $course->duration_hours
            ])
        @endif

        @if(!empty($course->academy))
            @include('guest.components.show-row', [
                'name' => 'academy',
                'value' => view('guest.components.link', [
                                'name' => $course->academy['name'],
                                'href' => $course->academy['link'],
                                'target' =>'_blank'
                            ])
            ])
        @endif

        @if(!empty($course->school))
            @include('guest.components.show-row', [
                'name'  => 'school',
                'value' => $course->school
            ])
        @endif

        @if(!empty($course->instructor))
            @include('guest.components.show-row', [
                'name'  => 'instructor',
                'value' => $course->instructor
            ])
        @endif

        @if(!empty($course->sponsor))
            @include('guest.components.show-row', [
                'name'  => 'sponsor',
                'value' => $course->sponsor
            ])
        @endif

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

        @if(!empty($course->description))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => nl2br($course->description)
            ])
        @endif

        @if(!empty($course->image))
            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $course->image,
                'alt'          => $course->name,
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($course->name, $course->image),
                'image_credit' => $course->image_credit,
                'image_source' => $course->image_source,
            ])
        @endif

        @if(!empty($course->thumbnail))
            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $course->thumbnail,
                'alt'      => $course->name . ', ' . ' thumbnail',
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($course->name . '-thumbnail', $course->thumbnail)
            ])
        @endif

    </div>

@endsection
