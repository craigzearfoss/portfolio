@php
    $title    = 'Change password for ' . $user->name;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Users',           'href' => route('admin.system.user.index') ],
        [ 'name' => 'Change Password' ],
    ];

    // set navigation buttons
    $buttons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.system.user.index')])->render(),
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.system.user.show', $user) ],
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="form-container container" style="width: 30em;">

        <form action="{{ route('admin.system.user.change-password-submit', $user) }}"
              method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.user.show', $user)
            ])

            <div class="card p-4 mb-3">

                @include('admin.components.form-input', [
                    'type'        => 'password',
                    'name'        => 'password',
                    'label'       => 'new password',
                    'value'       => old('password'),
                    'required'    => true,
                    'minlength'   => 8,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                    'placeholder' => 'Password'
                ])

                @include('admin.components.form-input', [
                    'label'       => 'confirm password',
                    'type'        => 'password',
                    'name'        => 'confirm_password',
                    'label'       => 'confirm new password',
                    'value'       => '',
                    'required'    => true,
                    'minlength'   => 8,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                    'placeholder' => 'Confirm Password'
                ])

            </div>

            <div class="has-text-centered">
                @include('admin.components.form-button-submit-horizontal', [
                    'label'      => 'Save',
                    'cancel_url' => referer('admin.system.user.index')
                ])
            </div>

        </form>

    </div>

@endsection
