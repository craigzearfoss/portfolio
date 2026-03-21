@php
    $title    = $pageTitle ?? 'Link: ' . $link->name;
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

        <table>
            <tbody>

            @if(!empty($link->name))
                <tr>
                    <th>name:</th>
                    <td>{{ $link->name }}</td>
                </tr>
            @endif

            @if(!empty($link->summary))
                <tr>
                    <th>summary:</th>
                    <td>{{ $link->summary }}</td>
                </tr>
            @endif

            @if(!empty($link->url))
                <tr>
                    <th>url:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => $link->url,
                            'href'   => $link->url,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($link->link))
                <tr>
                    <th>{{ !empty($link->link_name) ? $link->link_name : 'link' }}:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => $link->link,
                            'href'   => $link->link,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($link->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $link->description !!}</td>
                </tr>
            @endif

            @if(!empty($link->image))
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
