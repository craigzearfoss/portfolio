@php
    $title = $pageTitle ?? 'Publication: ' . $publication->title;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',   'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name,   'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Publications', 'href' => route('guest.portfolio.publication.index', $owner) ],
            [ 'name' => $publication->title ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.publication.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $publication->disclaimer ])

    <div class="show-container card p-4">

        <table>
            <tbody>

            @if(!empty($publication->title))
                <tr>
                    <th>name:</th>
                    <td>{{ $publication->title }}</td>
                </tr>
            @endif

            @if(!empty($publication->parent))
                <tr>
                    <th>parent:</th>
                    <td>
                        @include('guest.components.link', [
                            'name' => $publication->parent->title,
                            'href' => route('guest.portfolio.publication.show', $owner, $publication->parent->slug)
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($publication->summary))
                <tr>
                    <th>summary:</th>
                    <td>{{ $publication->summary }}</td>
                </tr>
            @endif

            @if(!empty($publication->children) && (count($publication->children) > 0))
                <tr>
                    <th>children:</th>
                    <td>
                        <ol>
                            @foreach($publication->children as $child)
                                <li>
                                    @include('guest.components.link', [
                                        'name' => $child->name,
                                        'href' => route('guest.portfolio.publication.show', [$owner, $child->slug])
                                    ])
                                </li>
                            @endforeach
                        </ol>
                    </td>
                </tr>
            @endif

            @if(!empty($publication->publication_name))
                <tr>
                    <th>publication name:</th>
                    <td>{{ $publication->publication_name }}</td>
                </tr>
            @endif

            @if(!empty($publication->publisher))
                <tr>
                    <th>publisher:</th>
                    <td>{{ $publication->publisher }}</td>
                </tr>
            @endif

            @if(!empty($publication->publication_date))
                <tr>
                    <th>publication date:</th>
                    <td>{{ longDate($publication->publication_date) }}</td>
                </tr>
            @endif

            @if(!empty($publication->publication_year))
                <tr>
                    <th>year:</th>
                    <td>{{ $publication->publication_year }}</td>
                </tr>
            @endif

            @if(!empty($publication->credit))
                <tr>
                    <th>credit:</th>
                    <td>{{ $publication->credit }}</td>
                </tr>
            @endif

            @if(!empty($publication->freelance))
                <tr>
                    <th>freelance:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $publication->freelance
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($publication->fiction))
                <tr>
                    <th>fiction:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $publication->fiction
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($publication->nonfiction))
                <tr>
                    <th>nonfiction:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $publication->nonfiction
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($publication->technical))
                <tr>
                    <th>technical:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $publication->technical
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($publication->research))
                <tr>
                    <th>research:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $publication->research
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($publication->poetry))
                <tr>
                    <th>poetry:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $publication->poetry
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($publication->online))
                <tr>
                    <th>online:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $publication->online
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($publication->novel))
                <tr>
                    <th>novel:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $publication->novel
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($publication->book))
                <tr>
                    <th>book:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $publication->book
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($publication->textbook))
                <tr>
                    <th>textbook:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $publication->textbook
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($publication->story))
                <tr>
                    <th>story:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $publication->story
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($publication->article))
                <tr>
                    <th>article:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $publication->article
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($publication->pamphlet))
                <tr>
                    <th>pamphlet:</th>
                    <td>
                        @include('guest.components.checkmark', [
                            'checked' => $publication->pamphlet
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($certificate->publication_url))
                <tr>
                    <th>publication url:</th>
                    <td>
                        @include('guest.components.link', [
                            'href'   => $publication->publication_url,
                            'target' => '_blank'
                        ])
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($publication->link))
                <tr>
                    <th>{{ !empty($publication->link_name) ? $publication->link_name : 'link' }}:</th>
                    <td>
                        @include('guest.components.link', [
                            'href'   => $publication->link,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($publication->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $publication->description !!}</td>
                </tr>
            @endif

            @if(!empty($publication->image))
                <tr>
                    <td colspan="2">
                        @include('guest.components.image-credited', [
                            'name'         => 'image',
                            'src'          => $publication->image,
                            'alt'          => $publication->name . (!empty($publication->artist) ? ', ' . $publication->artist : ''),
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($publication),
                            'image_credit' => $publication->image_credit,
                            'image_source' => $publication->image_source,
                        ])
                    </td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
