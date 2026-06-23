@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $thisMessage = $thisMessage ?? null;

    $title    = $pageTitle ?? 'Edit Message: ' . $thisMessage->subject . ' (from ' . $thisMessage->name . ')' ;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                                       'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                            'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                                     'href' => route('admin.system.index') ],
        [ 'name' => 'Messages',                                                   'href' => route('admin.system.message.index') ],
        [ 'name' => $thisMessage->subject . ' (from ' . $thisMessage->name . ')', 'href' => route('admin.system.message.show', $thisMessage) ],
        [ 'name' => 'Edit' ],
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.system.message.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.message.update', array_merge([$thisMessage], request()->all())) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.message.index')
            ])

            @if ($isRootAdmin)
                @include('admin.components.favorites-box-form-input', [
                    'name'  => 'favorite_count',
                    'label' => 'favorites',
                    'value' => old('favorite_count') ?? $thisMessage->favorite_count,
                ])
            @endif

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $thisMessage['id'],
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'from_admin',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('from_admin') ?? $thisMessage['from_admin'],
                'message'         => $thisMessage ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $thisMessage['name'],
                'required'  => true,
                'maxlength' => 255,
                'message'   => $thisMessage ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'email',
                'name'      => 'email',
                'value'     => old('email') ??  $thisMessage['email'],
                'required'  => true,
                'maxlength' => 255,
                'message'   => $thisMessage ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'subject',
                'value'     => old('subject') ??  $thisMessage['subject'],
                'required'  => true,
                'maxlength' => 255,
                'message'   => $thisMessage ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'body',
                'value'   => old('body') ??  $thisMessage['body'],
                'message' => $thisMessage ?? '',
            ])

            <?php /*
            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? $thisMessage->is_public,
                'is_readonly' => old('is_readonly') ?? $thisMessage->is_readonly,
                'is_root'     => old('is_root')     ?? $thisMessage->root,
                'is_disabled' => old('is_disabled') ?? $thisMessage->is_disabled,
                'is_demo'     => old('is_demo')     ?? $thisMessage->is_demo,
                'sequence'    => old('sequence')    ?? $thisMessage->sequence,
                'message'     => $thisMessage           ?? '',
            ])
            */ ?>

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.message.index')
            ])

        </form>

    </div>

@endsection
