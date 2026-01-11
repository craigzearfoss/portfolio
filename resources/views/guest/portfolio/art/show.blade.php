@extends('guest.layouts.default', [
    'title'         => $title ?? 'Art: ' . $art->name . (!empty($art->artist) ? ' by ' . $art->artist : ''),
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.admin.portfolio.show', $admin) ],
        [ 'name' => 'Art',        'href' => route('guest.admin.portfolio.art.index', $admin) ],
        [ 'name' => $art->name ],
    ],
    'buttons'       => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.admin.portfolio.art.index', $admin) ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => $admin ?? null,
])

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $art->disclaimer ?? null ])

    <div class="show-container p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($art->name ?? '')
        ])

        @include('guest.components.show-row', [
            'name'  => 'artist',
            'value' => htmlspecialchars($art->artist ?? '')
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
                'value' => $art->summary ?? ''
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
                'src'      => $art->image_url ?? '',
                'width'    => '300px',
                'download' => true,
                'external' => true,
            ])

        @endif

        @if(!empty($art->link))
            @include('guest.components.show-row-link', [
                'name'   => htmlspecialchars($art->link_name ?? 'link'),
                'href'   => htmlspecialchars($art->link ?? ''),
                'target' => '_blank'
            ])
        @endif

        @if(!empty($art->description))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => $art->description ?? ''
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
