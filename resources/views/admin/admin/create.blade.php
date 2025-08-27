@extends('admin.layouts.default', [
    'title' =>'Add New Admin',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Admins']
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.admin.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="form-container">

        <form action="{{ route('admin.admin.store') }}" method="POST">
            @csrf

            <div class="card p-4 mb-3">

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'username',
                    'value'     => old('username') ?? '',
                    'required'  => true,
                    'minlength' => 6,
                    'maxlength' => 200,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'email',
                    'name'      => 'email',
                    'value'     => old('email') ?? '',
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'        => 'password',
                    'name'        => 'password',
                    'value'       => old('password') ?? '',
                    'required'    => true,
                    'minlength'   => 8,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                    'placeholder' => 'Password'
                ])

                @include('admin.components.form-input-horizontal', [
                    'label'       => 'confirm password',
                    'type'        => 'password',
                    'name'        => 'confirm_password',
                    'value'       => old('confirm_password') ?? '',
                    'required'    => true,
                    'minlength'   => 8,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                    'placeholder' => 'Confirm Password'
                ])

            </div>

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'phone',
                'value'     => old('phone') ?? '',
                'required'  => true,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'disabled',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('disabled') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Add Admin',
                'cancel_url' => route('admin.admin.index')
            ])

        </form>

    </div>

@endsection
