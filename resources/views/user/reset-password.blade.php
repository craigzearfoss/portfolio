@extends('user.layouts.empty', [
    'title'         => 'Set New Password',
    'breadcrumbs'   => [
        [ 'name' => 'Home', 'href' => route('system.index')],
    ],
    'buttons'       => [],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => null,
])

@section('content')

    <div class="is-fullwidth has-text-centered m4-4 pt-4">
        <h2 class="title">Set New Password</h2>
        <p>Your new password must be different from previous password.</p>
    </div>

    <div class="columns has-text-centered mt-4">

        <div class="card column is-7">

            @if (!config('app.open_enrollment'))

                <h4>We are not currently accepting new users.</h4>
                <p class="p-4">
                    <a class="btn btn-sm btn-solid" href="{{ route('system.index') }}"><i
                            class="fa fa-house"></i> Home</a>
                </p>

            @else

                <form action="{{ route('user.reset-password-submit', [$token, $email]) }}" method="POST">
                    @csrf

                    @include('user.components.form-input-horizontal', [
                        'type'      => 'password',
                        'name'      => 'password',
                        'label'     => 'New Password',
                        'value'     => '',
                        'required'  => true,
                        'maxlength' => 255,
                        'message'   => $message ?? '',
                    ])

                    @include('user.components.form-input-horizontal', [
                        'type'      => 'password',
                        'name'      => 'confirm_password',
                        'label'     => 'Confirm New Password',
                        'value'     => '',
                        'required'  => true,
                        'maxlength' => 255,
                        'message'   => $message ?? '',
                    ])

                    @include('user.components.form-button-submit-horizontal', [
                        'label' => 'Submit',
                    ])

                    <div class="mt-3 is-fullwidth has-text-centered">
                        <span>Already have an account?</span>
                        <a class="text-primary-600 hover:underline" href="{{ route('user.login') }}">User Login</a>
                        <a class="text-primary-600 hover:underline" href="{{ route('admin.login') }}">Admin Login</a>
                    </div>

                </form>

            @endif

        </div>

    </div>

@endsection
