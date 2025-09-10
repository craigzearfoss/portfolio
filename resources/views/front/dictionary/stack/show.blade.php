@extends('front.layouts.default', [
    'title' => $stack->name . ' stack',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary', 'url' => route('front.dictionary.index') ],
        [ 'name' => 'Stacks',     'url' => route('front.dictionary.stack.index') ],
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
            'value' => $stack->full_name
        ])

        @include('front.components.show-row', [
            'name'  => 'name',
            'value' => $stack->name
        ])

        @include('front.components.show-row', [
            'name'  => 'slug',
            'value' => $stack->slug
        ])

        @include('front.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $stack->abbreviation
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
            'name'  => 'wiki page',
            'url'    => $stack->wikipedia,
            'target' => '_blank'
        ])

        @include('front.components.show-row-link', [
            'name'  => 'link',
            'url'    => $stack->link,
            'target' => '_blank'
        ])

        @include('front.components.show-row', [
            'name'  => 'link name',
            'value' => $stack->link_name
        ])

        @include('front.components.show-row', [
            'name'  => 'description',
            'value' => $stack->description
        ])

        @include('front.components.show-row-image', [
            'name'  => 'image',
            'value' => $stack->image
        ])

        @include('front.components.show-row', [
            'name'  => 'image credit',
            'value' => $stack->image_credit
        ])

        @include('front.components.show-row', [
            'name'  => 'image source',
            'value' => $stack->image_source
        ])

        @include('front.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $stack->thumbnail
        ])

        @include('front.components.show-row', [
            'name'  => 'sequence',
            'value' => $stack->sequence
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $stack->public
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $stack->readonly
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $stack->root
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $stack->disabled
        ])

        @include('front.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($stack->created_at)
        ])

        @include('front.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($stack->updated_at)
        ])

        @include('front.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($stack->deleted_at)
        ])

    </div>

@endsection
