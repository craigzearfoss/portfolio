@extends('guest.layouts.empty', [
    'title' => 'Login',
    'breadcrumbs' => [],
    'buttons' => [],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')


    <div class="is-fullwidth has-text-centered m4-4 pt-4">
        <h2 class="title"> User Login</h2>
    </div>

    <div class="columns has-text-centered mt-4">

        <div class="card column is-5 mt-4">

            <form action="{{ route('guest.login-submit') }}" method="POST">
                @csrf

                <div class="column is-12">

                    @include('guest.components.form-input', [
                        'name'        => 'username',
                        'label'       => 'User Name',
                        'value'       => old('username'),
                        'placeholder' => 'name@example.com',
                        'required'    => true,
                        'maxlength'   => 255,
                        'message'     => $message ?? '',
                    ])

                    @include('guest.components.form-input', [
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
                        <a class="text-primary-600 hover:underline" href="{{ route('guest.forgot-password') }}">Forgot Password?</a>
                        |
                        <a class="text-primary-600 hover:underline" href="{{ route('guest.forgot-username') }}">Forgot User Name?</a>
                    </div>

                    <div class="has-text-centered">
                        @include('guest.components.form-button-submit', [
                            'label'      => 'Login',
                            'cancel_url' => route('guest.homepage')
                        ])
                    </div>

                </div>

            </form>

        </div>
    </div>

@endsection
