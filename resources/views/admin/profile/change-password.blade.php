@php
    $title    = $pageTitle ?? 'Change Password';

    // set breadcrumbs
    $subtitle = $title;

    // set navigation buttons
    $buttons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.profile.index')])->render(),
    ];

    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.index') ],
        [ 'name' => 'My Profile',      'href' => route('admin.profile.show') ],
        [ 'name' => 'Change Password' ],
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

<div class="container has-text-centered">

    <div class="card p-4" style="width: 30em; display: inline-block">

        <form action="{{ route('admin.profile.change-password-submit') }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.profile.index')
            ])

            <div class="column">

                @include('admin.components.form-input', [
                    'type'        => 'password',
                    'name'        => 'password',
                    'label'       => 'Password',
                    'placeholder' => 'New password',
                    'value'       => '',
                    'required'    => true,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                ])

                @include('admin.components.form-input', [
                    'type'        => 'password',
                    'name'        => 'confirm_password',
                    'label'       => 'Confirm Password',
                    'placeholder' => 'Confirm new password',
                    'value'       => '',
                    'required'    => true,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                ])

                @include('admin.components.form-button-submit', [
                    'label'      => 'Save',
                    'cancel_url' => referer('admin.index')
                ])

            </div>

        </form>

    </div>
</div>
@endsection
