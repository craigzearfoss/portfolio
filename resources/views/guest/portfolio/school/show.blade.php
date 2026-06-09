@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $school            = $school ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('School: ' . htmlspecialchars($school->name) . (!empty($school->school_year) ? ' - ' . htmlspecialchars($school->school_year) : ''), htmlspecialchars($owner->name));
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'School',                        'href' => route('guest.portfolio.school.index', $owner) ],
            [ 'name' => htmlspecialchars($school->name) ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.school.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => htmlspecialchars($school->disclaimer) ])

    <div class="show-container p-4">

        <table>
            <tbody>

            @if (!empty($school->name))
                <tr>
                    <th>name:</th>
                    <td>{!! htmlspecialchars($school->name) !!}</td>
                </tr>
            @endif

            @if (!empty($school->category))
                <tr>
                    <th>category:</th>
                    <td>{!! htmlspecialchars($school->category) !!}</td>
                </tr>
            @endif

            @if (!empty($school->nominated_work))
                <tr>
                    <th>nominated work:</th>
                    <td>{!! htmlspecialchars($school->nominated_work) !!}</td>
                </tr>
            @endif

            @if (!empty($school->summary))
                <tr>
                    <th>summary:</th>
                    <td>{!! htmlspecialchars($school->summary) !!}</td>
                </tr>
            @endif

            @if (!empty($school->school_year))
                <tr>
                    <th>year:</th>
                    <td>{{ $school->school_year }}</td>
                </tr>
            @endif

            @if (!empty($school->received))
                <tr>
                    <th>date received:</th>
                    <td>{{ $school->received }}</td>
                </tr>
            @endif

            @if (!empty($school->organization))
                <tr>
                    <th>organization:</th>
                    <td>{!! htmlspecialchars($school->organization) !!}</td>
                </tr>
            @endif

            @if (!empty($school->link))
                <tr>
                    <th>{{ !empty($school->link_name) ? $school->link_name : 'link' }}:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => !empty($school->link_name) ? htmlspecialchars($school->link_name) : 'link',
                            'href'   => $school->link,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($school->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $school->description !!}</td>
                </tr>
            @endif

            @if (!empty($school->image))
                <tr>
                    <td colspan="2">
                        @include('guest.components.image-credited', [
                            'name'         => 'image',
                            'src'          => $school->image,
                            'alt'          => htmlspecialchars($school->name) . (!empty($school->artist) ? ', ' . htmlspecialchars($school->artist) : ''),
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($school),
                            'image_credit' => htmlspecialchars($school->image_credit),
                            'image_source' => htmlspecialchars($school->image_source),
                        ])
                    </td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
