@extends('guest.layouts.default', [
    'title'         => $title ?? 'Video: ' . $video->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.admin.portfolio.show', $admin) ],
        [ 'name' => 'Videos',     'href' => route('guest.admin.portfolio.video.index', $admin) ],
        [ 'name' => $video->name ],
    ],
    'buttons'       => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.admin.portfolio.video.index', $admin) ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => null,
])

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $video->disclaimer ?? null ])

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
                            'href' => route('guest.admin.portfolio.video.show', [$admin, $video->parent->slug])
                        ])
                    : ''
            ])
        @endif

        <?php /*
        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $video->featured
        ])
        */ ?>

        @if(!empty($video->summary))
            @include('guest.components.show-row', [
                'name'  => 'summary',
                'value' => $video->summary
            ])
        @endif

        @if($video->children->count() > 0)
            <div class="columns">
                <div class="column is-2"><strong>children</strong>:</div>
                <div class="column is-10 pl-0">
                    <ol>
                        @foreach($video->children as $child)
                            <li>
                                @include('guest.components.link', [
                                    'name' => $child['name'],
                                    'href' => route('guest.admin.portfolio.video.show', [$admin, $child->slug])
                                ])
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        @endif

        @if(!empty($video->full_episode))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'full episode',
                'checked' => $video->full_episode
            ])
        @endif

        @if(!empty($video->clip))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'clip',
                'checked' => $video->clip
            ])
        @endif

        @if(!empty($video->public_access))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'public access',
                'checked' => $video->public_access
            ])
        @endif

        @if(!empty($video->source_recording))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'source recording',
                'checked' => $video->source_recording
            ])
        @endif

        @if(!empty($video->date))
            @include('guest.components.show-row', [
                'name'  => 'date',
                'value' => longDate($video->date)
            ])
        @endif

        @if(!empty($video->year))
            @include('guest.components.show-row', [
                'name'  => 'year',
                'value' => $video->year
            ])
        @endif

        @if(!empty($video->company))
            @include('guest.components.show-row', [
                'name'  => 'company',
                'value' => $video->company
            ])
        @endif

        @if(!empty($video->credit))
            @include('guest.components.show-row', [
                'name'  => 'credit',
                'value' => $video->credit
            ])
        @endif

        @if(!empty($video->show))
            @include('guest.components.show-row', [
                'name'  => 'show',
                'value' => $video->show
            ])
        @endif

        @if(!empty($video->location))
            @include('guest.components.show-row', [
                'name'  => 'location',
                'value' => $video->location
            ])
        @endif

        @if(!empty($video->embed))
            @include('guest.components.show-row', [
                'name'   => 'embed',
                'value'  => $video->embed,
            ])
        @endif

        @if(!empty($video->video_url))
            @include('guest.components.show-row', [
                'name'  => 'video url',
                'value' => $video->video_url,
            ])
        @endif

        @if(!empty($video->link))
            @include('guest.components.show-row-link', [
                'name'   => $video->link_name ?? 'link',
                'href'   => $video->link,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($video->description ))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => $video->description
            ])
        @endif

        @if(!empty($video->image))
            @include('guest.components.show-row-image', [
                'name'         => 'image',
                'src'          => $video->image,
                'alt'          => $video->name,
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($video->name, $video->image),
                'image_credit' => $video->image_credit,
                'image_source' => $video->image_source,
            ])
        @endif

        @if(!empty($video->thumbnail))
            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $video->thumbnail . ' thumbnail',
                'alt'      => $video->name,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($video->name . '-thumbnail', $video->thumbnail)
            ])
        @endif

    </div>

@endsection
