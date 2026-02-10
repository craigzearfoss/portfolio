@php
    $loginEnabled  = config('app.admin_login_enabled');
    $isDemoEnabled = config('app.demo_admin_enabled');
    $demoUsername  = config('app.demo_admin_username');
    $demoPassword  = config('app.demo_admin_password');
    $demoAutologin = config('app.demo_admin_autologin');
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Login',
    'breadcrumbs'      => [],
    'buttons'          => [],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="edit-container card form-container p-4 is-6 container" style="width: 30em;">

        <div class="is-size-4 has-text-centered">
            Admin Login
        </div>

        @if (!$loginEnabled)

            <div class="has-text-centered">
                <h4>Admin logins have been disabled.</h4>
                <p class="p-4">
                    @include('admin.components.link', [ 'name' => 'Home',
                                                        'href' => route('admin.index'),
                                                        'icon' => 'fa-house'
                    ])
                </p>
            </div>

        @else

            @if($demoAutologin)

                <div class="p-2 has-text-centered">
                    <p class="mb-1">
                        To log in as the <strong>demo</strong> admin use the credentials below.
                    </p>
                    <code class=" has-text-primary">{{ $demoUsername }} / {{ $demoPassword }}</code>
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
                    @include('admin.components.link', [
                        'name'       => 'Forgot Password?',
                        'href'       => route('admin.forgot-password'),
                        'style'      => 'text-primary-600 hover:underline',
                        'cancel_url' => referer('admin.index')
                    ])
                </div>

                <div class="form-group mt-4">
                    @error('g-recaptcha-response')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="g-recaptcha" data-sitekey="{{ config('captcha.sitekey') }}" data-action="LOGIN"></div>
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
