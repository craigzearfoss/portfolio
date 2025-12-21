@extends('guest.layouts.default', [
    'title'         => $language->name . ' language',
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Languages',  'href' => route('guest.dictionary.language.index') ],
        [ 'name' => $language->name ],
    ],
    'buttons'       => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.dictionary.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'full name',
            'value' => $language->full_name
        ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $language->name
        ])

        @include('guest.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $language->abbreviation
        ])

        @include('guest.components.show-row', [
            'name'  => 'definition',
            'value' => $language->definition
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $language->open_source
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $language->proprietary
        ])

        @include('guest.components.show-row', [
            'name'  => 'owner',
            'value' => $language->owner
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $language->wikipedia,
            'target' => '_blank'
        ])

        @include('guest.components.show-row-link', [
            'name'   => $language->link_name ?? 'link',
            'href'   => $language->link,
            'target' => '_blank'
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($language->description ?? '')
        ])

        @if(!empty($language->image))

            @include('guest.components.show-row-image', [
                'name'  => 'image',
                'src'   => $recipe->$language,
                'alt'   => $recipe->$language,
                'width' => '300px',
            ])

            @include('guest.components.show-row', [
                'name'  => 'image credit',
                'value' => $language->image_credit
            ])

            @include('guest.components.show-row', [
                'name'  => 'image source',
                'value' =>$language->image_source
            ])

        @endif

    </div>

@endsection
