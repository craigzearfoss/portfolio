@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $photo            = $photo ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('Photography: ' . htmlspecialchars($photo->name), htmlspecialchars($owner->name));
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Photography',                  'href' => route('guest.portfolio.art.index', $owner) ],
            [ 'name' => htmlspecialchars($photo->name) ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.photo.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => htmlspecialchars($photo->disclaimer) ])

    <div class="show-container p-4">

        <table>
            <tbody>

            @if (!empty($photo->name))
                <tr>
                    <th>name:</th>
                    <td>{!! htmlspecialchars($photo->name) !!}</td>
                </tr>
            @endif

            @if (!empty($photo->summary))
                <tr>
                    <th>summary:</th>
                    <td>{!! htmlspecialchars($photo->summary) !!}</td>
                </tr>
            @endif

            @if (!empty($photo->image))
                <tr>
                    <th>image:</th>
                    <td>
                        @include('guest.components.image-credited', [
                            'name'         => 'image',
                            'src'          => $photo->image,
                            'alt'          => htmlspecialchars($photo->name),
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($photo),
                            'image_credit' => htmlspecialchars($photo->image_credit),
                            'image_source' => htmlspecialchars($photo->image_source),
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($photo->photo_year))
                <tr>
                    <th>year:</th>
                    <td>{{ $photo->photo_year }}</td>
                </tr>
            @endif

            @if (!empty($photo->credit))
                <tr>
                    <th>credit:</th>
                    <td>{!! htmlspecialchars($photo->credit) !!}</td>
                </tr>
            @endif

            @if (!empty($photo->model))
                <tr>
                    <th>model:</th>
                    <td>{!! htmlspecialchars($photo->model) !!}</td>
                </tr>
            @endif

            @if (!empty($photo->location))
                <tr>
                    <th>location:</th>
                    <td>{!! htmlspecialchars($photo->location) !!}</td>
                </tr>
            @endif

            @if (!empty($photo->copyright))
                <tr>
                    <th>copyright:</th>
                    <td>{!! htmlspecialchars($photo->copyright) !!}</td>
                </tr>
            @endif

            @if (!empty($photo->link))
                <tr>
                    <th>{{ !empty($photo->link_name) ? htmlspecialchars($photo->link_name) : 'link' }}:</th>
                    <td>
                        @include('guest.components.link', [
                            'href'   => $photo->link,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($photo->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $photo->description !!}</td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
