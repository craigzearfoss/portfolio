@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $link             = $link ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('Link: ' . $link->name, $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Links',      'href' => route('guest.portfolio.link.index', $owner) ],
            [ 'name' => $link->name ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.link.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $link->disclaimer ])

    <div class="show-container card p-4">

        <table class="table guest-resource-table is-striped is-bordered" style="width: 40rem;">
            <tbody>

            @if (!empty($link->name))
                <tr>
                    <th>name:</th>
                    <td>{{ $link->name }}</td>
                </tr>
            @endif

            @if (!empty($link->summary))
                <tr>
                    <th>summary:</th>
                    <td>{!! $link->summary !!}</td>
                </tr>
            @endif

            @if (!empty($link->url))
                <tr>
                    <th>url:</th>
                    <td>
                        {{ $link->url }}
                        @include('guest.components.link-icon', [
                            'title'  => 'open link in new window',
                            'href'   => $link->url,
                            'icon'   => 'fa-external-link',
                            'border' => false,
                            'target' => '_blank',
                            'style'  => [ 'margin-top: -4px' ]
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($link->link))
                <tr>
                    <th>{{ !empty($link->link_name) ? $link->link_name : 'link' }}:</th>
                    <td>
                        {{ $link->link }}
                        @include('guest.components.link-icon', [
                            'title'  => 'open link in new window',
                            'href'   => $link->link,
                            'icon'   => 'fa-external-link',
                            'border' => false,
                            'target' => '_blank',
                            'style'  => [ 'margin-top: -4px' ]
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($link->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $link->description !!}</td>
                </tr>
            @endif

            @if (!empty($link->image))
                <tr>
                    <td colspan="2">
                        @include('guest.components.image-credited', [
                            'name'         => 'image',
                            'src'          => $link->image,
                            'alt'          => $link->name,
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($link),
                            'image_credit' => $link->image_credit,
                            'image_source' => $link->image_source,
                        ])
                    </td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
