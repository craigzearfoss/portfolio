@extends('admin.layouts.default', [
    'title'            => 'Dictionary: ' . $category->name . ' (category)',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Categories',      'href' => route('admin.dictionary.category.index') ],
        [ 'name' => $category->name,   'href' => route('admin.dictionary.category.show', $category->id) ],
        [ 'name' => 'Edit' ],
    ],
    'buttons'          => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.dictionary.index') ],
    ],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.dictionary.category.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.dictionary.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $category->id
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'full_name',
                'label'     => 'full name',
                'value'     => old('full_name') ?? $category->full_name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $category->name,
                'required'  => true,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'abbreviation',
                'value'     => old('abbreviation') ?? $category->abbreviation,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'definition',
                'value'     => old('definition') ?? $category->definition,
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
                                'checked'         => old('open_source') ?? $category->open_source,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'proprietary',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('proprietary') ?? $category->proprietary,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'compiled',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('compiled') ?? $category->compiled,
                                'message'         => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-input-horizontal', [
                'name'      => 'owner',
                'value'     => old('owner') ?? $category->owner,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'wikipedia',
                'label'     => 'wikipedia',
                'value'     => old('wikipedia') ?? $category->wikipedia,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $category->link,
                'name' => old('link_name') ?? $category->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $category->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'image'   => old('image') ?? $category->image,
                'credit'  => old('image_credit') ?? $category->image_credit,
                'source'  => old('image_source') ?? $category->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'thumbnail',
                'value'     => old('thumbnail') ?? $category->thumbnail,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'   => old('public') ?? $category->public,
                'readonly' => old('readonly') ?? $category->readonly,
                'root'     => old('root') ?? $category->root,
                'disabled' => old('disabled') ?? $category->disabled,
                'demo'     => old('demo') ?? $category->demo,
                'sequence' => old('sequence') ?? $category->sequence,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.dictionary.index')
            ])

        </form>

    </div>

@endsection
