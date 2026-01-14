@extends('guest.layouts.default', [
    'title'         => 'Dictionary: ' . $database->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('home') ],
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
    'admin'         => $admin,
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
            'value' => nl2br($database->definition)
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
            'name'   => !empty($database->link_name) ? $database->link_name : 'link',
            'href'   => $database->link,
            'target' => '_blank'
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($database->description)
        ])

        @if(!empty($database->image))

            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $database->image,
                'alt'          => $database->name,
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($database->name, $database->image),
                'image_credit' => $database->image_credit,
                'image_source' => $database->image_source,
            ])

        @endif

    </div>

@endsection
