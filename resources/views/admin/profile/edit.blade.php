@extends('admin.layouts.default', [
    'title' => 'Edit My Profile',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'My Profile',      'href' => route('admin.profile.show') ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-key"></i> Change Password', 'href' => '<a class="btn btn-sm btn-solid" href="' . route('admin.profile.change-password', $admin->id) . '">' ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',     'href' => referer('admin.profile.show') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.admin.update', $admin) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.profile.show')
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
                'type'      => 'tel',
                'name'      => 'phone',
                'value'     => old('phone') ?? $admin->phone,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'email',
                'name'      => 'email',
                'value'     => old('email') ?? $admin->email,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'image'   => old('image') ?? $admin->image,
                'credit'  => old('image_credit') ?? $admin->image_credit,
                'source'  => old('image_source') ?? $admin->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'thumbnail',
                'value'     => old('thumbnail') ?? $admin->thumbnail,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.profile.show')
            ])

        </form>

    </div>

@endsection
