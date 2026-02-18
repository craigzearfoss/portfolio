@php
    $loginEnabled  = config('app.user_login_enabled');
    $isDemoEnabled = config('app.demo_user_enabled');
    $demoUsername  = config('app.demo_user_username');
    $demoPassword  = config('app.demo_user_password');
    $demoAutologin = config('app.demo_user_autologin');
@endphp
@extends('user.layouts.default', [
    'title'            => $pageTitle ?? 'Login',
    'breadcrumbs'      => [],
    'buttons'          => [],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="edit-container card form-container p-4 is-6 container" style="width: 30em;">

        <div class="is-size-4 has-text-centered">
            User Login
        </div>

        @if (!config('app.user_login_enabled'))

            <div class="has-text-centered">
                <h4>User logins have been disabled.</h4>
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

            <form action="{{ route('user.login-submit') }}" method="POST">
                @csrf

                @include('user.components.form-hidden', [
                    'name'  => 'referer',
                    'value' => referer('home')
                ])

                @include('user.components.form-input', [
                    'name'        => 'username',
                    'label'       => 'User Name',
                    'value'       => $username ?? '',
                    'placeholder' => 'User Name',
                    'required'    => true,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                ])

                @include('user.components.form-input', [
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
                        'href'       => route('user.forgot-password'),
                        'style'      => 'text-primary-600 hover:underline',
                        'cancel_url' => referer('admin.index')
                    ])

                    |

                    @include('admin.components.link', [
                        'name'       => 'Forgot User Name?',
                        'href'       => route('user.forgot-username'),
                        'style'      => 'text-primary-600 hover:underline',
                        'cancel_url' => referer('admin.index')
                    ])

                </div>

                <div class="has-text-centered">
                    @include('user.components.form-button-submit', [
                        'label'      => 'Login',
                        'cancel_url' => referer('home')
                    ])
                </div>

            </form>

        @endif

    </div>

@endsection
