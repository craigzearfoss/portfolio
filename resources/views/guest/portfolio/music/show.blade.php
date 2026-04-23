@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $music            = $music ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('Music: ' . $music->name . (!empty($music->artist) ? ' - ' . $music->artist : ''), $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Music',      'href' => route('guest.portfolio.music.index', $owner) ],
            [ 'name' => $music->name . (!empty($music->artist) ? ' - ' . $music->artist : '') ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.music.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $music->disclaimer ])

    <div class="show-container card p-4">

        <table>
            <tbody>

            @if(!empty($music->embed))
                <tr>
                    <td colspan="2">{!! $music->embed !!}</td>
                </tr>
            @endif

            @if(!empty($music->name))
                <tr>
                    <th>name:</th>
                    <td>{{ $music->name }}</td>
                </tr>
            @endif

            @if(!empty($music->artist))
                <tr>
                    <th>artist:</th>
                    <td>{{ $music->artist }}</td>
                </tr>
            @endif

            @if(!empty($music->parent))
                <tr>
                    <th>parent:</th>
                    <td>
                        @include('guest.components.link', [
                            'name' => $music->parent->name,
                            'href' => route('guest.portfolio.music.show', [$owner, $music->parent->slug])
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($music->summary))
                <tr>
                    <th>summary:</th>
                    <td>{!! $music->summary !!}</td>
                </tr>
            @endif

            @if(!empty($music->children) && (count($music->children) > 0))
                <tr>
                    <th>children:</th>
                    <td>
                        <ol>
                            @foreach($music->children as $child)
                                <li>
                                    @include('guest.components.link', [
                                        'name' => $child->name,
                                        'href' => route('guest.portfolio.music.show', [$owner, $child->slug])
                                    ])
                                </li>
                            @endforeach
                        </ol>
                    </td>
                </tr>
            @endif

            @if(!empty($music->collection))
                <tr>
                    <th>collection:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $music->collection
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($music->track))
                <tr>
                    <th>track:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $music->track
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($music->label))
                <tr>
                    <th>label:</th>
                    <td>{{ $music->label }}</td>
                </tr>
            @endif

            @if(!empty($music->catalog_number))
                <tr>
                    <th>catalog number:</th>
                    <td>{{ $music->catalog_number }}</td>
                </tr>
            @endif

            @if(!empty($music->music_year))
                <tr>
                    <th>year:</th>
                    <td>{{ $music->music_year }}</td>
                </tr>
            @endif

            @if(!empty($music->release_date))
                <tr>
                    <th>release date:</th>
                    <td>{{ longDate($music->release_date) }}</td>
                </tr>
            @endif

            @if(!empty($music->audio_url))
                <tr>
                    <th>audio url:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => $music->audio_url,
                            'href'   => $music->audio_url,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($music->link))
                <tr>
                    <th>{{ !empty($music->link_name) ? $music->link_name : 'link' }}:</th>
                    <td>
                        @include('guest.components.link', [
                            'href'   => $music->link,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($music->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $music->description !!}</td>
                </tr>
            @endif

            @if(!empty($music->image))
                <tr>
                    <td colspan="2">
                        @include('guest.components.image-credited', [
                            'name'         => 'image',
                            'src'          => $music->image,
                            'alt'          => $music->name,
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($music),
                            'image_credit' => $music->image_credit,
                            'image_source' => $music->image_source,
                        ])
                    </td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
