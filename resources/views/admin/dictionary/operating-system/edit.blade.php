@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                 'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',      'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',           'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Operating-Systems',    'href' => route('admin.dictionary.operating-system.index') ],
        [ 'name' => $operatingSystem->name, 'href' => route('admin.dictionary.operating-system.show', $operating-system) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $buttons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.dictionary.operating-system.index')])->render()
    ];
@endphp
@extends('admin.layouts.default', [
    'title'            => 'Dictionary: ' . $operatingSystem->name . ' (operating system)',
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.dictionary.operating-system.update', $operatingSystem) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.dictionary.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $operatingSystem->id
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'full_name',
                'label'     => 'full name',
                'value'     => old('full_name') ?? $operatingSystem->full_name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $operatingSystem->name,
                'required'  => true,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'abbreviation',
                'value'     => old('abbreviation') ?? $operatingSystem->abbreviation,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'definition',
                'value'     => old('definition') ?? $operatingSystem->definition,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'open_source',
                                'label'           => 'open source',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('open_source') ?? $operatingSystem->open_source,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'proprietary',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('proprietary') ?? $operatingSystem->proprietary,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'compiled',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('compiled') ?? $operatingSystem->compiled,
                                'message'         => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-input-horizontal', [
                'name'      => 'owner',
                'value'     => old('owner') ?? $operatingSystem->owner,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'wikipedia',
                'label'     => 'wikipedia',
                'value'     => old('wikipedia') ?? $operatingSystem->wikipedia,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $operatingSystem->link,
                'name' => old('link_name') ?? $operatingSystem->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $operatingSystem->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $operatingSystem->image,
                'credit'  => old('image_credit') ?? $operatingSystem->image_credit,
                'source'  => old('image_source') ?? $operatingSystem->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $operatingSystem->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'      => old('public')   ?? $operatingSystem->public,
                'readonly'    => old('readonly') ?? $operatingSystem->readonly,
                'root'        => old('root')     ?? $operatingSystem->root,
                'disabled'    => old('disabled') ?? $operatingSystem->disabled,
                'demo'        => old('demo')     ?? $operatingSystem->demo,
                'sequence'    => old('sequence') ?? $operatingSystem->sequence,
                'message'     => $message ?? '',
                'isRootAdmin' => isRootAdmin(),
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.dictionary.index')
            ])

        </form>

    </div>

@endsection
