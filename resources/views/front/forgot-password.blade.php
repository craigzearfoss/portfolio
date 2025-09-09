@extends('front.layouts.empty', [
    'title' => 'Forgot Password',
    'breadcrumbs' => [
        [ 'name' => 'Home', 'url' => route('front.homepage') ],
        [ 'name' => 'Forgot Password' ],
    ],
    'buttons' => [],
    'errors'  => $errors ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="is-fullwidth has-text-centered m4-4 pt-4">
        <h2 class="title">Forgot Password</h2>
    </div>

    <div class="columns is-centered mt-4">

        <div class="card column is-7">

            <p>Enter your email address to receive a password reset link.</p>

            <form action="{{ route('front.forgot-password-submit') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="column">

                    @include('front.components.form-input', [
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

                        @include('front.components.form-button-submit', [
                            'label'      => 'Save',
                            'cancel_url' => route('front.homepage')
                        ])

                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection
