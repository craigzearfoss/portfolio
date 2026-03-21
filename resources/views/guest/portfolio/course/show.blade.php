@php
    $title    = $pageTitle ?? 'Course: ' . $course->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Courses',    'href' => route('guest.portfolio.course.index', $owner) ],
            [ 'name' => $course->name ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.course.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $course->disclaimer ])

    <div class="show-container card p-4">

        <table>
            <tbody>

            @if(!empty($course->name))
                <tr>
                    <th>name:</th>
                    <td>{{ $course->name }}</td>
                </tr>
            @endif

            @if(!empty($course->summary))
                <tr>
                    <th>summary:</th>
                    <td>{{ $course->summary }}</td>
                </tr>
            @endif

            @if(!empty($course->year))
                <tr>
                    <th>year:</th>
                    <td>{{ $course->year }}</td>
                </tr>
            @endif

            @if(!empty($course->completed))
                <tr>
                    <th>completed:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $course->completed
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($course->completion_date))
                <tr>
                    <th>completion date:</th>
                    <td>{{ longDate($course->completion_date) }}</td>
                </tr>
            @endif

            @if(!empty($course->duration_hours))
                <tr>
                    <th>duration hours:</th>
                    <td>{{ $course->duration_hours }}</td>
                </tr>
            @endif

            @if(!empty($course->academy))
                <tr>
                    <th>academy:</th>
                    <td>
                        @include('guest.components.link', [
                            'name' => $course->academy['name'],
                            'href' => $course->academy['link'],
                            'target' =>'_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($course->school))
                <tr>
                    <th>school:</th>
                    <td>{{ $course->school }}</td>
                </tr>
            @endif

            @if(!empty($course->instructor))
                <tr>
                    <th>instructor:</th>
                    <td>{{ $course->instructor }}</td>
                </tr>
            @endif

            @if(!empty($course->sponsor))
                <tr>
                    <th>sponsor:</th>
                    <td>{{ $course->sponsor }}</td>
                </tr>
            @endif

            @if(!empty($course->certificate_url))
                <tr>
                    <th>certificate url:</th>
                    <td>
                        @include('guest.components.image', [
                            'name'     => 'certificate url',
                            'src'      => imageUrl($course->certificate_url),
                            'width'    => '300px',
                            'download' => true,
                            'external' => true,
                            'filename' => generateDownloadFilename($course)
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($course->link))
                <tr>
                    <th>{{ !empty($course->link_name) ? $course->link_name : 'link' }}:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => $course->link_name,
                            'href'   => $course->link,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($course->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $course->description !!}</td>
                </tr>
            @endif

            @if(!empty($course->image))
                <tr>
                    <td colspan="2">
                        @include('guest.components.image-credited', [
                            'name'         => 'image',
                            'src'          => $course->image,
                            'alt'          => $course->name,
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($course),
                            'image_credit' => $course->image_credit,
                            'image_source' => $course->image_source,
                        ])
                    </td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
