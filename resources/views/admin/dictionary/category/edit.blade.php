@extends('admin.layouts.default', [
    'title' => $dictionaryCategory->name . ' category',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'url' => route('admin.dictionary.index') ],
        [ 'name' => 'Categories',      'url' => route('admin.dictionary.category.index') ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-list"></i> Show',       'url' => route('admin.dictionary.category.show', $dictionaryCategory) ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.dictionary.category.index') ],
    ],
    'errors' => $errors ?? [],
    'success' => session('success') ?? null,
    'error' => session('error') ?? null,
])

@section('content')

    <div class="form">

        <form action="{{ route('admin.dictionary.category.update', $dictionaryCategory) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-input', [
                'name'      => 'name',
                'value'     => old('name') ?? $dictionaryCategory->name,
                'required'  => true,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'name'      => 'wiki_page',
                'label'     => 'wiki page',
                'value'     => old('wiki_page') ?? $dictionaryCategory->wiki_page,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $dictionaryCategory->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-button-submit', [
                'label'      => 'Save Category',
                'cancel_url' => route('admin.dictionary.category.index')
            ])

        </form>

    </div>

@endsection
