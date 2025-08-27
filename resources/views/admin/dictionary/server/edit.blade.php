@extends('admin.layouts.default', [
    'title' => $dictionaryServer->name . ' server',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Servers',         'url' => route('admin.dictionary_server.index') ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-list"></i> Show',       'url' => route('admin.dictionary_server.show', $dictionaryServer) ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.dictionary_server.index') ],
    ],
    'errors' => $errors ?? [],
    'success' => session('success') ?? null,
    'error' => session('error') ?? null,
])

@section('content')

    <div class="form-container">

        <form action="{{ route('admin.dictionary_server.update', $dictionaryServer) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-input-horizontal', [
                'name'      => 'full_name',
                'label'     => 'full name',
                'value'     => old('full_name') ?? $dictionaryServer->full_name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $dictionaryServer->name,
                'required'  => true,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'slug',
                'value'     => old('slug') ?? $dictionaryServer->slug,
                'required'  => true,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'abbreviation',
                'value'     => old('abbreviation') ?? $dictionaryServer->abbreviation,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'owner',
                'value'     => old('owner') ?? $dictionaryServer->owner,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'open_source',
                'label'           => 'open source',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('public') ?? $dictionaryServer->open_source,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'proprietary',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('proprietary') ?? $dictionaryServer->proprietary,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'compiled',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('compiled') ?? $dictionaryServer->compiled,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'website',
                'value'     => old('website') ?? $dictionaryServer->website,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'wiki_page',
                'label'     => 'wiki page',
                'value'     => old('wiki_page') ?? $dictionaryServer->wiki_page,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $dictionaryServer->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => route('admin.dictionary_server.index')
            ])

        </form>

    </div>

@endsection
