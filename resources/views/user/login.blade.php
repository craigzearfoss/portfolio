@extends('user.layouts.empty', [
    'title' => 'Login',
    'breadcrumbs' => [],
    'buttons' => [],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="edit-container card form-container p-4 is-6 container" style="width: 30em;">

        <div class="is-size-4 has-text-centered">
            User Login
        </div>

        <form action="{{ route('user.login-submit') }}" method="POST">
            @csrf

            @include('user.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('system.index')
            ])

            @include('user.components.form-input', [
                'name'        => 'username',
                'label'       => 'User Name',
                'value'       => old('username'),
                'placeholder' => 'User Name',
                'required'    => true,
                'maxlength'   => 255,
                'message'     => $message ?? '',
            ])

            @include('user.components.form-input', [
                'type'        => 'password',
                'name'        => 'password',
                'label'       => 'Password',
                'value'       => old('password'),
                'placeholder' => 'Password',
                'required'    => true,
                'maxlength'   => 255,
                'message'     => $message ?? '',
            ])

            <div class="has-text-centered my-3">
                <a class="text-primary-600 hover:underline" href="{{ route('system.forgot-password') }}">Forgot Password?</a>
                |
                <a class="text-primary-600 hover:underline" href="{{ route('system.forgot-username') }}">Forgot User Name?</a>
            </div>

            <div class="has-text-centered">
                @include('user.components.form-button-submit', [
                    'label'      => 'Login',
                    'cancel_url' => referer('system.index')
                ])
            </div>

        </form>
    </div>

@endsection
