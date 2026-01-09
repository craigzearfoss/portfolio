@extends('guest.layouts.default', [
    'title'         => $title ?? 'Photography: ' . $photo->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.admin.portfolio.show', $admin) ],
        [ 'name' => 'Award',      'href' => route('guest.admin.portfolio.photography.index', $admin) ],
        [ 'name' => $photo->name ],
    ],
    'buttons'       => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.admin.portfolio.photo.index', $admin) ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => $admin ?? null,
])

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $photography->disclaimer ?? null ])

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

        @if(!empty($photo->year))
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
                'name'   => $photo->link_name ?? 'link',
                'href'   => $photo->link,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($photo->description))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => nl2br($photo->description ?? '')
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
                'filename'     => getFileSlug($award->name, $photo->image),
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
