@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $adminEmail    = $adminEmail ?? null;

    $title    = $pageTitle ?? ($isRootAdmin ? 'Edit Admin Email: ' . $adminEmail->email : 'Edit Email: ' . $adminEmail->email);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',             'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
        [ 'name' => 'System',           'href' => route('admin.system.index',
                                                        !empty($owner)
                                                            ? ['owner_id'=>$owner->id]
                                                            : []
                                                       )],
        [ 'name' => $isRootAdmin ? 'Admin Email Addresses' : 'Email Addresses', 'href' => route('admin.system.admin-email.index', ['owner_id'=>$owner->id]) ],
        [ 'name' => $adminEmail->email, 'href' => route('admin.system.admin-email.show', [$adminEmail, 'owner_id'=>$owner->id]) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.system.admin-email.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.admin-email.update', array_merge([$adminEmail], request()->all())) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.admin-email.index')
            ])

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

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.admin-email.index')
            ])

        </form>

    </div>

@endsection
