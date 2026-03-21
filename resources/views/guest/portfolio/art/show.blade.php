@php
    $title    = $pageTitle ?? 'Art: ' . $art->name . (!empty($art->artist) ? ' by ' . $art->artist : '');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Art',        'href' => route('guest.portfolio.art.index', $owner) ],
            [ 'name' => $art->name . (!empty($art->artist) ? ' by ' . $art->artist : '') ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.art.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @if($owner->is_demo)
        @if($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
        @endif
    @endif

    <div class="show-container p-4">

        <table>
            <tbody>

            @if(!empty($art->name))
                <tr>
                    <th>name:</th>
                    <td>{{ $art->name }}</td>
                </tr>
            @endif

            @if(!empty($art->artist))
                <tr>
                    <th>artist:</th>
                    <td>{{ $art->artist }}</td>
                </tr>
            @endif

            @if(!empty($art->summary))
                <tr>
                    <th>summary:</th>
                    <td>{!! $art->summary !!}</td>
                </tr>
            @endif

            @if(!empty($art->year))
                <tr>
                    <th>year:</th>
                    <td>{{ $art->year }}</td>
                </tr>
            @endif

            @if(!empty($art->image))
                <tr>
                    <td colspan="2">
                        @include('guest.components.image-credited', [
                            'name'         => 'image',
                            'src'          => $art->image,
                            'alt'          => $art->name . (!empty($art->artist) ? ', ' . $art->artist : ''),
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($art),
                            'image_credit' => $art->image_credit,
                            'image_source' => $art->image_source,
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($art->link))
                <tr>
                    <th>{{ !empty($art->link_name) ? $art->link_name : 'link' }}:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => !empty($art->link_name) ? $art->link_name : 'link',
                            'href'   => $art->link,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($art->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $art->description !!}</td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
