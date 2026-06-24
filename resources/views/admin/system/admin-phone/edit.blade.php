@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $adminPhone    = $adminPhone ?? null;

    $title    = !$isRootAdmin
        ? str_replace('AdminPhone', 'Phone', 'Edit ' . getResourcePageTitle($adminPhone))
        : 'Edit ' . getResourcePageTitle($adminPhone);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                   'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                        'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                 'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'Admin Phones' : 'Phones', 'href' => route('admin.system.admin-phone.index') ],
        [ 'name' => $adminPhone->phone,                       'href' => route('admin.system.admin-phone.show', $adminPhone) ],
        [ 'name' => 'Edit' ],
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-phone.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.system.admin-phone.update', array_merge([$adminPhone], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.system.admin-phone.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $adminPhone->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $adminPhone->id,
                    'hide'  => !$isRootAdmin,
                ])

                <?php /* note that you CANNOT change the owner of an admin phone */ ?>
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $adminPhone->owner_id
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'phone',
                    'value'     => old('phone') ?? $adminPhone->phone,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'label',
                    'value'     => old('label') ?? $adminPhone->label,
                    'maxlength' => 100,
                    'message'   => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $adminPhone->description,
                    'message' => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'id'      => 'inputNotes',
                    'value'   => old('notes') ?? $adminPhone->notes,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $adminPhone->is_public,
                    'is_readonly' => old('is_readonly') ?? $adminPhone->is_readonly,
                    'is_root'     => old('is_root')     ?? $adminPhone->is_root,
                    'is_disabled' => old('is_disabled') ?? $adminPhone->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $adminPhone->is_demo,
                    'sequence'    => old('sequence')    ?? $adminPhone->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.system.admin-phone.index')
        ])

    </form>

@endsection
