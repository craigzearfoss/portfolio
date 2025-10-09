@extends('admin.layouts.default', [
    'title'       => '',
    'breadcrumbs' => [],
    'buttons'     => [],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="edit-container card form-container p-4 is-6 container" style="max-width: 30em;">

        <div class="is-size-4 has-text-centered">
            Set new password
        </div>

        <p class="has-text-centered">
            Your new password must be different from previous password.
        </p>

        <form action="{{ route('admin.reset-password-submit', [$token, $email]) }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.index')
            ])

            @include('admin.components.form-input', [
                'type'        => 'password',
                'name'        => 'password',
                'label'       => 'New Password',
                'value'       => old('username'),
                'placeholder' => 'New Password',
                'required'    => true,
                'maxlength'   => 255,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'type'        => 'password',
                'name'        => 'confirm_password',
                'label'       => 'Confirm New Password',
                'value'       => old('confirm_password'),
                'placeholder' => 'Confirm New Password',
                'required'    => true,
                'maxlength'   => 255,
                'message'     => $message ?? '',
            ])

            <div class="has-text-centered">
                @include('admin.components.form-button-submit', [
                    'label' => 'Submit',
                ])
            </div>

            <div class="mt-4 has-text-centered">
                <span>Back to</span>
                <a class="text-primary-600 hover:underline" href="{{ route('admin.login') }}">Login</a>
            </div>

        </form>

    </div>

@endsection
