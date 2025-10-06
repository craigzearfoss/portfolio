@extends('guest.layouts.default', [
    'title' => 'Forgot Password',
    'breadcrumbs' => [
        [ 'name' => 'Home', 'href' => route('guest.homepage') ],
        [ 'name' => 'Forgot Password' ],
    ],
    'buttons' => [],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')


    <div class="columns has-text-centered mt-4 pt-4">

        <div class="card column is-7 mt-4">

            <p>Enter your email address to receive a password reset link.</p>

            <form action="{{ route('guest.forgot-password-submit') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="column">

                    @include('guest.components.form-input', [
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

                        @include('guest.components.form-button-submit', [
                            'label'      => 'Submit',
                            'cancel_url' => route('guest.homepage')
                        ])

                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection
