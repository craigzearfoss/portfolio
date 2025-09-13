@extends('front.layouts.default', [
    'title' => $database->name . ' database',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary', 'url' => route('front.dictionary.index') ],
        [ 'name' => 'Databases',  'url' => route('front.dictionary.database.index') ],
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
            'value' => $database->full_name
        ])

        @include('front.components.show-row', [
            'name'  => 'name',
            'value' => $database->name
        ])

        @include('front.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $database->abbreviation
        ])

        @include('front.components.show-row', [
            'name'  => 'definition',
            'value' => $database->definition
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $database->open_source
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $database->proprietary
        ])

        @include('front.components.show-row', [
            'name'  => 'owner',
            'value' => $database->owner
        ])

        @include('front.components.show-row-link', [
            'name'   => 'wiki page',
            'url'    => $database->wikipedia,
            'target' => '_blank'
        ])

        @include('front.components.show-row-link', [
            'name'   => 'link',
            'url'    => $database->link,
            'label'  => $database->link_name,
            'target' => '_blank'
        ])

        @include('front.components.show-row', [
            'name'  => 'description',
            'value' => $database->description
        ])

        @if(!empty($database->image))

            @include('front.components.show-row-image', [
                'name'  => 'image',
                'value' => $database->image
            ])

            @include('front.components.show-row', [
                'name'  => 'image credit',
                'value' => $database->image_credit
            ])

            @include('front.components.show-row', [
                'name'  => 'image source',
                'value' => $database->image_source
            ])

        @endif

    </div>

@endsection
