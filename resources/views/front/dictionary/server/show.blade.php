@extends('front.layouts.default', [
    'title' => $server->name . ' server',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary',      'url' => route('front.dictionary.index') ],
        [ 'name' => 'Servers',         'url' => route('front.dictionary.server.index') ],
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
            'value' => $server->full_name
        ])

        @include('front.components.show-row', [
            'name'  => 'name',
            'value' => $server->name
        ])

        @include('front.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $server->abbreviation
        ])

        @include('front.components.show-row', [
            'name'  => 'definition',
            'value' => $server->definition
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $server->open_source
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $server->proprietary
        ])

        @include('front.components.show-row', [
            'name'  => 'owner',
            'value' => $server->owner
        ])

        @include('front.components.show-row-link', [
            'name'   => 'wikipedia',
            'url'    => $server->wikipedia,
            'target' => '_blank'
        ])

        @include('front.components.show-row-link', [
            'name'   => 'link',
            'url'    => $server->link,
            'label'  => $server->link_name,
            'target' => '_blank'
        ])

        @include('front.components.show-row', [
            'name'  => 'description',
            'value' => $server->description
        ])

        @if(!empty($server->image))

            @include('front.components.show-row-image', [
                'name'  => 'image',
                'src'   => $server->image,
                'alt'   => $server->name,
                'width' => '300px',
            ])

            @include('front.components.show-row', [
                'name'  => 'image credit',
                'value' => $server->image_credit
            ])

            @include('front.components.show-row', [
                'name'  => 'image source',
                'value' => $server->image_source
            ])

        @endif

    </div>

@endsection
