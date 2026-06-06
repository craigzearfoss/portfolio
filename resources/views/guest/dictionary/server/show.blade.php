@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $server = $server ?? null;

    $title    = 'Dictionary: ' . htmlspecialchars($server->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Servers',    'href' => route('guest.dictionary.server.index') ],
        [ 'name' => htmlspecialchars($server->name) ],
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
            'value' => htmlspecialchars($server->full_name)
        ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($server->name)
        ])

        @include('guest.components.show-row', [
            'name'  => 'abbreviation',
            'value' => htmlspecialchars($server->abbreviation)
        ])

        @include('guest.components.show-row', [
            'name'  => 'definition',
            'value' => nl2br($server->definition)
        ])

        @include('guest.components.show-row-checkmark', [
            'name'    => 'open source',
            'checked' => $server->open_source
        ])

        @include('guest.components.show-row-checkmark', [
            'name'    => 'proprietary',
            'checked' => $server->proprietary
        ])

        @include('guest.components.show-row', [
            'name'  => 'owner',
            'value' => $server->owner
        ])

        @include('guest.components.show-row-link', [
            'link_name' => 'wikipedia',
            'name'      => $server->wikipedia,
            'href'      => $server->wikipedia,
            'target'    => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'link_name' => !empty($server->link_name) ? htmlspecialchars($server->link_name) : 'link',
            'name'      => $server->link,
            'href'      => $server->link,
            'target'    => '_blank',
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($server->description)
        ])

        @if (!empty($server->image))

            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $server->image,
                'alt'          => htmlspecialchars($server->name),
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => generateDownloadFilename($server),
                'image_credit' => htmlspecialchars($server->image_credit),
                'image_source' => htmlspecialchars($server->image_source),
            ])

        @endif

    </div>

@endsection
