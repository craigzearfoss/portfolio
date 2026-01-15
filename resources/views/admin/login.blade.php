@extends('admin.layouts.default', [
    'title'            => 'Login',
    'breadcrumbs'      => [],
    'buttons'          => [],
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
])

@section('content')

    <div class="edit-container card form-container p-4 is-6 container" style="width: 30em;">

        <div class="is-size-4 has-text-centered">
            Admin Login
        </div>

        @if (!config('app.admin_login_enabled'))

            <div class="has-text-centered">
                <h4>Admin logins have been disabled.</h4>
                <p class="p-4">
                    <a class="btn btn-sm btn-solid" href="{!! route('admin.index') !!}"><i
                            class="fa fa-house"></i> Home</a>
                </p>
            </div>

        @else

            <form action="{!! route('admin.login-submit') !!}" method="POST">
                @csrf

                @include('admin.components.form-hidden', [
                    'name'  => 'referer',
                    'value' => referer('admin.index')
                ])

                @include('admin.components.form-input', [
                    'name'        => 'username',
                    'label'       => 'User Name',
                    'value'       => $username ?? '',
                    'placeholder' => 'User Name',
                    'required'    => true,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                ])

                @include('admin.components.form-input', [
                    'type'        => 'password',
                    'name'        => 'password',
                    'label'       => 'Password',
                    'value'       => '',
                    'placeholder' => 'Password',
                    'required'    => true,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                ])

                <div class="has-text-centered my-3">
                    <a class="text-primary-600 hover:underline" href="{!! route('admin.forgot-password') !!}">Forgot Password?</a>
                </div>

                <div class="has-text-centered">
                    @include('admin.components.form-button-submit', [
                        'label'      => 'Login',
                        'cancel_url' => referer('admin.index')
                    ])
                </div>

            </form>

        @endif

    </div>

@endsection
