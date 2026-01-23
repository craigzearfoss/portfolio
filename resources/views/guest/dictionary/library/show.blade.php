@extends('guest.layouts.default', [
    'title'            => 'Dictionary: ' . $library->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Libraries',  'href' => route('guest.dictionary.library.index') ],
        [ 'name' => $library->name ],
    ],
    'buttons'          => [
        view('guest.components.nav-button-back', ['href' => referer('guest.dictionary.index')])->render(),
    ],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'full name',
            'value' => $library->full_name
        ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $library->name
        ])

        @include('guest.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $library->abbreviation
        ])

        @include('guest.components.show-row', [
            'name'  => 'definition',
            'value' => nl2br($library->definition)
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $library->open_source
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $library->proprietary
        ])

        @include('guest.components.show-row', [
            'name'  => 'owner',
            'value' => $library->owner
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $library->wikipedia,
            'target' => '_blank'
        ])

        @include('guest.components.show-row-link', [
            'name'   => !empty($library->link_name) ? $library->link_name : 'link',
            'href'   => $library->link,
            'target' => '_blank'
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($library->description)
        ])

        @if(!empty($library->image))

            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $library->image,
                'alt'          => $library->name,
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($library->name, $library->image),
                'image_credit' => $library->image_credit,
                'image_source' => $library->image_source,
            ])

        @endif

    </div>

@endsection
