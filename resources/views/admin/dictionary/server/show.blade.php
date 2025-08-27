@extends('admin.layouts.default', [
    'title' => $dictionaryServer->name . ' server',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Servers',         'url' => route('admin.dictionary.server.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',  'url' => route('admin.dictionary.server.edit', $dictionaryServer) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Server', 'url' => route('admin.dictionary.server.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',     'url' => route('admin.dictionary.server.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => $dictionaryServer->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $dictionaryServer->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $dictionaryServer->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $dictionaryServer->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $dictionaryServer->owner
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $dictionaryServer->open_source
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $dictionaryServer->proprietary
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'compiled',
            'checked' => $dictionaryServer->compiled
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'website',
            'url'    => $dictionaryServer->website,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'wiki page',
            'url'    => $dictionaryServer->wiki_page,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $dictionaryServer->description
        ])

    </div>

@endsection
