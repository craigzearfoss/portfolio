@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $adminEmail    = $adminEmail ?? null;

    $title    = !$isRootAdmin
        ? str_replace('AdminEmail', 'Email', 'Edit ' . getResourcePageTitle($adminEmail))
        : 'Edit ' . getResourcePageTitle($adminEmail);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                   'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                        'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                 'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'Admin Emails' : 'Emails', 'href' => route('admin.system.admin-email.index') ],
        [ 'name' => $adminEmail->email,                       'href' => route('admin.system.admin-email.show', $adminEmail) ],
        [ 'name' => 'Edit' ],
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-email.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.system.admin-email.update', array_merge([$adminEmail], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.system.admin-email.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $adminEmail->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $adminEmail->id,
                    'hide'  => !$isRootAdmin,
                ])

                <?php /* note that you CANNOT change the owner of an admin email */ ?>
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $adminEmail->owner_id
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'email',
                    'value'     => old('email') ?? $adminEmail->email,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'label',
                    'value'     => old('label') ?? $adminEmail->label,
                    'maxlength' => 100,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $adminEmail->description,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'id'      => 'inputNotes',
                    'value'   => old('notes') ?? $adminEmail->notes,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $adminEmail->public,
                    'is_readonly' => old('is_readonly') ?? $adminEmail->is_readonly,
                    'is_root'     => old('is_root')     ?? $adminEmail->root,
                    'is_disabled' => old('is_disabled') ?? $adminEmail->disabled,
                    'is_demo'     => old('is_demo')     ?? $adminEmail->is_demo,
                    'sequence'    => old('sequence')    ?? $adminEmail->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.system.admin-email.index')
        ])

    </form>

@endsection
