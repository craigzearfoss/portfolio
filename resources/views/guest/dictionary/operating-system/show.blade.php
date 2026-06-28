@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $operatingSystem = $operatingSystem ?? null;

    $title    = 'Dictionary: ' . htmlspecialchars($operatingSystem->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',              'href' => route('guest.index') ],
        [ 'name' => 'Dictionary',        'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Operating Systems', 'href' => route('guest.dictionary.operating-system.index') ],
        [ 'name' => htmlspecialchars($operatingSystem->name) ],
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
            'value' => htmlspecialchars($operatingSystem->full_name)
        ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($operatingSystem->name)
        ])

        @include('guest.components.show-row', [
            'name'  => 'abbreviation',
            'value' => htmlspecialchars($operatingSystem->abbreviation)
        ])

        @include('guest.components.show-row', [
            'name'  => 'definition',
            'value' => nl2br($operatingSystem->definition)
        ])

        @include('guest.components.show-row-checkmark', [
            'name'    => 'open source',
            'checked' => $operatingSystem->open_source
        ])

        @include('guest.components.show-row-checkmark', [
            'name'    => 'proprietary',
            'checked' => $operatingSystem->proprietary
        ])

        @include('guest.components.show-row', [
            'name'  => 'owner',
            'value' => $operatingSystem->owner
        ])

        @include('guest.components.show-row-link', [
            'link_name' => 'wikipedia',
            'name'      => $operatingSystem->wikipedia,
            'href'      => $operatingSystem->wikipedia,
            'target'    => '_blank'
        ])

        @include('guest.components.show-row-link', [
            'link_name' => !empty($operatingSystem->link_name) ? htmlspecialchars($operatingSystem->link_name) : 'link',
            'name'      => $operatingSystem->link,
            'href'      => $operatingSystem->link,
            'target'    => '_blank',
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($operatingSystem->description)
        ])

        @if (!empty($operatingSystem->image))

            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $operatingSystem->image,
                'alt'          => htmlspecialchars($operatingSystem->name),
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => generateDownloadFilename($operatingSystem),
                'image_credit' => htmlspecialchars($operatingSystem->image_credit),
                'image_source' => htmlspecialchars($operatingSystem->image_source),
            ])

        @endif

    </div>

@endsection
