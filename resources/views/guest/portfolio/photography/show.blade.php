@extends('guest.layouts.default', [
    'title' => $title ?? 'Photography: ' . $photo->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.admin.portfolio.show', $admin) ],
        [ 'name' => 'Award',      'href' => route('guest.admin.portfolio.photo.index', $admin) ],
        [ 'name' => $photo->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.admin.portfolio.photo.index', $admin) ],
    ],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $photo->name
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $photo->featured
        ])

        @include('guest.components.show-row', [
            'name'  => 'summary',
            'value' => $photo->summary
        ])

        @include('guest.components.show-row', [
            'name'    => 'year',
            'checked' => $photo->year
        ])

        @if(!empty($photo->model))
            @include('guest.components.show-row', [
                'name'    => 'model',
                'checked' => $photo->model
            ])
        @endphp

        @if(!empty($photo->location))
            @include('guest.components.show-row', [
                'name'    => 'location',
                'checked' => $photo->location
            ])
        @endphp

        @if(!empty($photo->copyright))
            @include('guest.components.show-row', [
                'name'    => 'copyright',
                'checked' => $photo->copyright
            ])
        @endphp

        @if(!empty($photo->link))
            @include('guest.components.show-row-link', [
                'name'   => $photo->link_name,
                'href'   => $photo->link,
                'target' => '_blank'
            ])
        @endif

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($photo->description ?? '')
        ])

        @if(!empty($photo->image))

            @include('guest.components.show-row-image', [
                'name'     => 'image',
                'src'      => $photo->image,
                'alt'      => $photo->name,
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($photo->name, $photo->image)
            ])

            @if(!empty($photo->image_credit))
                @include('guest.components.show-row', [
                    'name'  => 'image credit',
                    'value' => $photo->image_credit
                ])
            @endif

            @if(!empty($photo->image_source))
                @include('guest.components.show-row', [
                    'name'  => 'image source',
                    'value' => $photo->image_source
                ])
            @endif

        @endif

        @if(!empty($photo->thumbnail))

            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $photo->thumbnail,
                'alt'      => $photo->name,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($photo->name), $photo->thumbnail)
            ])

        @endif

    </div>

@endsection
