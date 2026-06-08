@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $art              = $art ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('Art: ' . htmlspecialchars($art->name) . (!empty($art->artist) ? ' by ' . htmlspecialchars($art->artist) : ''), htmlspecialchars($owner->name));
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Art',                          'href' => route('guest.portfolio.art.index', $owner) ],
            [ 'name' => htmlspecialchars($art->name) . (!empty(htmlspecialchars($art->artist)) ? ' by ' . htmlspecialchars($art->artist) : '') ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.art.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => htmlspecialchars($art->disclaimer) ])

    <div class="show-container p-4">

        <table>
            <tbody>

            @if (!empty($art->image))
                <tr>
                    <td colspan="2">
                        @include('guest.components.image-credited', [
                            'name'         => 'image',
                            'src'          => $art->image,
                            'alt'          => htmlspecialchars($art->name) . (!empty($art->artist) ? ', ' . htmlspecialchars($art->artist) : ''),
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($art),
                            'image_credit' => htmlspecialchars($art->image_credit),
                            'image_source' => htmlspecialchars($art->image_source),
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($art->name))
                <tr>
                    <th>name:</th>
                    <td>{{ htmlspecialchars($art->name) }}</td>
                </tr>
            @endif

            @if (!empty($art->artist))
                <tr>
                    <th>artist:</th>
                    <td>{{ htmlspecialchars($art->artist) }}</td>
                </tr>
            @endif

            @if (!empty($art->summary))
                <tr>
                    <th>summary:</th>
                    <td>{!! htmlspecialchars($art->summary) !!}</td>
                </tr>
            @endif

            @if (!empty($art->art_year))
                <tr>
                    <th>year:</th>
                    <td>{{ $art->art_year }}</td>
                </tr>
            @endif

            @if (!empty($art->link))
                <tr>
                    <th>{{ !empty($art->link_name) ? htmlspecialchars($art->link_name) : 'link' }}:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => !empty($art->link_name) ? htmlspecialchars($art->link_name) : 'link',
                            'href'   => $art->link,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($art->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $art->description !!}</td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
