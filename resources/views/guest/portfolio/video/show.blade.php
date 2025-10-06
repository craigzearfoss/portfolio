@extends('guest.layouts.default', [
    'title' => $title ?? 'Video: ' . $video->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('guest.homepage') ],
        [ 'name' => 'Portfolio', 'href' => route('guest.portfolio.index') ],
        [ 'name' => 'Videos',    'href' => route('guest.portfolio.video.index') ],
        [ 'name' => $video->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.personal.video.index') ],
    ],
    'errors'  => $errors->any()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $video->name
        ])

        @if(!empty($video->parent))
            @include('admin.components.show-row', [
                'name'  => 'parent',
                'value' => !empty($video->parent)
                    ? view('guest.components.link', [
                            'name' => $video->parent['name'],
                            'href' => route('guest.portfolio.video.show', $video->parent->slug)
                        ])
                    : ''
            ])
        @endif

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $video->featured
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
            'name'    => 'source footage',
            'checked' => $video->source_footage
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

        @if(!empty($video->link))
            @include('admin.components.show-row-link', [
                'name'   => 'link',
                'label'  => $video->link_name,
                'href'   => $video->link,
                'target' => '_blank'
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($video->description ?? '')
        ])

        @if(!empty($video->image))

            @include('admin.components.show-row-image', [
                'name'     => 'image',
                'src'      => $video->image,
                'alt'      => $video->name,
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($video->name, $video->image)
            ])

            @if(!empty($video->image_credit))
                @include('admin.components.show-row', [
                    'name'  => 'image credit',
                    'value' => $video->image_credit
                ])
            @endif

            @if(!empty($video->image_source))
                @include('admin.components.show-row', [
                    'name'  => 'image source',
                    'value' => $video->image_source
                ])
            @endif

        @endif

    </div>

@endsection
