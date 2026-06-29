@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $academy          = $academy ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? 'Academy: ' . $academy->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Academies',  'href' => route('guest.portfolio.academy.index', $owner) ],
            [ 'name' => $academy->name ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.academy.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $academy->disclaimer ])

    <div class="show-container p-4">

        <table class="table guest-resource-table is-striped is-bordered" style="width: 40rem;">
            <tbody>

            @if (!empty($academy->name))
                <tr>
                    <th>name:</th>
                    <td>{{ $academy->name }}</td>
                </tr>
            @endif

            @if (!empty($academy->category))
                <tr>
                    <th>category:</th>
                    <td>{{ $academy->category }}</td>
                </tr>
            @endif

            @if (!empty($academy->nominated_work))
                <tr>
                    <th>nominated work:</th>
                    <td>{{ $academy->nominated_work }}</td>
                </tr>
            @endif

            @if (!empty($academy->summary))
                <tr>
                    <th>summary:</th>
                    <td>{!! $academy->summary !!}</td>
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
                    <td>{{ $academy->organization }}</td>
                </tr>
            @endif

            @if (!empty($academy->link))
                <tr>
                    <th>{{ !empty($academy->link_name) ? $academy->link_name : 'link' }}:</th>
                    <td>
                        {{ $academy->link }}
                        @include('guest.components.link-icon', [
                            'title'  => 'open link in new window',
                            'href'   => $academy->link,
                            'icon'   => 'fa-external-link',
                            'border' => false,
                            'target' => '_blank',
                            'style'  => [ 'margin-top: -4px' ]
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
                            'alt'          => $academy->name . (!empty($academy->artist) ? ', ' . $academy->artist : ''),
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($academy),
                            'image_credit' => $academy->image_credit,
                            'image_source' => $academy->image_source,
                        ])
                    </td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
