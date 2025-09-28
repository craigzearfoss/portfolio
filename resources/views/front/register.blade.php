@extends('front.layouts.empty', [
    'title' => 'Register',
    'breadcrumbs' => [
        [ 'name' => 'Home', 'href' => route('front.homepage') ],
        [ 'name' => 'Register' ],
    ],
    'buttons' => [],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="is-fullwidth has-text-centered m4-4 pt-4">
        <h2 class="title">Register New User</h2>
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

                <form action="{{ route('front.register-submit') }}" method="POST">
                    @csrf

                    @include('front.components.form-input-horizontal', [
                        'name'      => 'username',
                        'label'     => 'User Name',
                        'value'     => old('username'),
                        'required'  => true,
                        'minlength' => 6,
                        'maxlength' => 255,
                        'message'   => $message ?? '',
                    ])

                    <p class="is-xs mt-0 mb-2 has-text-right">
                        <i>User name can contain letters, numbers, underscores, and dashes.</i>
                    </p>

                    @include('front.components.form-input-horizontal', [
                        'name'      => 'name',
                        'label'     => 'Name',
                        'value'     => old('name'),
                        'required'  => true,
                        'minlength' => 6,
                        'maxlength' => 255,
                        'message'   => $message ?? '',
                    ])

                    @include('front.components.form-input-horizontal', [
                        'type'      => 'email',
                        'name'      => 'email',
                        'label'     => 'Email',
                        'value'     => old('email'),
                        'required'  => true,
                        'maxlength' => 255,
                        'message'   => $message ?? '',
                    ])

                    @include('front.components.form-input-horizontal', [
                        'type'      => 'password',
                        'name'      => 'password',
                        'label'     => 'Password',
                        'value'     => '',
                        'required'  => true,
                        'maxlength' => 255,
                        'message'   => $message ?? '',
                    ])

                    @include('front.components.form-input-horizontal', [
                        'type'      => 'password',
                        'name'      => 'confirm_password',
                        'label'     => 'Confirm Password',
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
