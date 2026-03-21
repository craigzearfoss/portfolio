@php
    $title    = $pageTitle ?? 'Photography: ' . $photo->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',        'href' => route('guest.index') ],
            [ 'name' => 'Candidates',  'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name,  'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',   'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Photography', 'href' => route('guest.portfolio.art.index', $owner) ],
            [ 'name' => $photo->name ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.photo.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $photo->disclaimer ])

    <div class="show-container p-4">

        <table>
            <tbody>

            @if(!empty($photo->name))
                <tr>
                    <th>name:</th>
                    <td>{{ $photo->name }}</td>
                </tr>
            @endif

            @if(!empty($photo->summary))
                <tr>
                    <th>summary:</th>
                    <td>{!! $photo->summary !!}</td>
                </tr>
            @endif

            @if(!empty($photo->image))
                <tr>
                    <th>image:</th>
                    <td>
                        @include('guest.components.image-credited', [
                            'name'         => 'image',
                            'src'          => $photo->image,
                            'alt'          => $photo->name,
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($photo),
                            'image_credit' => $photo->image_credit,
                            'image_source' => $photo->image_source,
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($photo->year))
                <tr>
                    <th>year:</th>
                    <td>{{ $photo->year }}</td>
                </tr>
            @endif

            @if(!empty($photo->credit))
                <tr>
                    <th>credit:</th>
                    <td>{{ $photo->credit }}</td>
                </tr>
            @endif

            @if(!empty($photo->model))
                <tr>
                    <th>model:</th>
                    <td>{{ $photo->model }}</td>
                </tr>
            @endif

            @if(!empty($photo->location))
                <tr>
                    <th>location:</th>
                    <td>{{ $photo->location }}</td>
                </tr>
            @endif

            @if(!empty($photo->copyright))
                <tr>
                    <th>copyright:</th>
                    <td>{{ $photo->copyright }}</td>
                </tr>
            @endif

            @if(!empty($photo->link))
                <tr>
                    <th>{{ !empty($photo->link_name) ? $photo->link_name : 'link' }}:</th>
                    <td>
                        @include('guest.components.link', [
                            'href'   => $photo->link,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($photo->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $photo->description !!}</td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
