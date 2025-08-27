@extends('admin.layouts.default', [
    'title' => 'Add New User',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Users', 'url' => route('admin.user.index')],
        [ 'name' => 'Create' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.user.index') ],
    ],
    'errors' => $errors ?? [],
    'success' => session('success') ?? null,
    'error' => session('error') ?? null,
])

@section('content')

    <div class="form-container">

        <form action="{{ route('admin.user.store') }}" method="POST">
            @csrf

            <div class="card">
                <div class="card-body p-4">

                    @include('admin.components.form-hidden', [
                        'name'  => Auth::guard('admin')->user()->id,
                        'value' => '0',
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'name',
                        'value'     => old('name') ?? '',
                        'required'  => true,
                        'minlength' => 6,
                        'maxlength' => 255,
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
            </div>

            @include('admin.components.form-select-horizontal', [
                'name'    => 'title',
                'value'   => old('title') ?? '',
                'list'    => \App\Models\User::titleListOptions(true, true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'street',
                'value'     => old('street') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'street2',
                'value'     => old('street2') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'city',
                'value'     => old('city') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'state',
                'value'   => old('state') ?? '',
                'list'    => \App\Models\State::listOptions(true, true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'zip',
                'value'     => old('zip') ?? '',
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'country',
                'value'   => old('country') ?? '',
                'list'    => \App\Models\Country::listOptions(true, true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'phone',
                'value'     => old('phone') ?? '',
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'website',
                'value'     => old('website') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'status',
                'value'   => old('status') ?? 0,
                'list'    => \App\Models\User::statusListOptions(),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'disabled',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('disabled') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => route('admin.user.index')
            ])

        </form>

    </div>

@endsection
