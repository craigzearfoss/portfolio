@extends('admin.layouts.default', [
    'title'            => 'Change password for ' . $user->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Users',           'href' => route('root.user.index') ],
        [ 'name' => 'Change Password' ],
    ],
    'buttons'          => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('root.user.index') ],
    ],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
])

@section('content')

    <div class="form-container container" style="width: 30em;">

        <form action="{{ route('root.user.change-password-submit', $user) }}"
              method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('root.user.index')
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
                    'cancel_url' => referer('root.user.index')
                ])
            </div>

        </form>

    </div>

@endsection
