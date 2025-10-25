@extends('admin.layouts.default', [
    'title' => 'Video: ' . $video->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.homepage') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Video',           'href' => route('admin.portfolio.video.index') ],
        [ 'name' => $video->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.video.edit', $video) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Video', 'href' => route('admin.portfolio.video.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.portfolio.video.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $video->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $video->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $video->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $video->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'parent',
            'value' => !empty($video->parent)
                ? view('admin.components.link', [
                        'name' => $video->parent['name'],
                        'href' => route('admin.portfolio.video.show', $video->parent)
                    ])
                : ''
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $video->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $video->summary
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'full episode',
            'checked' => $video->full_episode
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'clip',
            'checked' => $video->clip
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public access',
            'checked' => $video->public_access
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'source recording',
            'checked' => $video->source_recording
        ])

        @include('admin.components.show-row', [
            'name'  => 'date',
            'value' => longDate($video->date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $video->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'company',
            'value' => $video->company
        ])

        @include('admin.components.show-row', [
            'name'  => 'credit',
            'value' => $video->credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'show',
            'value' => $video->show
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => $video->location
        ])

        @include('admin.components.show-row', [
            'name'   => 'embed',
            'value'  => $video->embed,
        ])

        @include('admin.components.show-row', [
            'name'  => 'video url',
            'value' => $video->video_url,
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $video->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $video->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $video->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($video->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $video->image,
            'alt'      => $video->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($video->name, $video->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $video->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $video->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $video->thumbnail,
            'alt'      => $video->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($video->name, $video->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $video->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $video->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $video->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $video->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $video->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($video->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($video->updated_at)
        ])

    </div>

@endsection
