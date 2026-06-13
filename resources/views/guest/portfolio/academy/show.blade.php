@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $academy          = $academy ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? 'Academy: ' . htmlspecialchars($academy->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Academies',                    'href' => route('guest.portfolio.academy.index', $owner) ],
            [ 'name' => htmlspecialchars($academy->name) ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.academy.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => htmlspecialchars($academy->disclaimer) ])

    <div class="show-container p-4">

        <table>
            <tbody>

            @if (!empty($academy->name))
                <tr>
                    <th>name:</th>
                    <td>{!! htmlspecialchars($academy->name) !!}</td>
                </tr>
            @endif

            @if (!empty($academy->category))
                <tr>
                    <th>category:</th>
                    <td>{!! htmlspecialchars($academy->category) !!}</td>
                </tr>
            @endif

            @if (!empty($academy->nominated_work))
                <tr>
                    <th>nominated work:</th>
                    <td>{!! htmlspecialchars($academy->nominated_work) !!}</td>
                </tr>
            @endif

            @if (!empty($academy->summary))
                <tr>
                    <th>summary:</th>
                    <td>{!! htmlspecialchars($academy->summary) !!}</td>
                </tr>
            @endif

            @if (!empty($academy->academy_year))
                <tr>
                    <th>year:</th>
                    <td>{{ $academy->academy_year }}</td>
                </tr>
            @endif

            @if (!empty($academy->received))
                <tr>
                    <th>date received:</th>
                    <td>{{ $academy->received }}</td>
                </tr>
            @endif

            @if (!empty($academy->organization))
                <tr>
                    <th>organization:</th>
                    <td>{!! htmlspecialchars($academy->organization) !!}</td>
                </tr>
            @endif

            @if (!empty($academy->link))
                <tr>
                    <th>{{ !empty($academy->link_name) ? $academy->link_name : 'link' }}:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => !empty($academy->link_name) ? htmlspecialchars($academy->link_name) : 'link',
                            'href'   => $academy->link,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($academy->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $academy->description !!}</td>
                </tr>
            @endif

            @if (!empty($academy->image))
                <tr>
                    <td colspan="2">
                        @include('guest.components.image-credited', [
                            'name'         => 'image',
                            'src'          => $academy->image,
                            'alt'          => htmlspecialchars($academy->name) . (!empty($academy->artist) ? ', ' . htmlspecialchars($academy->artist) : ''),
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($academy),
                            'image_credit' => htmlspecialchars($academy->image_credit),
                            'image_source' => htmlspecialchars($academy->image_source),
                        ])
                    </td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
