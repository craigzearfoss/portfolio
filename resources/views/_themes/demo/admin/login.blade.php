@extends('admin.layouts.default', [
    'title'       => '',
    'breadcrumbs' => [],
    'buttons'     => [],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="edit-container card form-container p-4 is-6 container" style="width: 30em;">

        <div class="is-size-4 has-text-centered">
            Admin Login
        </div>

        @if(!empty(config('app.demo')) && !empty(config('app.demo_admin_username')) && !empty(config('app.demo_admin_password')))
            <div class="p-2 has-text-centered">
                Log in as the demo admin with the<br>User Name and Password shown below.
            </div>
        @endif

        <form action="{{ route('admin.login-submit') }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.index')
            ])

            @include('admin.components.form-input', [
                'name'        => 'username',
                'label'       => 'User Name',
                'value'       => old('username') ?? (config('app.demo_admin_enabled') ? config('app.demo_admin_username') : ''),
                'placeholder' => 'User Name',
                'required'    => true,
                'maxlength'   => 255,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-input', [
                //'type'        => 'password',
                'name'        => 'password',
                'label'       => 'Password',
                'value'       => old('password') ?? (config('app.demo_admin_enabled') ? config('app.demo_admin_password') : ''),
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

        </form>
    </div>

@endsection
