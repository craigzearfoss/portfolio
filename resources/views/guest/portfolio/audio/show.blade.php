@php
    $title    = $pageTitle ?? 'Audio: ' . $audio->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Audio',      'href' => route('guest.portfolio.audio.index', $owner) ],
            [ 'name' => $audio->name ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.audio.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $audio->disclaimer ])

    <div class="show-container card p-4">

        <table>
            <tbody>

            @if(!empty($audio->name))
                <tr>
                    <th>name:</th>
                    <td>{{ $audio->name }}</td>
                </tr>
            @endif

            @if(!empty($audio->parent))
                <tr>
                    <th>parent:</th>
                    <td>
                        @include('guest.components.link', [
                            'name' => $audio->parent->name,
                            'href' => route('guest.portfolio.audio.show', [$owner, $audio->parent->slug])
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($audio->summary))
                <tr>
                    <th>summary:</th>
                    <td>{!! $audio->summary !!}</td>
                </tr>
            @endif

            @if(!empty($audio->children) && (count($audio->children) > 0))
                <tr>
                    <th>children:</th>
                    <td>
                        <ol>
                            @foreach($audio->children as $child)
                                <li>
                                    @include('guest.components.link', [
                                        'name' => $child->name,
                                        'href' => route('guest.portfolio.audio.show', [$owner, $child->slug])
                                    ])
                                </li>
                            @endforeach
                        </ol>
                    </td>
                </tr>
            @endif

            @if(!empty($audio->full_episode))
                <th>clip:</th>
                <td>
                    @include('guest.components.checkmark', [
                        'checked' => $audio->full_episode
                    ])
                </td>
            @endif

            @if(!empty($audio->clip))
                <th>clip:</th>
                <td>
                    @include('guest.components.checkmark', [
                        'checked' => $audio->clip
                    ])
                </td>
            @endif

            @if(!empty($audio->podcast))
                <th>podcast:</th>
                <td>
                    @include('guest.components.checkmark', [
                        'checked' => $audio->podcast
                    ])
                </td>
            @endif

            @if(!empty($audio->source_recording))
                <th>source recording:</th>
                <td>
                    @include('guest.components.checkmark', [
                        'checked' => $audio->source_recording
                    ])
                </td>
            @endif

            @if(!empty($audio->date))
                <tr>
                    <th>date:</th>
                    <td>{{ longDate($audio->date) }}</td>
                </tr>
            @endif

            @if(!empty($audio->year))
                <tr>
                    <th>year:</th>
                    <td>{{ $audio->year }}</td>
                </tr>
            @endif

            @if(!empty($audio->company))
                <tr>
                    <th>company:</th>
                    <td>{{ $audio->company }}</td>
                </tr>
            @endif

            @if(!empty($audio->credit))
                <tr>
                    <th>credit:</th>
                    <td>{{ $audio->credit }}</td>
                </tr>
            @endif

            @if(!empty($audio->show))
                <tr>
                    <th>show:</th>
                    <td>{{ $audio->show }}</td>
                </tr>
            @endif

            @if(!empty($audio->location))
                <tr>
                    <th>location:</th>
                    <td>{{ $audio->location }}</td>
                </tr>
            @endif

            @if(!empty($audio->embed))
                <tr>
                    <th>embed:</th>
                    <td>{{ $audio->embed }}</td>
                </tr>
            @endif

            @if(!empty($audio->audio_url))
                <tr>
                    <th>audio url:</th>
                    <td>{{ $audio->audio_url }}</td>
                </tr>
            @endif

            @if(!empty($audio->link))
                <tr>
                    <th>{{ !empty($audio->link_name) ? $audio->link_name : 'link' }}:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => !empty($audio->link_name) ? $audio->link_name : 'link',
                            'href'   => $audio->link,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($audio->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $audio->description !!}</td>
                </tr>
            @endif

            @if(!empty($audio->image))
                <tr>
                    <td colspan="2">
                        @include('guest.components.image-credited', [
                            'name'         => 'image',
                            'src'          => $audio->image,
                            'alt'          => $audio->name,
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($audio),
                            'image_credit' => $audio->image_credit,
                            'image_source' => $audio->image_source,
                        ])
                    </td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
