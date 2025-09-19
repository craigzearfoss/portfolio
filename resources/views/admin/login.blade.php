@extends('admin.layouts.empty', [
    'title'       => 'Login',
    'breadcrumbs' => [],
    'buttons'     => [],
    'errors'  => $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="columns has-text-centered mt-4 pt-4">

        <div class="card column is-5 mt-4">

            <div class="is-size-4 has-text-centered">
                Admin Login
            </div>

            <form action="{{ route('admin.login-submit') }}" method="POST">
                @csrf

                @include('admin.components.form-hidden', [
                    'name'  => 'referer',
                    'value' => referer('admin.index')
                ])

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
                        @include('admin.components.form-button-submit', [
                            'label'      => 'Login',
                            'cancel_url' => referer('admin.index')
                        ])
                    </div>

                </div>

            </form>

        </div>
    </div>

@endsection
