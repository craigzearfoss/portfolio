@extends('admin.layouts.empty', [
    'title' => 'Login',
    'errors' => $errors ?? [],
    'success' => session('success') ?? null,
    'error' => session('error') ?? null,
])

@section('content')

    <div class="card form-container p-4">

        <form action="{{ route('admin.profile.change-password-submit', $admin) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="column is-5">

                <input class="input pr-8" type="password" name="password" placeholder="Password">
                @include('admin.components.form-input', [
                    'type'        => 'password',
                    'name'        => 'password',
                    'label'       => 'Password',
                    'placeholder' => 'New password',
                    'value'       => '',
                    'required'    => true,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                ])

                @include('admin.components.form-input', [
                    'type'        => 'password',
                    'name'        => 'confirm_password',
                    'label'       => 'Confirm Password',
                    'placeholder' => 'Confirm new password',
                    'value'       => '',
                    'required'    => true,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                ])

                @include('admin.components.form-button-submit', [
                    'label'      => 'Save',
                    'cancel_url' => route('admin.index')
                ])

            </div>

        </form>

    </div>

@endsection


@extends('user.layouts.login')

@section('content')

    <div class="page-container relative h-full flex flex-auto flex-col">
        <div class="h-full">
            <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0 h-full">
                <div class="card min-w-[320px] md:min-w-[450px] card-shadow" role="presentation">
                    <div class="card-body md:p-10">
                        <div class="text-center">
                            <div class="logo">
                                <img class="mx-auto" src="{{ asset('images/site/logo-thumb-sm.png') }}" alt="site logo">
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <h3 class="mb-1">Welcome back.</h3>
                                <p>Please enter your credentials to Login.</p>

                                @include('user.components.messages', [$errors])

                            </div>
                            <div>
                                <form action="{{ route('user.login-submit') }}" method="POST">
                                    @csrf
                                    <div class="form-container vertical">
                                        <div class="form-item vertical mb-3">
                                            <label class="form-label mb-1">Email</label>
                                            <div>
                                                <input class="input" type="email" name="email" value="{{ old('email') }}" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-item vertical mb-3">
                                            <label class="form-label mb-1">Password</label>
                                            <div>
                                                <span class="input-wrapper">
                                                    <input class="input pr-8" type="password" name="password" placeholder="Password">
                                                    <div class="input-suffix-end">
                                                        <span class="cursor-pointer text-xl">
                                                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex justify-between mb-3">
                                            <a class="text-primary-600 hover:underline" href="{{ route('user.<div class="card p-4">') }}">Forgot Password?</a>
                                        </div>
                                        <button class="btn btn-solid w-full" type="submit">Login</button>
                                        <div class="mt-4 text-center">
                                            <span>Don't have an account yet?</span>
                                            <a class="text-primary-600 hover:underline" href="{{ route('user.register') }}">Register</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
