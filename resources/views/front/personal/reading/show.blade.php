@extends('front.layouts.default', [
    'title' => $reading->title,
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('front.homepage') ],
        [ 'name' => 'Readings',   'href' => route('front.personal.reading.index') ],
        [ 'name' => $reading->title ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('front.personal.reading.index') ],
    ],
    'errors'  => $errors->any()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('front.components.show-row', [
            'name'  => 'title',
            'value' => $reading->title
        ])

        @include('front.components.show-row', [
            'name'  => 'author',
            'value' => $reading->author
        ])

        @include('front.components.show-row', [
            'name'  => 'publication year',
            'value' => $reading->publication_year
        ])

        @include('front.components.show-row', [
            'name'  => 'type',
            'value' => $reading->fiction ? 'fiction' : ($reading->nonfiction ? 'nonfiction': '')
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'paper',
            'checked' => $reading->paper
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'audio',
            'checked' => $reading->audio
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'wish list',
            'checked' => $reading->wishlist
        ])

        @if(!empty($reading->link))
            @include('front.components.link', [
                'name' => $reading->link_name,
                'href' =>
            ])
        @endif

        <?php /*
@include('front.components.show-row-image', [
'name'  => 'image',
'src'   => $reading->image,
'alt'   => $reading->name,
'width' => '300px',
])

@include('front.components.show-row', [
'name'  => 'image credit',
'value' => $reading->image_credit
])

@include('front.components.show-row', [
'name'  => 'image source',
'value' => $reading->image_source
])

@include('front.components.show-row-image', [
'name'  => 'thumbnail',
'src'   => $reading->image,
'alt'   => $reading->name,
'width' => '40px',
])
*/ ?>

    </div>

@endsection
