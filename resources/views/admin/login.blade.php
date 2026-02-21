@php
    use App\Enums\EnvTypes;

    // set breadcrumbs
    $title    = $pagTitle ?? 'Admin Login';
    $subtitle = false;

    // set breadcrumbs
    $breadcrumbs = [];

    $buttons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4 is-6 container" style="width: 30em;">

        <div class="is-size-4 has-text-centered">
            Admin Login
        </div>

        @if (!config('app.admin_login_enabled'))

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

            @if(config('app.demo_admin_autologin'))

                <div class="p-2 has-text-centered">
                    <p class="mb-1">
                        To log in as the <strong>demo</strong> admin use the credentials below.
                    </p>
                    <code class=" has-text-primary">{{ config('app.demo_admin_username') }} / {{ config('app.demo_admin_password') }}</code>
                </div>

            @endif

            <form id="frmMain" action="{{ route('admin.login-submit') }}" method="POST">
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

                <div class="form-group mt-4">
                    @error('g-recaptcha-response')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="g-recaptcha" data-sitekey="{{ config('captcha.sitekey') }}" data-action="LOGIN"></div>
                </div>

                @php( $captchaEnabled = config('app.recaptcha_enabled'))
                <div class="has-text-centered">
                    @include('admin.components.form-button-submit', [
                        'label'      => 'Login',
                        'cancel_url' => referer('admin.index'),
                        'class'      => !empty($captchaEnabled) ? 'g-captcha' : null,
                        'props'      => !empty($captchaEnabled)
                                            ? [
                                                'data-sitekey'  =>  config('app.app.google_recaptcha_key'),
                                                'data-callback' => 'onSubmit',
                                                'data-action'   => 'submit',
                                              ]
                                            : []
                    ])
                </div>

                <div class="has-text-centered my-3">
                    @include('admin.components.link', [
                        'name'       => 'Forgot Password?',
                        'href'       => route('admin.forgot-password'),
                        'style'      => 'text-primary-600 hover:underline',
                        'cancel_url' => referer('admin.index')
                    ])
                </div>

            </form>

        @endif

    </div>

@endsection
