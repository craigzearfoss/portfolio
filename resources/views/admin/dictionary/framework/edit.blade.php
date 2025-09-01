@extends('admin.layouts.default', [
    'title' => $dictionaryFramework->name . ' framework',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'url' => route('admin.dictionary.index') ],
        [ 'name' => 'Frameworks',      'url' => route('admin.dictionary.framework.index') ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-list"></i> Show',       'url' => route('admin.dictionary.framework.show', $dictionaryFramework) ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.dictionary.framework.index') ],
    ],
    'errors' => $errors ?? [],
    'success' => session('success') ?? null,
    'error' => session('error') ?? null,
])

@section('content')

    <div class="form">

        <form action="{{ route('admin.dictionary.framework.update', $dictionaryFramework) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-input', [
                'name'      => 'full_name',
                'value'     => old('full_name') ?? $framework->full_name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'name'      => 'name',
                'value'     => old('name') ?? $framework->name,
                'required'  => true,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'name'      => 'abbreviation',
                'value'     => old('abbreviation') ?? $framework->abbreviation,
                'required'  => true,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'open_source',
                'label'           => 'open source',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('open_source') ?? $framework->open_source,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'proprietary',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('proprietary') ?? $framework->proprietary,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'name'      => 'wiki_page',
                'label'     => 'wiki page',
                'value'     => old('wiki_page') ?? $framework->wiki_page,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'name'      => 'link',
                'value'     => old('link') ?? $framework->link,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'name'      => 'link_name',
                'label'     => 'link name',
                'value'     => old('link') ?? $framework->link_name,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $framework->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'image',
                'value'   => old('image') ?? $framework->image,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'thumbnail',
                'value'   => old('thumbnail') ?? $framework->thumbnail,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'sequence',
                'value'       => old('sequence') ?? $framework->sequence,
                'min'         => 0,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'public',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('public') ?? $framework->public,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'readonly',
                'label'           => 'read-only',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('readonly') ?? $framework->readonly,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'root',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('root') ?? $framework->root,
                'disabled'        => !Auth::guard('admin')->user()->root,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'disabled',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('disabled') ?? $framework->disabled,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => route('admin.dictionary.framework.index')
            ])

        </form>

    </div>

@endsection
