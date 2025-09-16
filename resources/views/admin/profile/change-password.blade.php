@extends('admin.layouts.default', [
    'title' => 'Change Password',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Change Password' ],
    ],
    'buttons' => [],
    'errors' => $errors ?? [],
    'success' => session('success') ?? null,
    'error' => session('error') ?? null,
])

@section('content')

    <div class="card column is-5 p-4">

        <form action="{{ route('admin.profile.change-password-submit', $admin) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => Request::header('referer')
            ])

            <div class="column">

                @include('admin.components.form-input', [
                    'type'        => 'password',
                    'name'        => 'password',
                    'label'       => 'Password',
                    'placeholder' => 'New password',
                    'value'       => '',
                    'required'    => true,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                ])

                @include('admin.components.form-input', [
                    'type'        => 'password',
                    'name'        => 'confirm_password',
                    'label'       => 'Confirm Password',
                    'placeholder' => 'Confirm new password',
                    'value'       => '',
                    'required'    => true,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                ])

                @include('admin.components.form-button-submit', [
                    'label'      => 'Save',
                    'cancel_url' => Request::header('referer') ?? route('admin.index')
                ])

            </div>

        </form>

    </div>

@endsection
