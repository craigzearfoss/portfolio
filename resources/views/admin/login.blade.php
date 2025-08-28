@extends('admin.layouts.blank')

@section('content')

    <div>

        <div class="card" style="max-width: 400px;">

            <div class="card-header p-4">
                <div class="is-widescreen has-text-centered">
                    <img class="mx-auto" src="{{ asset('images/site/logo-thumb-sm.png') }}" alt="site logo">
                </div>
                <div>
                <h1 class="mb-1">Welcome back.</h1>
                    <p>Please enter your credentials to login.</p>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="form">

                    <form action="{{ route('admin.login_submit') }}" method="POST">
                        @csrf

                        <div>

                            @include('admin.components.form-input', [
                                'name'        => 'username',
                                'label'       => 'user name',
                                'value'       => old('username'),
                                'placeholder' => 'User Name',
                                'required'    => true,
                                'maxlength'   => 255,
                                'message'     => $message ?? '',
                            ])

                            @include('admin.components.form-input', [
                                'name'        => 'password',
                                'value'       => old('password'),
                                'label'       => 'Password',
                                'required'    => true,
                                'maxlength'   => 255,
                                'message'     => $message ?? '',
                            ])

                        </div>

                        <div class="my-3">
                            <a class="text-primary-600 hover:underline" href="{{ route('admin.forgot_password') }}">Forgot Password?</a>
                        </div>

                        <div>

                            @include('admin.components.form-button', [
                                'label'      => 'Login',
                            ])

                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>

@endsection
