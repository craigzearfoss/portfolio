@extends('front.layouts.empty', [
    'title' => 'Set New Password',
    'breadcrumbs' => [
        [ 'name' => 'Home', 'url' => route('front.homepage') ],
        [ 'name' => 'Set New Password' ],
    ],
    'buttons' => [],
    'errorMessages'=> $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
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
                    <a class="btn btn-sm btn-solid" href="{{ route('front.homepage') }}"><i
                            class="fa fa-house"></i> Home</a>
                </p>

            @else

                <form action="{{ route('front.reset-password-submit', [$token, $email]) }}" method="POST">
                    @csrf

                    @include('front.components.form-input-horizontal', [
                        'type'      => 'password',
                        'name'      => 'password',
                        'label'     => 'New Password',
                        'value'     => '',
                        'required'  => true,
                        'maxlength' => 255,
                        'message'   => $message ?? '',
                    ])

                    @include('front.components.form-input-horizontal', [
                        'type'      => 'password',
                        'name'      => 'confirm_password',
                        'label'     => 'Confirm New Password',
                        'value'     => '',
                        'required'  => true,
                        'maxlength' => 255,
                        'message'   => $message ?? '',
                    ])

                    @include('front.components.form-button-submit-horizontal', [
                        'label' => 'Submit',
                    ])

                    <div class="mt-3 is-fullwidth has-text-centered">
                        <span>Already have an account?</span>
                        <a class="text-primary-600 hover:underline" href="{{ route('front.login') }}">Login</a>
                    </div>

                </form>

            @endif

        </div>

    </div>

@endsection
