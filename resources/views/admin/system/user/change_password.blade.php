@extends('admin.layouts.default', [
    'title' => 'Change password for ' . $user->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('guest.homepage') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Users',           'href' => route('admin.system.user.index') ],
        [ 'name' => 'Change Password' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.system.user.index') ],
    ],
    'errorMessages' => $errors->any() ? ['Fix the indicated errors before saving.'] : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="form-container">

        <form action="{{ route('admin.system.user.change-password-submit', $user) }}"
              method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.user.index')
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
                    'value'       => '',
                    'required'    => true,
                    'minlength'   => 8,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                    'placeholder' => 'Confirm Password'
                ])

            </div>
            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.user.index')
            ])

        </form>

    </div>

@endsection
