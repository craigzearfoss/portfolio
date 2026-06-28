@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $language = $language ?? null;

    $title    = 'Dictionary: ' . htmlspecialchars($language->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Languages',  'href' => route('guest.dictionary.language.index') ],
        [ 'name' => htmlspecialchars($language->name) ],
    ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back', ['href' => referer('guest.dictionary.index')])->render()
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'full name',
            'value' => htmlspecialchars($language->full_name)
        ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($language->name)
        ])

        @include('guest.components.show-row', [
            'name'  => 'abbreviation',
            'value' => htmlspecialchars($language->abbreviation)
        ])

        @include('guest.components.show-row', [
            'name'  => 'definition',
            'value' => nl2br($language->definition)
        ])

        @include('guest.components.show-row-checkmark', [
            'name'    => 'open source',
            'checked' => $language->open_source
        ])

        @include('guest.components.show-row-checkmark', [
            'name'    => 'proprietary',
            'checked' => $language->proprietary
        ])

        @include('guest.components.show-row', [
            'name'  => 'owner',
            'value' => $language->owner
        ])

        @include('guest.components.show-row-link', [
            'link_name' => 'wikipedia',
            'name'      => $language->wikipedia,
            'href'      => $language->wikipedia,
            'target'    => '_blank'
        ])

        @include('guest.components.show-row-link', [
            'link_name' => !empty($language->link_name) ? htmlspecialchars($language->link_name) : 'link',
            'name'      => $language->link,
            'href'      => $language->link,
            'target'    => '_blank',
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($language->description)
        ])

        @if (!empty($language->image))

            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $language->image,
                'alt'          => htmlspecialchars($language->name),
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => generateDownloadFilename($language),
                'image_credit' => htmlspecialchars($language->image_credit),
                'image_source' => htmlspecialchars($language->image_source),
            ])

        @endif

    </div>

@endsection
