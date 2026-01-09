@extends('guest.layouts.default', [
    'title'         => $category->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Categories', 'href' => route('guest.dictionary.category.index') ],
        [ 'name' => $category->name ],
    ],
    'buttons'       => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.dictionary.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => $admin ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'full name',
            'value' => $category->full_name
        ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $category->name
        ])

        @include('guest.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $category->abbreviation
        ])

        @include('guest.components.show-row', [
            'name'  => 'definition',
            'value' => $category->definition
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $category->open_source
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $category->proprietary
        ])

        @include('guest.components.show-row', [
            'name'  => 'owner',
            'value' => $category->owner
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $category->wikipedia,
            'target' => '_blank'
        ])

        @include('guest.components.show-row-link', [
            'name'   => $category->link_name ?? 'link',
            'href'   => $category->link,
            'target' => '_blank'
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($category->description ?? '')
        ])

        @if(!empty($category->image))

            @include('guest.components.show-row-image', [
                'name'  => 'image',
                'src'   => $category->image,
                'alt'   => $category->name,
                'width' => '300px',
            ])

            @include('guest.components.show-row', [
                'name'  => 'image credit',
                'value' => $category->image_credit
            ])

            @include('guest.components.show-row', [
                'name'  => 'image source',
                'value' => $category->image_source
            ])

        @endif

    </div>

@endsection
