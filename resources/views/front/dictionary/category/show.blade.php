@extends('front.layouts.default', [
    'title' => $category->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',       'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary', 'url' => route('front.dictionary.index') ],
        [ 'name' => 'Categories', 'url' => route('front.dictionary.category.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => referer('front.dictionary.index') ],
    ],
    'errors'  => $errors->any()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('front.components.show-row', [
            'name'  => 'full name',
            'value' => $category->full_name
        ])

        @include('front.components.show-row', [
            'name'  => 'name',
            'value' => $category->name
        ])

        @include('front.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $category->abbreviation
        ])

        @include('front.components.show-row', [
            'name'  => 'definition',
            'value' => $category->definition
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $category->open_source
        ])

        @include('front.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $category->proprietary
        ])

        @include('front.components.show-row', [
            'name'  => 'owner',
            'value' => $category->owner
        ])

        @include('front.components.show-row-link', [
            'name'   => 'wikipedia',
            'url'    => $category->wikipedia,
            'target' => '_blank'
        ])

        @include('front.components.show-row-link', [
            'name'   => 'link',
            'url'    => $category->link,
            'label'  => $category->link_name,
            'target' => '_blank'
        ])

        @include('front.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($category->description)
        ])

        @if(!empty($category->image))

            @include('front.components.show-row-image', [
                'name'  => 'image',
                'src'   => $category->image,
                'alt'   => $category->name,
                'width' => '300px',
            ])

            @include('front.components.show-row', [
                'name'  => 'image credit',
                'value' => $category->image_credit
            ])

            @include('front.components.show-row', [
                'name'  => 'image source',
                'value' => $category->image_source
            ])

        @endif

    </div>

@endsection
