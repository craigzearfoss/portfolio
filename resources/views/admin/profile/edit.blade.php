@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left_ORIGINAL')

            <div
                    class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="page-container relative h-full flex flex-auto flex-col">
                    <div class="h-full">
                        <h3 class="card-header ml-3">Edit My Profile</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] card-shadow" role="presentation">
                                <div class="card-body md:p-5">
                                    <div class="text-center">
                                        <div class="mb-4">

                                            <div class="d-grid gap-2 d-md-flex justify-between">

                                                @if ($errors->any())
                                                    @include('admin.components.error-message', ['message'=>'Fix the indicated errors before saving.'])
                                                @else
                                                    <div></div>
                                                @endif

                                                <div>
                                                    <a class="btn btn-sm btn-solid"  href="{{ route('admin.change_password', $admin->id) }}"><i class="fa fa-key"></i> Change Password</a>
                                                    <a class="btn btn-sm btn-solid" href="{{ route('admin.show') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="form-container">

                                            <form action="{{ route('admin.update') }}" method="POST">
                                                @csrf

                                                @include('admin.components.form-input', [
                                                    'name'      => 'username',
                                                    'value'     => old('username') ?? $admin->username,
                                                    'required'  => true,
                                                    'disabled'  => true,
                                                    'minlength' => 8,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'name',
                                                    'value'     => old('name') ?? $admin->name,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'phone',
                                                    'value'     => old('phone') ?? $admin->phone,
                                                    'maxlength' => 20,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'email',
                                                    'value'     => old('email') ?? $admin->email,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-button-submit', [
                                                    'label'      => 'Save',
                                                    'cancel_url' => route('admin.show')
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
                                    ``          ])

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

                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('admin.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
