@extends('guest.layouts.default', [
    'title' => $title ?? 'Reading: ' . $reading->title . (!empty($reading->author) ? ' by ' . $reading->author : ''),
    'breadcrumbs' => [
        [ 'name' => 'Home',                'href' => route('system.homepage') ],
        [ 'name' => $reading->owner->name, 'href' => route('guest.user.index', $admin)],
        [ 'name' => 'Personal',            'href' => route('guest.user.personal.index', $admin) ],
        [ 'name' => 'Readings',            'href' => route('guest.user.personal.reading.index', $admin) ],
        [ 'name' => $reading->title . (!empty($reading->author) ? ' by ' . $reading->author : '') ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.user.personal.reading.index', $reading->owner) ],
    ],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'title',
            'value' => $reading->title
        ])

        @include('guest.components.show-row', [
            'name'  => 'author',
            'value' => $reading->author
        ])

        @include('guest.components.show-row', [
            'name'  => 'publication year',
            'value' => $reading->publication_year
        ])

        @include('guest.components.show-row', [
            'name'  => 'type',
            'value' => $reading->fiction ? 'fiction' : ($reading->nonfiction ? 'nonfiction': '')
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'paper',
            'checked' => $reading->paper
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'audio',
            'checked' => $reading->audio
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'wish list',
            'checked' => $reading->wishlist
        ])

        @if(!empty($reading->link))
            @include('guest.components.show-row-link', [
                'name'   => $reading->link_name,
                'href'   => $reading->link,
                'target' => '_blank'
            ])
        @endif

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($reading->description ?? '')
        ])

        @if(!empty($reading->image))

            @include('guest.components.show-row-image', [
                'name'     => 'image',
                'src'      => $reading->image,
                'alt'      => $reading->name . ', ' . $reading->artist,
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($reading->name . '-by-' . $reading->artist, $reading->image)
            ])

            @if(!empty($reading->image_credit))
                @include('guest.components.show-row', [
                    'name'  => 'image credit',
                    'value' => $reading->image_credit
                ])
            @endif

            @if(!empty($reading->image_source))
                @include('guest.components.show-row', [
                    'name'  => 'image source',
                    'value' => $reading->image_source
                ])
            @endif

        @endif

        @if(!empty($reading->thumbnail))

            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $reading->thumbnail,
                'alt'      => $reading->name . ', ' . $reading->artist,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($reading->name . '-by-' . $reading->artist, $reading->thumbnail)
            ])

        @endif

    </div>

@endsection
