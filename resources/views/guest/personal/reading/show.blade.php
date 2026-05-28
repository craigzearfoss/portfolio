@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $reading          = $reading ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title = $pageTitle ?? filteredPageTitle('Reading: ' .  htmlspecialchars($reading->title) . (!empty($reading->author) ? ' by ' . htmlspecialchars($reading->author) : ''), htmlspecialchars($owner->name));
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Personal',                     'href' => route('guest.personal.index', $owner) ],
            [ 'name' => 'Readings',                     'href' => route('guest.personal.reading.index', $owner) ],
            [ 'name' => htmlspecialchars($reading->title) . (!empty($reading->author) ? ' by ' . htmlspecialchars($reading->author) : '') ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.personal.reading.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => htmlspecialchars($reading->disclaimer) ])

    <div class="show-container card p-4">

        <table>
            <tbody>

            @if (!empty($reading->title))
                <tr>
                    <th>title:</th>
                    <td>{!! htmlspecialchars($reading->title) !!}</td>
                </tr>
            @endif

            @if (!empty($reading->author))
                <tr>
                    <th>author:</th>
                    <td>{!! htmlspecialchars($reading->author_) !!}</td>
                </tr>
           @endif

            @if (!empty($reading->publication_year))
                <tr>
                    <th>year:</th>
                    <td>{{ $reading->publication_year }}</td>
                </tr>
            @endif

            <tr>
                <th>type:</th>
                <td>{{ $reading->fiction ? 'fiction' : ($reading->nonfiction ? 'nonfiction': '') }}</td>
            </tr>

            @if (!empty($reading->paper))
                <tr>
                    <th>paper:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'name'    => 'paper',
                            'checked' => $reading->paper
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($reading->audio))
                <tr>
                    <th>audio:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'name'    => 'audio',
                            'checked' => $reading->audio
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($reading->wishlist))
                <tr>
                    <th>wishlist:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'name'    => 'wishlist',
                            'checked' => $reading->wishlist
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($reading->link))
                <tr>
                    <th>{{ !empty($reading->link_name) ? $reading->link_name : 'link' }}:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => !empty($reading->link_name) ? htmlspecialchars($reading->link_name) : 'link',
                            'href'   => $reading->link,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($reading->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $reading->description !!}</td>
                </tr>
            @endif

            @if (!empty($reading->image))
                <tr>
                    <td colspan="2">
                        @include('guest.components.image-credited', [
                            'name'         => 'image',
                            'src'          => $reading->image,
                            'alt'          => htmlspecialchars($reading->name),
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($reading),
                            'image_credit' => htmlspecialchars($reading->image_credit),
                            'image_source' => htmlspecialchars($reading->image_source),
                        ])
                    </td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
