@extends('front.layouts.default', [
    'title' => $language->name . ' language',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary', 'url' => route('front.dictionary.index') ],
        [ 'name' => 'Languages',  'url' => route('front.dictionary.language.index') ],
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
            'value' => $language->full_name
        ])

        @include('front.components.show-row', [
            'name'  => 'name',
            'value' => $language->name
        ])

        @include('front.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $language->abbreviation
        ])

        @include('front.components.show-row', [
            'name'  => 'definition',
            'value' => $language->definition
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
            'name'   => 'wikipedia',
            'url'    => $language->wikipedia,
            'target' => '_blank'
        ])

        @include('front.components.show-row-link', [
            'name'   => 'link',
            'url'    => $language->link,
            'label'  => $language->link_name,
            'target' => '_blank'
        ])

        @include('front.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($language->description ?? '')
        ])

        @if(!empty($language->image))

            @include('front.components.show-row-image', [
                'name'  => 'image',
                'src'   => $recipe->$language,
                'alt'   => $recipe->$language,
                'width' => '300px',
            ])

            @include('front.components.show-row', [
                'name'  => 'image credit',
                'value' => $language->image_credit
            ])

            @include('front.components.show-row', [
                'name'  => 'image source',
                'value' =>$language->image_source
            ])

        @endif

    </div>

@endsection
