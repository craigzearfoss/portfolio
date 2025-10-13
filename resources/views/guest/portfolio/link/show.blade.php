@extends('guest.layouts.default', [
    'title' => $title ?? 'Link: ' . $link->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',      'href' => route('guest.homepage') ],
        [ 'name' => 'Portfolio', 'href' => route('guest.portfolio.index') ],
        [ 'name' => 'Links',     'href' => route('guest.portfolio.link.index') ],
        [ 'name' => $link->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.portfolio.course.index') ],
    ],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $link->name
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $link->featured
        ])

        @include('guest.components.show-row', [
            'name'  => 'summary',
            'value' => $link->summary
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'url',
            'href'    => $link->url,
            'target' => '_blank'
        ])

        @if(!empty($link->link))
            @include('guest.components.show-row-link', [
                'name'   => $link->link_name,
                'href'   => $link->link,
                'target' => '_blank'
            ])
        @endif

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($link->description ?? '')
        ])

        @if(!empty($link->image))

            @include('guest.components.show-row-image', [
                'name'     => 'image',
                'src'      => $link->image,
                'alt'      => $link->name . ', ' . $link->artist,
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($link->name . '-by-' . $link->artist, $link->image)
            ])

            @if(!empty($link->image_credit))
                @include('guest.components.show-row', [
                    'name'  => 'image credit',
                    'value' => $link->image_credit
                ])
            @endif

            @if(!empty($link->image_source))
                @include('guest.components.show-row', [
                    'name'  => 'image source',
                    'value' => $link->image_source
                ])
            @endif

        @endif

        @if(!empty($link->thumbnail))

            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $link->thumbnail,
                'alt'      => $link->name . ', ' . $link->artist,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($link->name . '-by-' . $link->artist, $link->thumbnail)
            ])

        @endif

    </div>

@endsection
