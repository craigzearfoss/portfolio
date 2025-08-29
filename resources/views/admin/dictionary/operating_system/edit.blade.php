@extends('admin.layouts.default', [
    'title' => $dictionaryOperatingSystem->name . ' operating system',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard',   'url' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',        'url' => route('admin.dictionary.index') ],
        [ 'name' => 'Operating Systems', 'url' => route('admin.dictionary.operating-system.index') ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-list"></i> Show',       'url' => route('admin.dictionary.operating-system.show', $dictionaryOperatingSystem) ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.dictionary.operating-system.index') ],
    ],
    'errors' => $errors ?? [],
    'success' => session('success') ?? null,
    'error' => session('error') ?? null,
])

@section('content')

    <div class="form-container">

        <form
            action="{{ route('admin.dictionary.operating-system.update', $dictionaryOperatingSystem) }}"
            method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-input-horizontal', [
                'name'      => 'full_name',
                'label'     => 'full name',
                'value'     => old('full_name') ?? $dictionaryOperatingSystem->full_name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $dictionaryOperatingSystem->name,
                'required'  => true,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'slug',
                'value'     => old('slug') ?? $dictionaryOperatingSystem->slug,
                'required'  => true,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'abbreviation',
                'value'     => old('abbreviation') ?? $dictionaryOperatingSystem->abbreviation,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'owner',
                'value'     => old('owner') ?? $dictionaryOperatingSystem->owner,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'open_source',
                'label'           => 'open source',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('public') ?? $dictionaryOperatingSystem->open_source,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'proprietary',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('proprietary') ?? $dictionaryOperatingSystem->proprietary,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'website',
                'value'     => old('website') ?? $dictionaryOperatingSystem->website,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'wiki_page',
                'label'     => 'wiki page',
                'value'     => old('wiki_page') ?? $dictionaryOperatingSystem->wiki_page,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $dictionaryOperatingSystem->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => route('admin.dictionary.operating-system.index')
            ])

        </form>

    </div>

@endsection
