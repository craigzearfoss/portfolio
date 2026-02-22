@php
    $title    = $pageTitle ?? 'Award: ' . $award->name . (!empty($award->year) ? ' - ' . $award->year : '');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Award',      'href' => route('guest.portfolio.award.index', $owner) ],
        [ 'name' => $award->name ],
    ];

    // set navigation buttons
    $buttons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.award.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $award->disclaimer ])

    <div class="show-container p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $award->name
        ])

        @if(!empty($award->category))
            @include('guest.components.show-row', [
                'name'  => 'category',
                'value' => $award->category
            ])
        @endif

        @if(!empty($award->category))
            @include('guest.components.show-row', [
                'name'  => 'nominated_work',
                'value' => $award->nominated_work
            ])
        @endif

        @if(!empty($award->summary))
            @include('guest.components.show-row', [
                'name'  => 'summary',
                'value' => $award->summary
            ])
        @endif

        @if(!empty($award->year))
            @include('guest.components.show-row', [
                'name'  => 'year',
                'value' => $award->year
            ])
        @endif

        @if(!empty($award->received))
            @include('guest.components.show-row', [
                'name'  => 'date received',
                'value' => $award->received
            ])
        @endif

        @if(!empty($award->organization))
            @include('guest.components.show-row', [
                'name'  => 'organization',
                'value' => $award->organization
            ])
        @endif

        @if(!empty($award->link))
            @include('guest.components.show-row-link', [
                'name'   => !empty($award->link_name) ? $award->link_name : 'link',
                'href'   => $award->link,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($award->description))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => nl2br($award->description)
            ])
        @endif

        @if(!empty($award->image))
            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $award->image,
                'alt'          => $award->name . ', ' . (!empty($award->year) ? ' - ' . $award->year : ''),
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($award->name, $award->image),
                'image_credit' => $award->image_credit,
                'image_source' => $award->image_source,
            ])
        @endif

        @if(!empty($award->thumbnail))
            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $award->thumbnail,
                'alt'      => $award->name . ', ' . (!empty($award->year) ? ' - ' . $award->year : '') . ' thumbnail',
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug(
                    $award->name . (!empty($award->year) ? ' - ' . $award->year : '') . '-thumbnail',
                    $award->thumbnail
                )
            ])
        @endif

    </div>

@endsection
