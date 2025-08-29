@extends('admin.layouts.default', [
    'title' => $dictionaryFramework->name . ' language',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'url' => route('admin.dictionary.index') ],
        [ 'name' => 'Frameworks',      'url' => route('admin.dictionary.framework.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',     'url' => route('admin.dictionary.framework.edit', $dictionaryFramework) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Framework', 'url' => route('admin.dictionary.framework.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',        'url' => route('admin.dictionary.framework.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => $dictionaryFramework->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $dictionaryFramework->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $dictionaryFramework->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $dictionaryFramework->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $dictionaryFramework->owner
        ])

        @include('admin.components.show-row', [
            'name'  => 'languages',
            'value' => implode(', ', $dictionaryFramework->languages->pluck('name')->toArray())
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $dictionaryFramework->open_source
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $dictionaryFramework->proprietary
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'compiled',
            'checked' => $dictionaryFramework->compiled
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'website',
            'url'    => $dictionaryFramework->website,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'wiki page',
            'url'    => $dictionaryFramework->wiki_page,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $dictionaryFramework->description
        ])

    </div>

@endsection
