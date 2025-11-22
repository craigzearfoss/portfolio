@extends('admin.layouts.default', [
    'title' => 'Audio: ' . $audio->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Audio',           'href' => route('admin.portfolio.audio.index') ],
        [ 'name' => $audio->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.audio.edit', $audio) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Audio', 'href' => route('admin.portfolio.audio.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.portfolio.audio.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $audio->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $audio->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $audio->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $audio->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'parent',
            'value' => !empty($audio->parent)
                ? view('admin.components.link', [
                        'name' => $audio->parent['name'],
                        'href' => route('admin.portfolio.audio.show', $audio->parent)
                    ])
                : ''
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $audio->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $audio->summary
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'full episode',
            'checked' => $audio->full_episode
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'clip',
            'checked' => $audio->clip
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'podcast',
            'checked' => $audio->podcast
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'source recording',
            'checked' => $audio->source_recording
        ])

        @include('admin.components.show-row', [
            'name'  => 'date',
            'value' => longDate($audio->date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $audio->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'company',
            'value' => $audio->company
        ])

        @include('admin.components.show-row', [
            'name'  => 'credit',
            'value' => $audio->credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'show',
            'value' => $audio->show
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => $audio->location
        ])

        @include('admin.components.show-row', [
            'name'   => 'embed',
            'value'  => $audio->embed,
        ])

        @include('admin.components.show-row', [
            'name'  => 'audio url',
            'value' => $audio->audio_url,
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $audio->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $audio->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $audio->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($audio->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $audio->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $audio->image,
            'alt'      => $audio->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($audio->name, $audio->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $audio->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $audio->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $audio->thumbnail,
            'alt'      => $audio->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($audio->name, $audio->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $audio->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $audio->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $audio->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $audio->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $audio->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($audio->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($audio->updated_at)
        ])

    </div>

@endsection
