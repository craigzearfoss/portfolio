@extends('guest.layouts.empty', [
    'title' => 'Forgot User Name',
    'breadcrumbs' => [
        [ 'name' => 'Home', 'href' => route('guest.homepage') ],
        [ 'name' => 'Forgot User Name' ],
    ],
    'buttons' => [],
    'errorMessages'=> $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="is-fullwidth has-text-centered m4-4 pt-4">
        <h2 class="title">Forgot User Name</h2>
    </div>

    <div class="columns has-text-centered mt-4">

        <div class="card column is-7">

            <p>Enter your email address to receive an email with your user name.</p>

            <form action="{{ route('guest.forgot-username-submit') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="column">

                    @include('guest.components.form-input', [
                        'type'        => 'email',
                        'name'        => 'email',
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
