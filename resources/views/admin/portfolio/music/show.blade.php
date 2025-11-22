@extends('admin.layouts.default', [
    'title' => 'Music: ' . $music->name . (!empty($music->artist) ? ' - ' . $music->artist : ''),
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Music',           'href' => route('admin.portfolio.music.index') ],
        [ 'name' => $music->name . (!empty($music->artist) ? ' - ' . $music->artist : '') ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.music.edit', $music) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Music', 'href' => route('admin.portfolio.music.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.portfolio.music.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $music->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $music->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $music->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'artist',
            'value' => $music->artist
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $music->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'parent',
            'value' => !empty($music->parent)
                ? view('admin.components.link', [
                        'name' => $music->parent['name'],
                        'href' => route('admin.portfolio.music.show', $music->parent)
                    ])
                : ''
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $music->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $music->summary
        ])

        <div class="columns">
            <div class="column is-2"><strong>children</strong>:</div>
            <div class="column is-10 pl-0">
                @if(!empty($music->children))
                    <ol>
                        @foreach($music->children as $child)
                            <li>
                                @include('admin.components.link', [
                                    'name' => $child['name'],
                                    'href' => route('admin.portfolio.music.show', $child)
                                ])
                            </li>
                        @endforeach
                    </ol>
                @endif
            </div>
        </div>

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $music->featured
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'collection',
            'checked' => $music->collection
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'track',
            'checked' => $music->track
        ])

        @include('admin.components.show-row', [
            'name'  => 'label',
            'value' => $music->label
        ])

        @include('admin.components.show-row', [
            'name'  => 'catalog number',
            'value' => $music->catalog_number
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $music->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'release_date',
            'label' => 'release date',
            'value' => longDate($music->release_date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'embed',
            'value' => $music->embed
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'audio url',
            'href'   => $music->audio_url,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $music->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $music->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'   => 'link name',
            'value'  => $music->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($music->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $music->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $music->image,
            'alt'      => $music->name . ', ' . $music->artist,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($music->name . '-by-' . $music->artist, $music->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $music->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $music->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $music->thumbnail,
            'alt'      => $music->name . ', ' . $music->artist,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($music->name . '-by-' . $music->artist, $music->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $music->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $music->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $music->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $music->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $music->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($music->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($music->updated_at)
        ])

    </div>

@endsection
