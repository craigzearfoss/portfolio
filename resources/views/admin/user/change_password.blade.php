@extends('admin.layouts.default', [
    'title' => 'Change password for ' . $user->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Users',           'url' => route('admin.user.index') ],
        [ 'name' => 'Change Password' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => referer('admin.user.index') ],
    ],
    'errors' => $errors ?? [],
    'success' => session('success') ?? null,
    'error' => session('error') ?? null,
])

@section('content')

    <div class="form-container">

        <form action="{{ route('admin.user.change-password-submit', $user) }}"
              method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.user.index')
            ])

            <div class="card p-4 mb-3">

                @include('admin.components.form-input-horizontal', [
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

                @include('admin.components.form-input-horizontal', [
                    'label'       => 'confirm password',
                    'type'        => 'password',
                    'name'        => 'confirm_password',
                    'label'       => 'confirm new password',
                    'value'       => old('confirm_password'),
                    'required'    => true,
                    'minlength'   => 8,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                    'placeholder' => 'Confirm Password'
                ])

            </div>
            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.user.index')
            ])

        </form>

    </div>

@endsection
