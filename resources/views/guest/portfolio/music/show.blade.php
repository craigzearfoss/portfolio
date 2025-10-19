@extends('guest.layouts.default', [
    'title' => 'Music: ' . $music->name . (!empty($music->artist) ? ' - ' . $music->artist : ''),
    'breadcrumbs' => [
        [ 'name' => 'Home',              'href' => route('guest.homepage') ],
        [ 'name' => $music->owner->name, 'href' => route('guest.user.index', $admin)],
        [ 'name' => 'Portfolio',         'href' => route('guest.user.portfolio.index', $admin) ],
        [ 'name' => 'Music',             'href' => route('guest.user.portfolio.music.index', $admin) ],
        [ 'name' => $music->name . (!empty($music->artist) ? ' - ' . $music->artist : '') ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.user.portfolio.music.index', $admin) ],
    ],
    'errors'  => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $music->name
        ])

        @include('guest.components.show-row', [
            'name'  => 'artist',
            'value' => $music->artist
        ])

        @if(!empty($music->parent_id))
            @include('guest.components.show-row', [
                'name'  => 'parent',
                'value' => !empty($music->parent)
                    ? view('guest.components.link', [
                            'name' => $music->parent['name'],
                            'href' => route('guest.user.portfolio.music.show', [$admin, $music->parent->slug])
                        ])
                    : ''
            ])
        @endif

        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $music->featured
        ])

        @include('guest.components.show-row', [
            'name'  => 'summary',
            'value' => $music->summary
        ])

        @if(!empty($music->children))
            <div class="columns">
                <div class="column is-2"><strong>children</strong>:</div>
                <div class="column is-10 pl-0">
                    <ol>
                        @foreach($music->children as $child)
                            <li>
                                @include('guest.components.link', [
                                    'name' => $child['name'],
                                    'href' => route('guest.user.portfolio.music.show', [$admin, $child->slug])
                                ])
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        @endif

        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $music->featured
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'collection',
            'checked' => $music->collection
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'track',
            'checked' => $music->track
        ])

        @include('guest.components.show-row', [
            'name'  => 'label',
            'value' => $music->label
        ])

        @include('guest.components.show-row', [
            'name'  => 'catalog number',
            'value' => $music->catalog_number
        ])

        @include('guest.components.show-row', [
            'name'  => 'year',
            'value' => $music->year
        ])

        @include('guest.components.show-row', [
            'name'  => 'release date',
            'value' => longDate($music->release_date)
        ])

        @include('guest.components.show-row', [
            'name'  => 'embed',
            'value' => $music->embed
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'audio url',
            'href'   => $music->audio_url,
            'target' => '_blank'
        ])

        @if(!empty($music->link))
            @include('guest.components.show-row-link', [
                'name'   => $music->link_name,
                'href'   => $music->link,
                'target' => '_blank'
            ])
        @endif

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($music->description ?? '')
        ])

        @if(!empty($music->image))

            @include('guest.components.show-row-image', [
                'name'     => 'image',
                'src'      => $music->image,
                'alt'      => $music->name . ', ' . $music->artist,
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($music->name . '-by-' . $music->artist, $music->image)
            ])

            @if(!empty($music->image_credit))
                @include('guest.components.show-row', [
                    'name'  => 'image credit',
                    'value' => $music->image_credit
                ])
            @endif

            @if(!empty($music->image_source))
                @include('guest.components.show-row', [
                    'name'  => 'image source',
                    'value' => $music->image_source
                ])
            @endif

        @endif

        @if(!empty($music->thumbnail))

            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $music->thumbnail,
                'alt'      => $music->name . ', ' . $music->artist,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($music->name . '-by-' . $music->artist, $music->thumbnail)
            ])

        @endif

    </div>

@endsection
