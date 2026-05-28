@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $award            = $award ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('Award: ' . htmlspecialchars($award->name) . (!empty($award->award_year) ? ' - ' . htmlspecialchars($award->award_year) : ''), htmlspecialchars($owner->name));
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Award',                        'href' => route('guest.portfolio.award.index', $owner) ],
            [ 'name' => htmlspecialchars($award->name) ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.award.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => htmlspecialchars($award->disclaimer) ])

    <div class="show-container p-4">

        <table>
            <tbody>

            @if (!empty($award->name))
                <tr>
                    <th>name:</th>
                    <td>{!! htmlspecialchars($award->name) !!}</td>
                </tr>
            @endif

            @if (!empty($award->category))
                <tr>
                    <th>category:</th>
                    <td>{!! htmlspecialchars($award->category) !!}</td>
                </tr>
            @endif

            @if (!empty($award->nominated_work))
                <tr>
                    <th>nominated work:</th>
                    <td>{!! htmlspecialchars($award->nominated_work) !!}</td>
                </tr>
            @endif

            @if (!empty($award->summary))
                <tr>
                    <th>summary:</th>
                    <td>{!! htmlspecialchars($award->summary) !!}</td>
                </tr>
            @endif

            @if (!empty($award->award_year))
                <tr>
                    <th>year:</th>
                    <td>{{ $award->award_year }}</td>
                </tr>
            @endif

            @if (!empty($award->received))
                <tr>
                    <th>date received:</th>
                    <td>{{ $award->received }}</td>
                </tr>
            @endif

            @if (!empty($award->organization))
                <tr>
                    <th>organization:</th>
                    <td>{!! htmlspecialchars($award->organization) !!}</td>
                </tr>
            @endif

            @if (!empty($award->link))
                <tr>
                    <th>{{ !empty($award->link_name) ? $award->link_name : 'link' }}:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => !empty($award->link_name) ? htmlspecialchars($award->link_name) : 'link',
                            'href'   => $award->link,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($award->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $award->description !!}</td>
                </tr>
            @endif

            @if (!empty($award->image))
                <tr>
                    <td colspan="2">
                        @include('guest.components.image-credited', [
                            'name'         => 'image',
                            'src'          => $award->image,
                            'alt'          => htmlspecialchars($award->name) . (!empty($award->artist) ? ', ' . htmlspecialchars($award->artist) : ''),
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($award),
                            'image_credit' => htmlspecialchars($award->image_credit),
                            'image_source' => htmlspecialchars($award->image_source),
                        ])
                    </td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
