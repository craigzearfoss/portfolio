@extends('admin.layouts.default', [
    'title' => $dictionaryLanguage->name . ' language',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Languages',       'url' => route('admin.dictionary.language.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',    'url' => route('admin.dictionary.language.edit', $dictionaryLanguage) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Language', 'url' => route('admin.dictionary.language.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',       'url' => route('admin.dictionary.language.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => $dictionaryLanguage->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $dictionaryLanguage->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $dictionaryLanguage->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $dictionaryLanguage->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $dictionaryLanguage->owner
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $dictionaryLanguage->open_source
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $dictionaryLanguage->proprietary
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'compiled',
            'checked' => $dictionaryLanguage->compiled
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'website',
            'url'    => $dictionaryLanguage->website,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'wiki page',
            'url'    => $dictionaryLanguage->wiki_page,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $dictionaryLanguage->description
        ])

    </div>

@endsection
