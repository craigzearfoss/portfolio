@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Links',      'href' => route('guest.portfolio.link.index', $owner) ],
        [ 'name' => $link->name ],
    ];

    // set navigation buttons
    $buttons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.link.index', $owner)])->render(),
    ];
@endphp
@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? 'Link: ' . $link->name,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $link->disclaimer ])

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $link->name
        ])

        <?php /*
        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $link->featured
        ])
        */ ?>

        @if(!empty($link->summary))
            @include('guest.components.show-row', [
                'name'  => 'summary',
                'value' => $link->summary
            ])
        @endif

        @if(!empty($link->url))
            @include('guest.components.show-row-link', [
                'name'   => 'url',
                'href'   => $link->url,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($link->link))
            @include('guest.components.show-row-link', [
                'name'   => !empty($link->link_name) ? $link->link_name : 'link',
                'href'   => $link->link,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($link->description))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => nl2br($link->description)
            ])
        @endif

        @if(!empty($link->image))
            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $link->image,
                'alt'          => $link->name,
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($link->name, $link->image),
                'image_credit' => $link->image_credit,
                'image_source' => $link->image_source,
            ])
        @endif

        @if(!empty($link->thumbnail))
            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $link->thumbnail,
                'alt'      => $link->name . '-thumbnail',
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($link->name . '-thumbnail', $link->thumbnail)
            ])
        @endif

    </div>

@endsection
