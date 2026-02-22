@php
    $title = $pageTitle ?? 'Reading: ' . $reading->title . (!empty($reading->author) ? ' by ' . $reading->author : '');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Personal',   'href' => route('guest.personal.index', $owner) ],
        [ 'name' => 'Readings',   'href' => route('guest.personal.reading.index', $owner) ],
        [ 'name' => $reading->title . (!empty($reading->author) ? ' by ' . $reading->author : '') ],
    ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.personal.reading.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $reading->disclaimer ])

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'title',
            'value' => $reading->title
        ])

        @include('guest.components.show-row', [
            'name'  => 'author',
            'value' => $reading->author ?? ''
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
                'name'   => !empty($reading->link_name) ? $reading->link_name : 'link',
                'href'   => $reading->link,
                'target' => '_blank'
            ])
        @endif

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($reading->description)
        ])

        @if(!empty($reading->image))
            @include('guest.components.show-row-image', [
                'name'         => 'image',
                'src'          => $reading->image,
                'alt'          => $reading->title . (!empty($reading->author) ? ', ' . $reading->author : ''),
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename' => getFileSlug(
                    $reading->title . (!empty($reading->author) ? '-by-' . $reading->artist : ''),
                    $reading->image
                 ),
                'image_credit' => $reading->image_credit,
                'image_source' => $reading->image_source,
            ])
        @endif

        @if(!empty($reading->thumbnail))
            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $reading->thumbnail,
                'alt'      => $reading->title . (!empty($reading->author) ? ', ' . $reading->author : '') . ' thumbnail',
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug(
                    $reading->title . (!empty($reading->author) ? '-by-' . $reading->artist : '') . '-thumbnail',
                    $reading->image
                 ),
            ])
        @endif

    </div>

@endsection
