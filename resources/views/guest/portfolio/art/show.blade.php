@extends('guest.layouts.default', [
    'title' => $title ?? 'Art: ' . $art->name . (!empty($art->artist) ? ' by ' . $art->artist : ''),
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('guest.homepage') ],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index') ],
        [ 'name' => 'Art',        'href' => route('guest.portfolio.art.index') ],
        [ 'name' => $art->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.portfolio.art.index') ],
    ],
    'errors'  => $errors->any()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $art->name
        ])

        @include('guest.components.show-row', [
            'name'  => 'artist',
            'value' => $art->artist
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $art->featured
        ])

        @include('guest.components.show-row', [
            'name'  => 'summary',
            'value' => $art->summary
        ])

        @include('guest.components.show-row', [
            'name'    => 'year',
            'checked' => $art->year
        ])

        @if(!empty($art->image_url))

            @include('guest.components.show-row-image', [
                'name'     => 'image',
                'src'      => $art->image_url,
                'width'    => '300px',
                'download' => true,
                'external' => true,
            ])

        @endif

    </div>

@endsection
