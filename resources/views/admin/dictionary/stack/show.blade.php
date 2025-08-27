@extends('admin.layouts.default', [
    'title' => $dictionaryStack->name . ' stack',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard',  'url' => route('admin.dashboard')],
        [ 'name' => 'Stacks', 'url' => route('admin.dictionary_stack.index')],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'url' => route('admin.dictionary_stack.edit', $dictionaryStack) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Stack', 'url' => route('admin.dictionary_stack.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'url' => route('admin.dictionary_stack.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card">

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => $dictionaryStack->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $dictionaryStack->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $dictionaryStack->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'servers',
            'value' => implode(', ', $dictionaryStack->servers->pluck('name')->toArray())
        ])

        @include('admin.components.show-row', [
            'name'  => 'operating systems',
            'value' => implode(', ', $dictionaryStack->operating_systems->pluck('name')->toArray())
        ])

        @include('admin.components.show-row', [
            'name'  => 'frameworks',
            'value' => implode(', ', $dictionaryStack->frameworks->pluck('name')->toArray())
        ])

        @include('admin.components.show-row', [
            'name'  => 'languages',
            'value' => implode(', ', $dictionaryStack->languages->pluck('name')->toArray())
        ])

        @include('admin.components.show-row', [
            'name'  => 'databases',
            'value' => implode(', ', $dictionaryStack->databases->pluck('name')->toArray())
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'website',
            'url'    => $dictionaryStack->website,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'wiki page',
            'url'    => $dictionaryStack->wiki_page,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $dictionaryStack->description
        ])

    </div>

@endsection
