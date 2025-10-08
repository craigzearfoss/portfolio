@extends('guest.layouts.default', [
    'title' => $title ?? 'Project: ' . $project->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',      'href' => route('guest.homepage') ],
        [ 'name' => 'Portfolio', 'href' => route('guest.portfolio.index') ],
        [ 'name' => 'Projects',  'href' => route('guest.portfolio.project.index') ],
        [ 'name' => $project->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.personal.project.index') ],
    ],
    'errors'  => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $project->name
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $project->featured
        ])

        @include('guest.components.show-row', [
            'name'  => 'year',
            'value' => $project->year
        ])

        @include('guest.components.show-row', [
            'name'  => 'language',
            'value' => $project->language
        ])

        @include('guest.components.show-row', [
            'name'  => 'language version',
            'value' => $project->language_version
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'repository',
            'label'  => $project->repository_name,
            'href'   => $project->repository_url,
            'target' => '_blank'
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
