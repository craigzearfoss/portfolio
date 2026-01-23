@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? 'Art: ' . $art->name . (!empty($art->artist) ? ' by ' . $art->artist : ''),
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Users',      'href' => route('guest.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Art',        'href' => route('guest.portfolio.art.index', $owner) ],
        [ 'name' => $art->name ],
    ],
    'buttons'          => [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.art.index', $owner)])->render(),
    ],
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

    @include('guest.components.disclaimer', [ 'value' => $art->disclaimer ])

    <div class="show-container p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $art->name
        ])

        @include('guest.components.show-row', [
            'name'  => 'artist',
            'value' => $art->artist
        ])

        <?php /*
        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $art->featured
        ])
        */ ?>

        @if(!empty($art->summary))
            @include('guest.components.show-row', [
                'name'  => 'summary',
                'value' => $art->summary
            ])
        @endif

        @if(!empty($art->year))
            @include('guest.components.show-row', [
                'name'    => 'year',
                'value' => $art->year
            ])
        @endif

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
                'name'   => !empty($art->link_name) ? $art->link_name : 'link',
                'href'   => $art->link,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($art->description))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => nl2br($art->description)
            ])
        @endif

        @if(!empty($art->image))
            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $art->image,
                'alt'          => $art->name . (!empty($art->artist) ? ', ' . $art->artist : ''),
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug(
                    $art->name . (!empty($art->artist) ? '-by-' . $art->artist : ''),
                    $art->image
                 ),
                'image_credit' => $art->image_credit,
                'image_source' => $art->image_source,
            ])
        @endif

        @if(!empty($art->thumbnail))
            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $art->thumbnail,
                'alt'      => $art->name . (!empty($art->artist) ? ', ' . $art->artist : '') . ' thumbnail',
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename'     => getFileSlug(
                    $art->name . (!empty($art->artist) ? '-by-' . $art->artist : '') . '-thumbnail',
                    $art->thumbnail
                 ),
            ])
        @endif

    </div>

@endsection
