@extends('admin.layouts.default', [
    'title' =>'Add New Admin',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Admins',          'href' => route('admin.admin.index') ],
        [ 'name' => 'Add' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => referer('admin.admin.index') ],
    ],
    'errorMessages' => $errors->any() ? ['Fix the indicated errors before saving.'] : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card form-container p-4">

        <form action="{{ route('admin.admin.store') }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.admin.index')
            ])

            <div class="card p-4 mb-3">

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'username',
                    'label'     => 'user name',
                    'value'     => old('username') ?? '',
                    'required'  => true,
                    'minlength' => 6,
                    'maxlength' => 200,
                    'message'   => $message ?? '',
                ])

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

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'email',
                    'name'      => 'email',
                    'value'     => old('email') ?? '',
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-file-upload-horizontal', [
                    'name'    => 'image',
                    'value'   => old('image') ?? '',
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'image_credit',
                    'label'     => 'image credit',
                    'value'     => old('image_credit') ?? '',
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'image_source',
                    'label'     => 'image source',
                    'value'     => old('image_source') ?? '',
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-file-upload-horizontal', [
                    'name'    => 'thumbnail',
                    'value'   => old('thumbnail') ?? '',
                    'message' => $message ?? '',
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

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'public',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('public') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'readonly',
                'label'           => 'read-only',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('readonly') ?? 0,
                'message'         => $message ?? '',
            ])

            @if (Auth::guard('admin')->user()->root)
                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'root',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('root') ?? 0,
                    'message'         => $message ?? '',
                ])
            @endif

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'disabled',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('disabled') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Add Admin',
                'cancel_url' => referer('admin.admin.index')
            ])

        </form>

    </div>

@endsection
