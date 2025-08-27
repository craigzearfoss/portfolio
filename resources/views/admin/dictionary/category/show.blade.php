@extends('admin.layouts.default', [
    'title' => $dictionaryCategory->name . ' language',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Categories',      'url' => route('admin.dictionary.category.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',    'url' => route('admin.dictionary.category.edit', $dictionaryCategory) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Category', 'url' => route('admin.dictionary.category.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',       'url' => route('admin.dictionary.category.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $dictionaryCategory->name
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'wiki page',
            'url'    => $dictionaryCategory->wiki_page,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $dictionaryCategory->description
        ])

    </div>

@endsection
