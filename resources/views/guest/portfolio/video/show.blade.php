@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $video            = $video ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('Video: ' . htmlspecialchars($video->name), htmlspecialchars($owner->name));
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Videos',                       'href' => route('guest.portfolio.video.index', $owner) ],
            [ 'name' => htmlspecialchars($video->name) ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.video.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => htmlspecialchars($video->disclaimer) ])

    <div class="show-container card p-4">

        <table>
            <tbody>

            @if (!empty($video->embed))
                <tr>
                    <td colspan="2">{!! $video->embed !!}</td>
                </tr>
            @endif

            @if (!empty($video->name))
                <tr>
                    <th>name:</th>
                    <td>{!! htmlspecialchars($video->name) !!}</td>
                </tr>
            @endif

            @if (!empty($music->parent))
                <tr>
                    <th>parent:</th>
                    <td>
                        @include('guest.components.link', [
                            'name' => htmlspecialchars($video->parent->name),
                            'href' => route('guest.portfolio.video.show', [$owner, $video->parent->slug])
                        ])
                    s</td>
                </tr>
            @endif

            @if (!empty($video->summary))
                <tr>
                    <th>summary:</th>
                    <td>{!! htmlspecialchars($video->summary) !!}</td>
                </tr>
            @endif

            @if (!empty($video->children) && (count($video->children) > 0))
                <tr>
                    <th>children:</th>
                    <td>
                        <ol>
                            @foreach ($video->children as $child)
                                <li>
                                    @include('guest.components.link', [
                                        'name' => htmlspecialchars($child->name),
                                        'href' => route('guest.portfolio.video.show', [$owner, $child->slug])
                                    ])
                                </li>
                            @endforeach
                        </ol>
                    </td>
                </tr>
            @endif

            @if (!empty($video->full_episode))
                <tr>
                    <th>full episode:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $video->full_episode
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($video->clip))
                <tr>
                    <th>clip:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $video->clip
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($video->public_access))
                <tr>
                    <th>public access:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $video->public_access
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($video->source_recording))
                <tr>
                    <th>source recording:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $video->source_recording
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($video->date))
                <tr>
                    <th>date:</th>
                    <td>{{ longDate($video->date) }}</td>
                </tr>
            @endif

            @if (!empty($video->video_year))
                <tr>
                    <th>year:</th>
                    <td>{{ $video->video_year }}</td>
                </tr>
            @endif

            @if (!empty($video->company))
                <tr>
                    <th>company:</th>
                    <td>{!! htmlspecialchars($video->company) !!}</td>
                </tr>
            @endif

            @if (!empty($video->credit))
                <tr>
                    <th>credit:</th>
                    <td>{!! htmlspecialchars($video->credit) !!}</td>
                </tr>
            @endif

            @if (!empty($video->show))
                <tr>
                    <th>show:</th>
                    <td>{!! htmlspecialchars($video->show) !!}</td>
                </tr>
            @endif

            @if (!empty($video->location))
                <tr>
                    <th>location:</th>
                    <td>{!! htmlspecialchars($video->location) !!}</td>
                </tr>
            @endif

            @if (!empty($video->video_url))
                <tr>
                    <th>video url:</th>
                    <td>
                        @include('guest.components.link', [
                            'href'   => $video->video_url,
                            'target' => 'blank'
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($video->link))
                <tr>
                    <th>{{ !empty($video->link_name) ? htmlspecialchars($video->link_name) : 'link' }}:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => htmlspecialchars($video->link_name),
                            'href'   => $video->link,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($video->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $video->description !!}</td>
                </tr>
            @endif

            @if (!empty($video->image))
                <tr>
                    <td colspan="2">
                        @include('guest.components.image-credited', [
                            'name'         => 'image',
                            'src'          => $video->image,
                            'alt'          => htmlspecialchars($video->name),
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($video),
                            'image_credit' => htmlspecialchars($video->image_credit),
                            'image_source' => htmlspecialchars($video->image_source),
                        ])
                    </td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
