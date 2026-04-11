@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $adminPhone    = $adminPhone ?? null;

    $title    = $pageTitle ?? ($isRootAdmin ? 'Edit Admin Phone: ' . $adminPhone->phone : 'Edit Phone: ' . $adminPhone->phone);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                                  'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                       'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                                'href' => route('admin.system.index',
                                                                                             !empty($owner)
                                                                                                 ? ['owner_id'=>$owner->id]
                                                                                                 : []
                                                                                             )],
        [ 'name' => $isRootAdmin ? 'Admin Phone Numbers' : 'Phone Numbers', 'href' => route('admin.system.admin-phone.index', ['owner_id'=>$owner->id]) ],
        [ 'name' => $adminPhone->phone, 'href' => route('admin.system.admin-phone.show', [$adminPhone, 'owner_id'=>$owner->id]) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.system.admin-phone.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.admin-phone.update', array_merge([$adminPhone], request()->all())) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.admin-phone.index')
            ])

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

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $adminPhone->description,
                'message' => $message ?? '',
            ])

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

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.admin-phone.index')
            ])

        </form>

    </div>

@endsection
