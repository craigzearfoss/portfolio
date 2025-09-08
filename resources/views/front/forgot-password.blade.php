@extends('front.layouts.default', [
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

    <div class="card column is-6 p-4">

        <p>Please enter your email address to receive a password reset link.</p>

        <form action="{{ route('front.forgot-password-submit') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="column">

                @include('front.components.form-input', [
                    'type'        => 'email',
                    'name'        => 'email',
                    'placeholder' => 'Email',
                    'value'       => '',
                    'required'    => true,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                ])

                <div class="has-text-centered pt-4">

                    @include('front.components.form-button-submit', [
                        'label'      => 'Save',
                        'cancel_url' => route('front.index')
                    ])

                </div>

            </div>

        </form>

    </div>

@endsection
