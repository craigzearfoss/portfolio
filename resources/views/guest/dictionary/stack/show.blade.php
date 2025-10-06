@extends('guest.layouts.default', [
    'title' => $stack->name . ' stack',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('guest.homepage') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Stacks',     'href' => route('guest.dictionary.stack.index') ],
        [ 'name' => $stack->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.dictionary.index') ],
    ],
    'errors'  => $errors->any()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'full name',
            'value' => $stack->full_name
        ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $stack->name
        ])

        @include('guest.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $stack->abbreviation
        ])

        @include('guest.components.show-row', [
            'name'  => 'definition',
            'value' => $stack->definition
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $stack->open_source
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $stack->proprietary
        ])

        @include('guest.components.show-row', [
            'name'  => 'owner',
            'value' => $stack->owner
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $stack->wikipedia,
            'target' => '_blank'
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'link',
            'href'   => $stack->link,
            'label'  => $stack->link_name,
            'target' => '_blank'
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($stack->description ?? '')
        ])

        @if(!empty($stack->image))

            @include('guest.components.show-row-image', [
                'name'  => 'image',
                'src'   => $stack->image,
                'alt'   => $stack->name,
                'width' => '300px',
            ])

            @include('guest.components.show-row', [
                'name'  => 'image credit',
                'value' => $stack->image_credit
            ])

            @include('guest.components.show-row', [
                'name'  => 'image source',
                'value' => $stack->image_source
            ])

        @endif

    </div>

@endsection
