@extends('admin.layouts.default', [
    'title' => $dictionaryServer->name . ' server',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'url' => route('admin.dictionary.index') ],
        [ 'name' => 'Servers',         'url' => route('admin.dictionary.server.index') ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-list"></i> Show',       'url' => route('admin.dictionary.server.show', $dictionaryServer) ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.dictionary.server.index') ],
    ],
    'errors' => $errors ?? [],
    'success' => session('success') ?? null,
    'error' => session('error') ?? null,
])

@section('content')

    <div class="form-container">

        <form action="{{ route('admin.dictionary.server.update', $dictionaryServer) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-input', [
                'name'      => 'full_name',
                'value'     => old('full_name') ?? $server->full_name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'name'      => 'name',
                'value'     => old('name') ?? $server->name,
                'required'  => true,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'name'      => 'abbreviation',
                'value'     => old('abbreviation') ?? $server->abbreviation,
                'required'  => true,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'open_source',
                'label'           => 'open source',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('open_source') ?? $server->open_source,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'proprietary',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('proprietary') ?? $server->proprietary,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'name'      => 'wiki_page',
                'label'     => 'wiki page',
                'value'     => old('wiki_page') ?? $server->wiki_page,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'name'      => 'link',
                'value'     => old('link') ?? $server->link,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'name'      => 'link_name',
                'label'     => 'link name',
                'value'     => old('link') ?? $server->link_name,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $server->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'image',
                'value'   => old('image') ?? $server->image,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'thumbnail',
                'value'   => old('thumbnail') ?? $server->thumbnail,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'sequence',
                'value'       => old('sequence') ?? $server->sequence,
                'min'         => 0,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'public',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('public') ?? $server->public,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'readonly',
                'label'           => 'read-only',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('readonly') ?? $server->readonly,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'root',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('root') ?? $server->root,
                'disabled'        => !Auth::guard('admin')->user()->root,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'disabled',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('disabled') ?? $server->disabled,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => route('admin.dictionary.server.index')
            ])

        </form>

    </div>

@endsection
