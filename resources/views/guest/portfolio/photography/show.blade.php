@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? 'Photography: ' . $photo->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',        'href' => route('home') ],
        [ 'name' => 'Users',       'href' => route('home') ],
        [ 'name' => $owner->name,  'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',   'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Photography', 'href' => route('guest.portfolio.photography.index', $owner) ],
        [ 'name' => $photo->name ],
    ],
    'buttons'          => [
        view('guest.components.nav-button-back', ['href' => referer('guest.admin.portfolio.photography.index', $owner)])->render(),
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

    @include('guest.components.disclaimer', [ 'value' => $photo->disclaimer ])

    <div class="show-container p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $photo->name
        ])

        <?php /*
        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $photo->featured
        ])
        */ ?>

        @if(!empty($photo->summary))
            @include('guest.components.show-row', [
                'name'  => 'summary',
                'value' => $photo->summary
            ])
        @endif

        @if(!empty($photo->year))
            @include('guest.components.show-row', [
                'name'    => 'year',
                'value' => $photo->year
            ])
        @endif

        @if(empty($photo->credit))
            @include('guest.components.show-row', [
                'name'  => 'credit',
                'value' => $photo->credit
            ])
        @endif

        @if(!empty($photo->model))
            @include('guest.components.show-row', [
                'name'  => 'model',
                'value' => $photo->model
            ])
        @endif

        @if(!empty($photo->location))
            @include('guest.components.show-row', [
                'name'  => 'location',
                'value' => $photo->location
            ])
        @endif

        @if(!empty($photo->copyright))
            @include('guest.components.show-row', [
                'name'  => 'copyright',
                'value' => $photo->copyright
            ])
        @endif

        @if(!empty($photo->link))
            @include('guest.components.show-row-link', [
                'name'   => $photo->link_name,
                'href'   => $photo->link,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($photo->description))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => nl2br($photo->description)
            ])
        @endif

        @if(!empty($photo->photo_url))
            @include('guest.components.show-row-image', [
                'name'     => 'photo',
                'src'      => $photo->photo_url,
                'alt'      => $photo->name . ' photo',
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($photo->name . '-photo_url', $photo->photo_url)
            ])
        @endif

        @if(!empty($photo->image))
            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $photo->image,
                'alt'          => $photo->name,
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($photo->name, $photo->image),
                'image_credit' => $photo->image_credit,
                'image_source' => $photo->image_source,
            ])
        @endif

        @if(!empty($photo->thumbnail))
            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $photo->thumbnail,
                'alt'      => $photo->name . '-thumbnail',
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($photo->name . '-thumbnail', $photo->thumbnail)
            ])
        @endif

    </div>

@endsection
