@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $thisOwner   = $thisOwner ?? null;

    $title    = $pageTitle ?? 'Change Password for '
        . 'admin ' . $thisOwner->name . ' (username: ' . $thisOwner->username . ')';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',               'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',    'href' => route('admin.dashboard') ],
        [ 'name' => 'Admins',             'href' => route('admin.system.admin.index') ],
        [ 'name' => $thisOwner->username, 'href' => route('admin.system.admin.show', $thisOwner) ],
        [ 'name' => 'Change Password' ],
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.system.admin.show', $thisOwner)])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

<div class="container has-text-centered">

    <div class="card p-4" style="width: 30em; display: inline-block">

        <form action="{{ route('admin.system.admin.change-password-submit', $thisOwner) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.profile.index')
            ])

            <div class="column">

                @include('admin.components.form-input-with-icon', [
                    'type'        => 'password',
                    'name'        => 'password',
                    'label'       => 'New Password',
                    'placeholder' => 'New password',
                    'value'       => '',
                    'required'    => true,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                ])

                @include('admin.components.form-input-with-icon', [
                    'type'        => 'password',
                    'name'        => 'confirm_password',
                    'label'       => 'Confirm New Password',
                    'placeholder' => 'Confirm new password',
                    'value'       => '',
                    'required'    => true,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                ])

                @include('admin.components.form-button-submit', [
                    'label'      => 'Save',
                    'cancel_url' => referer('admin.system.admin.show', $thisOwner)
                ])

            </div>

        </form>

    </div>
</div>
@endsection
