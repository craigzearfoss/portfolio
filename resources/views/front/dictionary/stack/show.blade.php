@extends('front.layouts.default', [
    'title' => $stack->name . ' stack',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary', 'url' => route('front.dictionary.index') ],
        [ 'name' => 'Stacks',     'url' => route('front.dictionary.stack.index') ],
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
            'value' => $stack->full_name
        ])

        @include('front.components.show-row', [
            'name'  => 'name',
            'value' => $stack->name
        ])

        @include('front.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $stack->abbreviation
        ])

        @include('front.components.show-row', [
            'name'  => 'definition',
            'value' => $stack->definition
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $stack->open_source
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $stack->proprietary
        ])

        @include('front.components.show-row', [
            'name'  => 'owner',
            'value' => $stack->owner
        ])

        @include('front.components.show-row-link', [
            'name'   => 'wikipedia',
            'url'    => $stack->wikipedia,
            'target' => '_blank'
        ])

        @include('front.components.show-row-link', [
            'name'   => 'link',
            'url'    => $stack->link,
            'label'  => $stack->link_name,
            'target' => '_blank'
        ])

        @include('front.components.show-row', [
            'name'  => 'description',
            'value' => $stack->description
        ])

        @if(!empty($stack->image))

            @include('front.components.show-row-image', [
                'name'  => 'image',
                'src'   => $stack->image,
                'alt'   => $stack->name,
                'width' => '300px',
            ])

            @include('front.components.show-row', [
                'name'  => 'image credit',
                'value' => $stack->image_credit
            ])

            @include('front.components.show-row', [
                'name'  => 'image source',
                'value' => $stack->image_source
            ])

        @endif

    </div>

@endsection
