@extends('front.layouts.default', [
    'title' => $library->name . ' library',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary', 'url' => route('front.dictionary.index') ],
        [ 'name' => 'Libraries',  'url' => route('front.dictionary.library.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => referer('front.dictionary.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        @include('front.components.show-row', [
            'name'  => 'full name',
            'value' => $library->full_name
        ])

        @include('front.components.show-row', [
            'name'  => 'name',
            'value' => $library->name
        ])

        @include('front.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $library->abbreviation
        ])

        @include('front.components.show-row', [
            'name'  => 'definition',
            'value' => $library->definition
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $library->open_source
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $library->proprietary
        ])

        @include('front.components.show-row', [
            'name'  => 'owner',
            'value' => $library->owner
        ])

        @include('front.components.show-row-link', [
            'name'   => 'wikipedia',
            'url'    => $library->wikipedia,
            'target' => '_blank'
        ])

        @include('front.components.show-row-link', [
            'name'   => 'link',
            'url'    => $library->link,
            'label'  => $library->link_name,
            'target' => '_blank'
        ])

        @include('front.components.show-row', [
            'name'  => 'description',
            'value' => $library->description
        ])

        @if(!empty($library->image))

            @include('front.components.show-row-image', [
                'name'  => 'image',
                'src'   => $library->image,
                'alt'   => $library->name,
                'width' => '300px',
            ])

            @include('front.components.show-row', [
                'name'  => 'image credit',
                'value' => $library->image_credit
            ])

            @include('front.components.show-row', [
                'name'  => 'image source',
                'value' => $library->image_source
            ])

        @endif

    </div>

@endsection
