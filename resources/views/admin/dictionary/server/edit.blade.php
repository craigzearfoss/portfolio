@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $server      = $server ?? null;

    $title    = 'Edit Dictionary: ' . $server->name . ' (server)';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Servers',         'href' => route('admin.dictionary.server.index') ],
        [ 'name' => $server->name,     'href' => route('admin.dictionary.server.show', $server) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.dictionary.server.index')])->render()
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.dictionary.server.update', array_merge([$server], request()->all())) }}"
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
                    'value' => $server->id,
                    'hide'  => !$isRootAdmin,
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'full_name',
                    'label'     => 'full name',
                    'value'     => old('full_name') ?? $server->full_name,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ],
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? $server->name,
                    'required'  => true,
                    'maxlength' => 100,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ],
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'abbreviation',
                    'value'     => old('abbreviation') ?? $server->abbreviation,
                    'maxlength' => 20,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-abbreviation' ],
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'      => 'definition',
                    'value'     => old('definition') ?? $server->definition,
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
                                    'checked'         => old('open_source') ?? $server->open_source,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'proprietary',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('proprietary') ?? $server->proprietary,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'compiled',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('compiled') ?? $server->compiled,
                                    'message'         => $message ?? '',
                                ])

                            </div>

                        </div>
                    </div>
                </div>

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'owner',
                    'value'     => old('owner') ?? $server->owner,
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
                    'value'       => old('wikipedia') ?? $server->wikipedia,
                    'maxlength'   => 500,
                    'placeholder' => 'wikipedia link',
                    'message'     => $message ?? '',
                    'class'       => [ 'input-link' ],
                ])

                @include('admin.components.form-link-horizontal', [
                    'link'    => old('link') ?? $server->link,
                    'name'    => old('link_name') ?? $server->link_name,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $server->description,
                    'cols'    => 54,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-description' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.show-row-images', [
                    'resource' => $server,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $server->is_public,
                    'is_readonly' => old('is_readonly') ?? $server->is_readonly,
                    'is_root'     => old('is_root')     ?? $server->root,
                    'is_disabled' => old('is_disabled') ?? $server->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $server->is_demo,
                    'sequence'    => old('sequence')    ?? $server->sequence,
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
