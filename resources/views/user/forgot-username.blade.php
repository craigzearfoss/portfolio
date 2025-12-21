@extends('user.layouts.default', [
    'pageTitle'     => 'Forgot User Name',
    'title'         => '',
    'breadcrumbs'   => [
        [ 'name' => 'Home', 'href' => route('system.index') ],
        [ 'name' => 'Forgot User Name' ],
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

    <div class="edit-container card form-container p-4 is-6 container" style="max-width: 30em;">

        <div class="is-size-4 has-text-centered">
            Forgot user name
        </div>

        <p class="has-text-centered">
            Enter your email address to receive an email with your user name.
        </p>

       <form action="{{ route('user.forgot-username-submit') }}" method="POST">
            @csrf
            @method('PUT')

            @include('user.components.form-hidden', [
                'name'  => 'referer',
                'value' => Request::header('referer')
            ])

            <div class="column">

                @include('user.components.form-input', [
                    'type'        => 'email',
                    'name'        => 'email',
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
