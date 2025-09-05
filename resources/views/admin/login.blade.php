@extends('admin.layouts.empty', [
    'title' => 'Login',
    'errors' => $errors ?? [],
    'success' => session('success') ?? null,
    'error' => session('error') ?? null,
])

@section('content')

    <div class="card column is-5 p-4">

        <form action="{{ route('admin.login-submit') }}" method="POST">
            @csrf

            <div class="column is-12">

                @include('admin.components.form-input', [
                    'name'        => 'username',
                    'label'       => 'User Name',
                    'value'       => old('username'),
                    'placeholder' => 'User Name',
                    'required'    => true,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                ])

                @include('admin.components.form-input', [
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
                    <a class="text-primary-600 hover:underline" href="{{ route('admin.forgot-password') }}">Forgot Password?</a>
                </div>

                <div class="has-text-centered">
                    @include('admin.components.form-button', [
                        'label'      => 'Login',
                        'class'      => 'button is-dark'
                    ])
                </div>

            </div>

        </form>

    </div>

@endsection
