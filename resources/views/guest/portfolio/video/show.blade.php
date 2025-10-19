@extends('guest.layouts.default', [
    'title' => $title ?? 'Video: ' . $video->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',              'href' => route('guest.homepage') ],
        [ 'name' => $video->owner->name, 'href' => route('guest.user.index', $admin)],
        [ 'name' => 'Portfolio',         'href' => route('guest.user.portfolio.index', $admin) ],
        [ 'name' => 'Videos',            'href' => route('guest.user.portfolio.video.index', $admin) ],
        [ 'name' => $video->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.user.portfolio.video.index', $admin) ],
    ],
    'errorMessages' => $errors->messages()  ?? [],
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
            @include('guest.components.show-row', [
                'name'  => 'parent',
                'value' => !empty($video->parent)
                    ? view('guest.components.link', [
                            'name' => $video->parent['name'],
                            'href' => route('guest.user.portfolio.video.show', [$admin, $video->parent->slug])
                        ])
                    : ''
            ])
        @endif

        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $video->featured
        ])

        @include('guest.components.show-row', [
            'name'  => 'summary',
            'value' => $video->summary
        ])

        @if(!empty($video->children))
            <div class="columns">
                <div class="column is-2"><strong>children</strong>:</div>
                <div class="column is-10 pl-0">
                    <ol>
                        @foreach($video->children as $child)
                            <li>
                                @include('guest.components.link', [
                                    'name' => $child['name'],
                                    'href' => route('guest.user.portfolio.video.show', [$admin, $child->slug])
                                ])
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        @endif

        @include('guest.components.show-row-checkbox', [
            'name'    => 'full episode',
            'checked' => $video->full_episode
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'clip',
            'checked' => $video->clip
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'public access',
            'checked' => $video->public_access
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'source recording',
            'checked' => $video->source_recording
        ])

        @include('guest.components.show-row', [
            'name'  => 'date',
            'value' => longDate($video->date)
        ])

        @include('guest.components.show-row', [
            'name'  => 'year',
            'value' => $video->year
        ])

        @include('guest.components.show-row', [
            'name'  => 'company',
            'value' => $video->company
        ])

        @include('guest.components.show-row', [
            'name'  => 'credit',
            'value' => $video->credit
        ])

        @include('guest.components.show-row', [
            'name'  => 'show',
            'value' => $video->show
        ])

        @include('guest.components.show-row', [
            'name'  => 'location',
            'value' => $video->location
        ])

        @include('guest.components.show-row', [
            'name'   => 'embed',
            'value'  => $video->embed,
        ])

        @include('guest.components.show-row', [
            'name'  => 'video url',
            'value' => $video->video_url,
        ])

        @if(!empty($video->link))
            @include('guest.components.show-row-link', [
                'name'   => $video->link_name,
                'href'   => $video->link,
                'target' => '_blank'
            ])
        @endif

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($video->description ?? '')
        ])

        @if(!empty($video->image))

            @include('guest.components.show-row-image', [
                'name'     => 'image',
                'src'      => $video->image,
                'alt'      => $video->name . ', ' . $video->artist,
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($video->name . '-by-' . $video->artist, $video->image)
            ])

            @if(!empty($video->image_credit))
                @include('guest.components.show-row', [
                    'name'  => 'image credit',
                    'value' => $video->image_credit
                ])
            @endif

            @if(!empty($video->image_source))
                @include('guest.components.show-row', [
                    'name'  => 'image source',
                    'value' => $video->image_source
                ])
            @endif

        @endif

        @if(!empty($video->thumbnail))

            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $video->thumbnail,
                'alt'      => $video->name . ', ' . $video->artist,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($video->name . '-by-' . $video->artist, $video->thumbnail)
            ])

        @endif

    </div>

@endsection
