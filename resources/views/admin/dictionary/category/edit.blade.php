@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $category    = $category ?? null;

    $title    = 'Edit Dictionary: ' . $category->name . ' (category)';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Categories',      'href' => route('admin.dictionary.category.index') ],
        [ 'name' => $category->name,   'href' => route('admin.dictionary.category.show', $category) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.dictionary.category.index')])->render()
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.dictionary.category.update', array_merge([$category], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.dictionary.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $category->id,
                    'hide'  => !$isRootAdmin,
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'full_name',
                    'label'     => 'full name',
                    'value'     => old('full_name') ?? $category->full_name,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'   => [ 'input-name' ],
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? $category->name,
                    'required'  => true,
                    'maxlength' => 100,
                    'message'   => $message ?? '',
                    'class'   => [ 'input-name' ],
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'abbreviation',
                    'value'     => old('abbreviation') ?? $category->abbreviation,
                    'maxlength' => 20,
                    'message'   => $message ?? '',
                    'class'   => [ 'input-abbreviation' ],
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'      => 'definition',
                    'value'     => old('definition') ?? $category->definition,
                    'maxlength' => 500,
                    'cols'      => 30,
                    'rows'      => 5,
                    'message'   => $message ?? '',
                    'class'     => [ 'textarea-definition' ],
                ])

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                    </div>
                    <div class="field-body">
                        <div class="field">

                            <div class="checkbox-container card form-container p-4" style="max-width: 26rem;">

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
                    'class'   => [ 'input-name' ],
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-input-horizontal', [
                    'name'        => 'wikipedia',
                    'label'       => 'wikipedia',
                    'value'       => old('wikipedia') ?? $category->wikipedia,
                    'maxlength'   => 500,
                    'placeholder' => 'wikipedia link',
                    'message'     => $message ?? '',
                    'class'       => [ 'input-link' ],
                ])

                @include('admin.components.form-link-horizontal', [
                    'link'    => old('link') ?? $category->link,
                    'name'    => old('link_name') ?? $category->link_name,
                    'message' => $message ?? '',
        ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $category->description,
                    'cols'    => 54,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-description' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.show-row-images', [
                    'resource' => $category,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $category->is_public,
                    'is_readonly' => old('is_readonly') ?? $category->is_readonly,
                    'is_root'     => old('is_root')     ?? $category->root,
                    'is_disabled' => old('is_disabled') ?? $category->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $category->is_demo,
                    'sequence'    => old('sequence')    ?? $category->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.dictionary.index')
        ])

    </form>

@endsection
