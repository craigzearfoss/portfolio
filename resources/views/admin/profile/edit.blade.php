@extends('admin.layouts.default', [
    'title' => 'Edit My Profile',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'My Profile',      'url' => route('admin.profile.show') ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-key"></i> Change Password', 'url' => '<a class="btn btn-sm btn-solid" href="' . route('admin.profile.change-password', $admin->id) . '">' ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',     'url' => Request::header('referer') ?? route('admin.profile.show') ],
    ],
    'errors' => $errors ?? [],
    'success' => session('success') ?? null,
    'error' => session('error') ?? null,
])

@section('content')

    <div class="card form-container p-4">

        <form action="{{ route('admin.admin.update', $admin) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => Request::header('referer')
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'username',
                'value'     => old('username') ?? $admin->username,
                'required'  => true,
                'disabled'  => true,
                'minlength' => 8,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $admin->name,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'phone',
                'value'     => old('phone') ?? $admin->phone,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'email',
                'name'      => 'email',
                'value'     => old('email') ?? $admin->email,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'image',
                'value'   => old('image') ?? $admin->image,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'image_credit',
                'label'     => 'image credit',
                'value'     => old('image_credit') ?? $admin->image_credit,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'image_source',
                'label'     => 'image source',
                'value'     => old('image_source') ?? $admin->image_source,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'thumbnail',
                'value'   => old('thumbnail') ?? $admin->thumbnail,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => Request::header('referer') ?? route('admin.profile.show')
            ])

        </form>

    </div>

@endsection
