@extends('user.layouts.empty', [
    'title'         => 'Login',
    'breadcrumbs'   => [],
    'buttons'       => [],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => null,
])

@section('content')

    <div class="edit-container card form-container p-4 is-6 container" style="width: 30em;">

        <div class="is-size-4 has-text-centered">
            User Login
        </div>

        @if (!config('app.user_login_enabled'))

            <div class="has-text-centered">
                <h4>User logins have been disabled.</h4>
                <p class="p-4">
                    <a class="btn btn-sm btn-solid" href="{{ route('home') }}"><i
                            class="fa fa-house"></i> Home</a>
                </p>
            </div>

        @else

            <form action="{{ route('user.login-submit') }}" method="POST">
                @csrf

                @include('user.components.form-hidden', [
                    'name'  => 'referer',
                    'value' => referer('home')
                ])

                @include('user.components.form-input', [
                    'name'        => 'username',
                    'label'       => 'User Name',
                    'value'       => $username ?? '',
                    'placeholder' => 'User Name',
                    'required'    => true,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                ])

                @include('user.components.form-input', [
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
                    <a class="text-primary-600 hover:underline" href="{{ route('user.forgot-password') }}">Forgot Password?</a>
                    |
                    <a class="text-primary-600 hover:underline" href="{{ route('user.forgot-username') }}">Forgot User Name?</a>
                </div>

                <div class="has-text-centered">
                    @include('user.components.form-button-submit', [
                        'label'      => 'Login',
                        'cancel_url' => referer('home')
                    ])
                </div>

            </form>

        @endif

    </div>

@endsection
