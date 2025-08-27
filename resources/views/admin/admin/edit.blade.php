@extends('admin.layouts.default', [
    'title' => $admin->username,
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

        <form action="{{ route('admin.admin.update', $admin->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-input-horizontal', [
                'name'      => 'username',
                'value'     => old('username') ?? $admin->username,
                'required'  => true,
                'minlength' => 6,
                'maxlength' => 200,
                'disabled'  => true,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $admin->name,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'email',
                'name'      => 'email',
                'value'     => old('email') ?? $admin->email,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'phone',
                'value'     => old('phone') ?? $admin->phone,
                'required'  => true,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'root',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('root') ?? $admin->root,
                'disabled'        => !\Auth::guard('admin')->user()->root,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'disabled',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('disabled') ?? $admin->disabled,
                'disabled'        => $admin->id === \Auth::guard('admin')->user()->id,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => route('admin.admin.index')
            ])

        </form>

    </div>

@endsection
