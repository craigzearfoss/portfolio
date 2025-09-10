@extends('front.layouts.default', [
    'title' => $server->name . ' server',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary',      'url' => route('front.dictionary.index') ],
        [ 'name' => 'Servers',         'url' => route('front.dictionary.server.index') ],
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
            'value' => $server->full_name
        ])

        @include('front.components.show-row', [
            'name'  => 'name',
            'value' => $server->name
        ])

        @include('front.components.show-row', [
            'name'  => 'slug',
            'value' => $server->slug
        ])

        @include('front.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $server->abbreviation
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
            'name'  => 'wiki page',
            'url'    => $server->wikipedia,
            'target' => '_blank'
        ])

        @include('front.components.show-row-link', [
            'name'  => 'link',
            'url'    => $server->link,
            'target' => '_blank'
        ])

        @include('front.components.show-row', [
            'name'  => 'link name',
            'value' => $server->link_name
        ])

        @include('front.components.show-row', [
            'name'  => 'description',
            'value' => $server->description
        ])

        @include('front.components.show-row-image', [
            'name'  => 'image',
            'value' => $server->image
        ])

        @include('front.components.show-row', [
            'name'  => 'image credit',
            'value' => $server->image_credit
        ])

        @include('front.components.show-row', [
            'name'  => 'image source',
            'value' => $server->image_source
        ])

        @include('front.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $server->thumbnail
        ])

        @include('front.components.show-row', [
            'name'  => 'sequence',
            'value' => $server->sequence
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $server->public
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $server->readonly
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $server->root
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $server->disabled
        ])

        @include('front.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($server->created_at)
        ])

        @include('front.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($server->updated_at)
        ])

        @include('front.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($server->deleted_at)
        ])

    </div>

@endsection
