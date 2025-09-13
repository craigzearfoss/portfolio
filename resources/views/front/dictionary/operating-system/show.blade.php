@extends('front.layouts.default', [
    'title' => $operatingSystem->name . ' operating system',
    'breadcrumbs' => [
        [ 'name' => 'Home',              'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary',        'url' => route('front.dictionary.index') ],
        [ 'name' => 'Operating Systems', 'url' => route('front.dictionary.operating-system.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('front.dictionary.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        @include('front.components.show-row', [
            'name'  => 'full name',
            'value' => $operatingSystem->full_name
        ])

        @include('front.components.show-row', [
            'name'  => 'name',
            'value' => $operatingSystem->name
        ])

        @include('front.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $operatingSystem->abbreviation
        ])

        @include('front.components.show-row', [
            'name'  => 'definition',
            'value' => $operatingSystem->definition
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $operatingSystem->open_source
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $operatingSystem->proprietary
        ])

        @include('front.components.show-row', [
            'name'  => 'owner',
            'value' => $operatingSystem->owner
        ])

        @include('front.components.show-row-link', [
            'name'   => 'wiki page',
            'url'    => $operatingSystem->wikipedia,
            'target' => '_blank'
        ])

        @include('front.components.show-row-link', [
            'name'   => 'link',
            'url'    => $operatingSystem->link,
            'label'  => $operatingSystem->link_name,
            'target' => '_blank'
        ])

        @include('front.components.show-row', [
            'name'  => 'description',
            'value' => $operatingSystem->description
        ])

        @if(!empty($operatingSystem->image))

            @include('front.components.show-row-image', [
                'name'  => 'image',
                'value' => $operatingSystem->image
            ])

            @include('front.components.show-row', [
                'name'  => 'image credit',
                'value' => $operatingSystem->image_credit
            ])

            @include('front.components.show-row', [
                'name'  => 'image source',
                'value' => $operatingSystem->image_source
            ])

        @endif

    </div>

@endsection
