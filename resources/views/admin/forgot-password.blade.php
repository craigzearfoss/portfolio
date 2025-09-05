@extends('admin.layouts.default', [
    'title' => 'Forgot Password',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
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

        <form action="{{ route('admin.forgot-password-submit') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="column">

                @include('admin.components.form-input', [
                    'type'        => 'email',
                    'name'        => 'email',
                    'placeholder' => 'Email',
                    'value'       => '',
                    'required'    => true,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                ])

                <div class="has-text-centered pt-4">

                    @include('admin.components.form-button-submit', [
                        'label'      => 'Save',
                        'cancel_url' => route('admin.index')
                    ])

                </div>

            </div>

        </form>

    </div>

@endsection
