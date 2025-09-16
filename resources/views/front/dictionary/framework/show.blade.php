@extends('front.layouts.default', [
    'title' => $framework->name . ' language',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary', 'url' => route('front.dictionary.index') ],
        [ 'name' => 'Frameworks', 'url' => route('front.dictionary.framework.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => Request::header('referer') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        @include('front.components.show-row', [
            'name'  => 'full name',
            'value' => $framework->full_name
        ])

        @include('front.components.show-row', [
            'name'  => 'name',
            'value' => $framework->name
        ])

        @include('front.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $framework->abbreviation
        ])

        @include('front.components.show-row', [
            'name'  => 'definition',
            'value' => $framework->definition
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $framework->open_source
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $framework->proprietary
        ])

        @include('front.components.show-row', [
            'name'  => 'owner',
            'value' => $framework->owner
        ])

        @include('front.components.show-row-link', [
            'name'   => 'wikipedia',
            'url'    => $framework->wikipedia,
            'target' => '_blank'
        ])

        @include('front.components.show-row-link', [
            'name'   => 'link',
            'url'    => $framework->link,
            'label'  => $framework->link_name,
            'target' => '_blank'
        ])

        @include('front.components.show-row', [
            'name'  => 'description',
            'value' => $framework->description
        ])

        @if(!empty($framework->image))

            @include('front.components.show-row-image', [
                'name'  => 'image',
                'src'   => $framework->image,
                'alt'   => $framework->name,
                'width' => '300px',
            ])

            @include('front.components.show-row', [
                'name'  => 'image credit',
                'value' => $framework->image_credit
            ])

            @include('front.components.show-row', [
                'name'  => 'image source',
                'value' => $framework->image_source
            ])

        @endif

    </div>

@endsection
