@extends('guest.layouts.default', [
    'title' => $title ?? 'Art: ' . $art->name . (!empty($art->artist) ? ' by ' . $art->artist : ''),
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.homepage') ],
        [ 'name' => $art->owner->name, 'href' => route('guest.user.index', $admin)],
        [ 'name' => 'Portfolio',       'href' => route('guest.user.portfolio.index', $admin) ],
        [ 'name' => 'Art',             'href' => route('guest.user.portfolio.art.index', $admin) ],
        [ 'name' => $art->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.user.portfolio.art.index', $admin) ],
    ],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $art->name
        ])

        @include('guest.components.show-row', [
            'name'  => 'artist',
            'value' => $art->artist
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $art->featured
        ])

        @include('guest.components.show-row', [
            'name'  => 'summary',
            'value' => $art->summary
        ])

        @include('guest.components.show-row', [
            'name'    => 'year',
            'checked' => $art->year
        ])

        @if(!empty($art->image_url))

            @include('guest.components.show-row-image', [
                'name'     => 'image',
                'src'      => $art->image_url,
                'width'    => '300px',
                'download' => true,
                'external' => true,
            ])

        @endif

        @if(!empty($art->link))
            @include('guest.components.show-row-link', [
                'name'   => $art->link_name,
                'href'   => $art->link,
                'target' => '_blank'
            ])
        @endif

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($art->description ?? '')
        ])

        @if(!empty($art->image))

            @include('guest.components.show-row-image', [
                'name'     => 'image',
                'src'      => $art->image,
                'alt'      => $art->name . ', ' . $art->artist,
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($art->name . '-by-' . $art->artist, $art->image)
            ])

            @if(!empty($art->image_credit))
                @include('guest.components.show-row', [
                    'name'  => 'image credit',
                    'value' => $art->image_credit
                ])
            @endif

            @if(!empty($art->image_source))
                @include('guest.components.show-row', [
                    'name'  => 'image source',
                    'value' => $art->image_source
                ])
            @endif

        @endif

        @if(!empty($art->thumbnail))

            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $art->thumbnail,
                'alt'      => $art->name . ', ' . $art->artist,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($art->name . '-by-' . $art->artist, $art->thumbnail)
            ])

        @endif

    </div>

@endsection
