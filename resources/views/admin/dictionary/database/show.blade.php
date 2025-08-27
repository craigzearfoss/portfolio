@extends('admin.layouts.default', [
    'title' => $dictionaryDatabase->name . ' database',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Databases',       'url' => route('admin.dictionary.database.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        //[ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',    'url' => route('admin.dictionary.database.edit', $dictionaryDatabase) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Database', 'url' => route('admin.dictionary.database.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',       'url' => route('admin.dictionary.database.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => $dictionaryDatabase->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $dictionaryDatabase->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $dictionaryDatabase->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $dictionaryDatabase->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $dictionaryDatabase->owner
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $dictionaryDatabase->open_source
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $dictionaryDatabase->proprietary
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'compiled',
            'checked' => $dictionaryDatabase->compiled
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'website',
            'url'    => $dictionaryDatabase->website,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'wiki page',
            'url'    => $dictionaryDatabase->wiki_page,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $dictionaryDatabase->description
        ])

    </div>

@endsection
