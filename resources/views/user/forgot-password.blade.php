@extends('user.layouts.default', [
    'pageTitle'   => 'Forgot Password',
    'title'       => '',
    'breadcrumbs' => [
        [ 'name' => 'Home', 'href' => route('system.index') ],
        [ 'name' => 'Forgot Password' ],
    ],
    'buttons' => [],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="edit-container card form-container p-4 is-6 container" style="max-width: 30em;">

        <div class="is-size-4 has-text-centered">
            Forgot password
        </div>

        <p class="has-text-centered">
            Enter your email address to receive a password reset link.
        </p>

        <form action="{{ route('system.forgot-password-submit') }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => Request::header('referer')
            ])

            <div class="column">

                @include('user.components.form-input', [
                    'type'        => 'email',
                    'name'        => 'email',
                    'label'       => null,
                    'placeholder' => 'Email',
                    'value'       => '',
                    'required'    => true,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                ])

                <div class="has-text-centered pt-4">

                    @include('user.components.form-button-submit', [
                        'label'      => 'Submit',
                        'cancel_url' => referer('system.index')
                    ])

                </div>

            </div>

        </form>

    </div>

@endsection
