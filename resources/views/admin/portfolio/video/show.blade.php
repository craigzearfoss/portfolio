@php
    $buttons = [];
    if (canUpdate($video)) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.video.edit', $video) ];
    }
    if (canCreate($video)) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Video', 'href' => route('admin.portfolio.video.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.portfolio.video.index') ];
@endphp
@extends('admin.layouts.default', [
    'title' => 'Video: ' . $video->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Video',           'href' => route('admin.portfolio.video.index') ],
        [ 'name' => $video->name ],
    ],
    'buttons' => $buttons,
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
                'value' => $video->owner->username ?? ''
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
                        'name' => htmlspecialchars($video->parent->name),
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
            'value' => htmlspecialchars($video->company)
        ])

        @include('admin.components.show-row', [
            'name'  => 'credit',
            'value' => htmlspecialchars($video->credit)
        ])

        @include('admin.components.show-row', [
            'name'  => 'show',
            'value' => htmlspecialchars($video->show)
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => htmlspecialchars($video->location)
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
            'value' => nl2br(htmlspecialchars($video->notes))
        ])

        @if(!empty($video->link))
            @include('admin.components.show-row-link', [
                'name'   => $video->link_name,
                'href'   => $video->link,
                'target' => '_blank'
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($video->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $video->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $video,
            'download' => true,
            'external' => true,
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
