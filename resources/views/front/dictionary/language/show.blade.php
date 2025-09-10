@extends('front.layouts.default', [
    'title' => $language->name . ' language',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary', 'url' => route('front.dictionary.index') ],
        [ 'name' => 'Languages',  'url' => route('front.dictionary.language.index') ],
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
            'value' => $language->full_name
        ])

        @include('front.components.show-row', [
            'name'  => 'name',
            'value' => $language->name
        ])

        @include('front.components.show-row', [
            'name'  => 'slug',
            'value' => $language->slug
        ])

        @include('front.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $language->abbreviation
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $language->open_source
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $language->proprietary
        ])

        @include('front.components.show-row', [
            'name'  => 'owner',
            'value' => $language->owner
        ])

        @include('front.components.show-row-link', [
            'name'  => 'wiki page',
            'url'    => $language->wikipedia,
            'target' => '_blank'
        ])

        @include('front.components.show-row-link', [
            'name'  => 'link',
            'url'    => $language->link,
            'target' => '_blank'
        ])

        @include('front.components.show-row', [
            'name'  => 'link name',
            'value' => $language->link_name
        ])

        @include('front.components.show-row', [
            'name'  => 'description',
            'value' => $language->description
        ])

        @include('front.components.show-row-image', [
            'name'  => 'image',
            'value' => $language->image
        ])

        @include('front.components.show-row', [
            'name'  => 'image credit',
            'value' => $language->image_credit
        ])

        @include('front.components.show-row', [
            'name'  => 'image source',
            'value' =>$language->image_source
        ])

        @include('front.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $language->thumbnail
        ])

        @include('front.components.show-row', [
            'name'  => 'sequence',
            'value' => $language->sequence
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $language->public
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $language->readonly
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $language->root
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $language->disabled
        ])

        @include('front.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($language->created_at)
        ])

        @include('front.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($language->updated_at)
        ])

        @include('front.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($language->deleted_at)
        ])

    </div>

@endsection
