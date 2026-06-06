@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $library = $library ?? null;

    $title    = 'Dictionary: ' . htmlspecialchars($library->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Libraries',  'href' => route('guest.dictionary.library.index') ],
        [ 'name' => htmlspecialchars($library->name) ],
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
            'value' => htmlspecialchars($library->full_name)
        ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($library->name)
        ])

        @include('guest.components.show-row', [
            'name'  => 'abbreviation',
            'value' => htmlspecialchars($library->abbreviation)
        ])

        @include('guest.components.show-row', [
            'name'  => 'definition',
            'value' => nl2br($library->definition)
        ])

        @include('guest.components.show-row-checkmark', [
            'name'    => 'open source',
            'checked' => $library->open_source
        ])

        @include('guest.components.show-row-checkmark', [
            'name'    => 'proprietary',
            'checked' => $library->proprietary
        ])

        @include('guest.components.show-row', [
            'name'  => 'owner',
            'value' => $library->owner
        ])

        @include('guest.components.show-row-link', [
            'link_name' => 'wikipedia',
            'name'      => $library->wikipedia,
            'href'      => $library->wikipedia,
            'target'    => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'link_name' => !empty($library->link_name) ? htmlspecialchars($library->link_name) : 'link',
            'name'      => $library->link,
            'href'      => $library->link,
            'target'    => '_blank',
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($library->description)
        ])

        @if (!empty($library->image))

            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $library->image,
                'alt'          => htmlspecialchars($library->name),
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => generateDownloadFilename($library),
                'image_credit' => htmlspecialchars($library->image_credit),
                'image_source' => htmlspecialchars($library->image_source),
            ])

        @endif

    </div>

@endsection
