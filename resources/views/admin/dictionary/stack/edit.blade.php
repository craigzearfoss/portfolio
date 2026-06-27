@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $stack       = $stack ?? null;

    $title    = 'Edit Dictionary: ' . $stack->name . ' (stack)';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Stacks',          'href' => route('admin.dictionary.stack.index') ],
        [ 'name' => $stack->name,      'href' => route('admin.dictionary.stack.show', $stack) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.dictionary.stack.index')])->render()
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.dictionary.stack.update', array_merge([$stack], request()->all())) }}"
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
                    'value' => $stack->id,
                    'hide'  => !$isRootAdmin,
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'full_name',
                    'label'     => 'full name',
                    'value'     => old('full_name') ?? $stack->full_name,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ],
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? $stack->name,
                    'required'  => true,
                    'maxlength' => 100,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ],
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'abbreviation',
                    'value'     => old('abbreviation') ?? $stack->abbreviation,
                    'maxlength' => 20,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-abbreviation' ],
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'      => 'definition',
                    'value'     => old('definition') ?? $stack->definition,
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
                                    'checked'         => old('open_source') ?? $stack->open_source,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'proprietary',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('proprietary') ?? $stack->proprietary,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'compiled',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('compiled') ?? $stack->compiled,
                                    'message'         => $message ?? '',
                                ])

                            </div>

                        </div>
                    </div>
                </div>

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'owner',
                    'value'     => old('owner') ?? $stack->owner,
                    'maxlength' => 100,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ],
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-input-horizontal', [
                    'name'        => 'wikipedia',
                    'label'       => 'wikipedia',
                    'value'       => old('wikipedia') ?? $stack->wikipedia,
                    'maxlength'   => 500,
                    'placeholder' => 'wikipedia link',
                    'message'     => $message ?? '',
                    'class'       => [ 'input-link' ],
                ])

                @include('admin.components.form-link-horizontal', [
                    'link'    => old('link') ?? $stack->link,
                    'name'    => old('link_name') ?? $stack->link_name,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $stack->description,
                    'cols'    => 54,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-description' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.show-row-images', [
                    'resource' => $stack,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $stack->is_public,
                    'is_readonly' => old('is_readonly') ?? $stack->is_readonly,
                    'is_root'     => old('is_root')     ?? $stack->root,
                    'is_disabled' => old('is_disabled') ?? $stack->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $stack->is_demo,
                    'sequence'    => old('sequence')    ?? $stack->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.dictionary.index')
        ])

    </form>

@endsection
