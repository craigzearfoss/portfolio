@extends('admin.layouts.default', [
    'title' => $dictionaryOperatingSystem->name . ' operating system',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard',   'url' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',        'url' => route('admin.dictionary.index') ],
        [ 'name' => 'Operating Systems', 'url' => route('admin.dictionary.operating-system.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',             'url' => route('admin.dictionary.operating-system.edit', $dictionaryOperatingSystem) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Operating Systems', 'url' => route('admin.dictionary.operating-system.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',                'url' => route('admin.dictionary.operating-system.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => $dictionaryOperatingSystem->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $dictionaryOperatingSystem->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $dictionaryOperatingSystem->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $dictionaryOperatingSystem->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $dictionaryOperatingSystem->owner
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $dictionaryOperatingSystem->open_source
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $dictionaryOperatingSystem->proprietary
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'website',
            'url'    => $dictionaryOperatingSystem->website,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'wiki page',
            'url'    => $dictionaryOperatingSystem->wiki_page,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $dictionaryOperatingSystem->description
        ])

    </div>

@endsection
