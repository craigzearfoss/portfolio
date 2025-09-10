@extends('front.layouts.default', [
    'title' => $library->name . ' library',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary', 'url' => route('front.dictionary.index') ],
        [ 'name' => 'Libraries',  'url' => route('front.dictionary.library.index') ],
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
            'value' => $library->full_name
        ])

        @include('front.components.show-row', [
            'name'  => 'name',
            'value' => $library->name
        ])

        @include('front.components.show-row', [
            'name'  => 'slug',
            'value' => $library->slug
        ])

        @include('front.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $library->abbreviation
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
            'name'  => 'wiki page',
            'url'    => $library->wikipedia,
            'target' => '_blank'
        ])

        @include('front.components.show-row-link', [
            'name'  => 'link',
            'url'    => $library->link,
            'target' => '_blank'
        ])

        @include('front.components.show-row', [
            'name'  => 'link name',
            'value' => $library->link_name
        ])

        @include('front.components.show-row', [
            'name'  => 'description',
            'value' => $library->description
        ])

        @include('front.components.show-row-image', [
            'name'  => 'image',
            'value' => $library->image
        ])

        @include('front.components.show-row', [
            'name'  => 'image credit',
            'value' => $library->image_credit
        ])

        @include('front.components.show-row', [
            'name'  => 'image source',
            'value' => $library->image_source
        ])

        @include('front.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $library->thumbnail
        ])

        @include('front.components.show-row', [
            'name'  => 'sequence',
            'value' => $library->sequence
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $library->public
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $library->readonly
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $library->root
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $library->disabled
        ])

        @include('front.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($library->created_at)
        ])

        @include('front.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($library->updated_at)
        ])

        @include('front.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($library->deleted_at)
        ])

    </div>

@endsection
