@extends('guest.layouts.default', [
    'title'         => $database->name . ' database',
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Databases',  'href' => route('guest.dictionary.database.index') ],
        [ 'name' => $database->name ],
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
            'value' => $database->full_name
        ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $database->name
        ])

        @include('guest.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $database->abbreviation
        ])

        @include('guest.components.show-row', [
            'name'  => 'definition',
            'value' => $database->definition
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $database->open_source
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $database->proprietary
        ])

        @include('guest.components.show-row', [
            'name'  => 'owner',
            'value' => $database->owner
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $database->wikipedia,
            'target' => '_blank'
        ])

        @include('guest.components.show-row-link', [
            'name'   => $database->link_name ?? 'link',
            'href'   => $database->link,
            'target' => '_blank'
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($database->description ?? '')
        ])

        @if(!empty($database->image))

            @include('guest.components.show-row-image', [
                'name'  => 'image',
                'src'   => $database->image,
                'alt'   => $database->name,
                'width' => '300px',
            ])

            @include('guest.components.show-row', [
                'name'  => 'image credit',
                'value' => $database->image_credit
            ])

            @include('guest.components.show-row', [
                'name'  => 'image source',
                'value' => $database->image_source
            ])

        @endif

    </div>

@endsection
