@extends('front.layouts.default', [
    'title' => $framework->name . ' language',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary', 'url' => route('front.dictionary.index') ],
        [ 'name' => 'Frameworks', 'url' => route('front.dictionary.framework.index') ],
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
            'value' => $framework->full_name
        ])

        @include('front.components.show-row', [
            'name'  => 'name',
            'value' => $framework->name
        ])

        @include('front.components.show-row', [
            'name'  => 'slug',
            'value' => $framework->slug
        ])

        @include('front.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $framework->abbreviation
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
            'name'  => 'wiki page',
            'url'    => $framework->wikipedia,
            'target' => '_blank'
        ])

        @include('front.components.show-row-link', [
            'name'  => 'link',
            'url'    => $framework->link,
            'target' => '_blank'
        ])

        @include('front.components.show-row', [
            'name'  => 'link name',
            'value' => $framework->link_name
        ])

        @include('front.components.show-row', [
            'name'  => 'description',
            'value' => $framework->description
        ])

        @include('front.components.show-row-image', [
            'name'  => 'image',
            'value' => $framework->image
        ])

        @include('front.components.show-row', [
            'name'  => 'image credit',
            'value' => $framework->image_credit
        ])

        @include('front.components.show-row', [
            'name'  => 'image source',
            'value' => $framework->image_source
        ])

        @include('front.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $framework->thumbnail
        ])

        @include('front.components.show-row', [
            'name'  => 'sequence',
            'value' => $framework->sequence
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $framework->public
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $framework->readonly
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $framework->root
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $framework->disabled
        ])

        @include('front.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($framework->created_at)
        ])

        @include('front.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($framework->updated_at)
        ])

        @include('front.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($framework->deleted_at)
        ])

    </div>

@endsection
