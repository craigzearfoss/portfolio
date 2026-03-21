@php
    $title    = $pageTitle ?? 'Video: ' . $video->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Videos',     'href' => route('guest.portfolio.video.index', $owner) ],
            [ 'name' => $video->name ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.video.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $video->disclaimer ])

    <div class="show-container card p-4">

        <table>
            <tbody>

            @if(!empty($video->name))
                <tr>
                    <th>name:</th>
                    <td>{{ $video->name }}</td>
                </tr>
            @endif

            @if(!empty($music->parent))
                <tr>
                    <th>parent:</th>
                    <td>
                        @include('guest.components.link', [
                            'name' => $video->parent->name,
                            'href' => route('guest.portfolio.video.show', [$owner, $video->parent->slug])
                        ])
                    s</td>
                </tr>
            @endif

            @if(!empty($video->summary))
                <tr>
                    <th>summary:</th>
                    <td>{{ $video->summary }}</td>
                </tr>
            @endif

            @if(!empty($video->children) && (count($video->children) > 0))
                <tr>
                    <th>children:</th>
                    <td>
                        <ol>
                            @foreach($video->children as $child)
                                <li>
                                    @include('guest.components.link', [
                                        'name' => $child->name,
                                        'href' => route('guest.portfolio.video.show', [$owner, $child->slug])
                                    ])
                                </li>
                            @endforeach
                        </ol>
                    </td>
                </tr>
            @endif

            @if(!empty($video->full_episode))
                <tr>
                    <th>full episode:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $video->full_episode
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($video->clip))
                <tr>
                    <th>clip:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $video->clip
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($video->public_access))
                <tr>
                    <th>public access:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $video->public_access
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($video->source_recording))
                <tr>
                    <th>source recording:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $video->source_recording
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($video->date))
                <tr>
                    <th>date:</th>
                    <td>{{ longDate($video->date) }}</td>
                </tr>
            @endif

            @if(!empty($video->year))
                <tr>
                    <th>year:</th>
                    <td>{{ $video->year }}</td>
                </tr>
            @endif

            @if(!empty($video->company))
                <tr>
                    <th>company:</th>
                    <td>{{ $video->company }}</td>
                </tr>
            @endif

            @if(!empty($video->credit))
                <tr>
                    <th>credit:</th>
                    <td>{{ $video->credit }}</td>
                </tr>
            @endif

            @if(!empty($video->show))
                <tr>
                    <th>show:</th>
                    <td>{{ $video->show }}</td>
                </tr>
            @endif

            @if(!empty($video->location))
                <tr>
                    <th>location:</th>
                    <td>{{ $video->location }}</td>
                </tr>
            @endif

            @if(!empty($video->embed))
                <tr>
                    <th>embed:</th>
                    <td>{!! $video->embed !!}</td>
                </tr>
            @endif

            @if(!empty($video->video_url))
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

            @if(!empty($video->link))
                <tr>
                    <th>{{ !empty($video->link_name) ? $video->link_name : 'link' }}:</th>
                    <td>
                        @include('guest.components.show-row-link', [
                            'name'   => $video->link_name,
                            'href'   => $video->link,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($video->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $video->description !!}</td>
                </tr>
            @endif

            @if(!empty($video->image))
                <tr>
                    <td colspan="2">
                        @include('guest.components.image-credited', [
                            'name'         => 'image',
                            'src'          => $video->image,
                            'alt'          => $video->name,
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($video),
                            'image_credit' => $video->image_credit,
                            'image_source' => $video->image_source,
                        ])
                    </td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
