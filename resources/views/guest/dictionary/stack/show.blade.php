@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $stack = $stack ?? null;

    $title    = 'Dictionary: ' . htmlspecialchars($stack->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Stacks',     'href' => route('guest.dictionary.stack.index') ],
        [ 'name' => htmlspecialchars($stack->name) ],
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
            'value' => htmlspecialchars($stack->full_name)
        ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($stack->name)
        ])

        @include('guest.components.show-row', [
            'name'  => 'abbreviation',
            'value' => htmlspecialchars($stack->abbreviation)
        ])

        @include('guest.components.show-row', [
            'name'  => 'definition',
            'value' => nl2br($stack->definition)
        ])

        @include('guest.components.show-row-checkmark', [
            'name'    => 'open source',
            'checked' => $stack->open_source
        ])

        @include('guest.components.show-row-checkmark', [
            'name'    => 'proprietary',
            'checked' => $stack->proprietary
        ])

        @include('guest.components.show-row', [
            'name'  => 'owner',
            'value' => $stack->owner
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $stack->wikipedia,
            'target' => '_blank'
        ])

        @include('guest.components.show-row-link', [
            'name'   => !empty($stack->link_name) ? htmlspecialchars($stack->link_name) : 'link',
            'href'   => $stack->link,
            'target' => '_blank'
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($stack->description)
        ])

        @if (!empty($stack->image))

            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $stack->image,
                'alt'          => htmlspecialchars($stack->name),
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => generateDownloadFilename($stack),
                'image_credit' => htmlspecialchars($stack->image_credit),
                'image_source' => htmlspecialchars($stack->image_source),
            ])

        @endif

    </div>

@endsection
