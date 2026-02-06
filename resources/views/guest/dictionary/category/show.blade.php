@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Catgories', 'href' => route('guest.dictionary.category.index') ],
        [ 'name' => $category->name ],
    ];

    // set navigation buttons
    $buttons = [
        view('guest.components.nav-button-back', ['href' => referer('guest.dictionary.index')])->render()
    ];
@endphp
@extends('guest.layouts.default', [
    'title'            => 'Dictionary: ' . $category->name,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
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
            'value' => nl2br($category->definition)
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
            'name'   => !empty($category->link_name) ? $category->link_name : 'link',
            'href'   => $category->link,
            'target' => '_blank'
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($category->description)
        ])

        @if(!empty($category->image))

            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $category->image,
                'alt'          => $category->name,
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($category->name, $category->image),
                'image_credit' => $category->image_credit,
                'image_source' => $category->image_source,
            ])

        @endif

    </div>

@endsection
