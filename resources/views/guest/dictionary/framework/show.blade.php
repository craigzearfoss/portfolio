@extends('guest.layouts.default', [
    'title' => $framework->name . ' language',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.homepage') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Frameworks', 'href' => route('guest.dictionary.framework.index') ],
        [ 'name' => $framework->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.dictionary.index') ],
    ],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'full name',
            'value' => $framework->full_name
        ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $framework->name
        ])

        @include('guest.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $framework->abbreviation
        ])

        @include('guest.components.show-row', [
            'name'  => 'definition',
            'value' => $framework->definition
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $framework->open_source
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $framework->proprietary
        ])

        @include('guest.components.show-row', [
            'name'  => 'owner',
            'value' => $framework->owner
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $framework->wikipedia,
            'target' => '_blank'
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'link',
            'href'   => $framework->link,
            'label'  => $framework->link_name,
            'target' => '_blank'
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($framework->description ?? '')
        ])

        @if(!empty($framework->image))

            @include('guest.components.show-row-image', [
                'name'  => 'image',
                'src'   => $framework->image,
                'alt'   => $framework->name,
                'width' => '300px',
            ])

            @include('guest.components.show-row', [
                'name'  => 'image credit',
                'value' => $framework->image_credit
            ])

            @include('guest.components.show-row', [
                'name'  => 'image source',
                'value' => $framework->image_source
            ])

        @endif

    </div>

@endsection
