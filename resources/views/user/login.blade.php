@extends('user.layouts.empty', [
    'title' => 'Login',
    'breadcrumbs' => [],
    'buttons' => [],
    'errors'  => $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="columns is-centered mt-4 pt-4">
        <div class="card column is-5 mt-4">

            <form action="{{ route('admin.login-submit') }}" method="POST">
                @csrf

                <div class="column is-12">

                    @include('user.components.form-input', [
                        'type'        => 'email',
                        'name'        => 'username',
                        'label'       => 'Email',
                        'value'       => old('username'),
                        'placeholder' => 'name@example.com',
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
                        <a class="text-primary-600 hover:underline" href="{{ route('user.forgot-password') }}">Forgot Password?</a>
                    </div>

                    <div class="has-text-centered">
                        @include('admin.components.form-button-submit', [
                            'label'      => 'Login',
                            'cancel_url' => route('front.homepage')
                        ])
                    </div>

                </div>

            </form>

        </div>
    </div>

@endsection
