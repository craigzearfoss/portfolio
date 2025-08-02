@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="page-container relative h-full flex flex-auto flex-col">
                    <div class="h-full">
                        <h3 class="card-header ml-3">Create User</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] card-shadow" role="presentation">
                                <div class="card-body md:p-5">
                                    <div class="text-center">
                                        <div class="mb-4">

                                            <div class="d-grid gap-2 d-md-flex justify-between">

                                                <?php /* @include('admin.components.messages', [$errors]) */ ?>
                                                @if ($errors->any())
                                                    @include('admin.components.error-message', ['message'=>'Fix the indicated errors before saving.'])
                                                @else
                                                    <div></div>
                                                @endif

                                                <div>
                                                    <a class="btn btn-sm btn-solid" href="{{ route('admin.user.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div>

                                            <form action="{{ route('admin.user.store') }}" method="POST">
                                                @csrf

                                                @include('admin.components.form-input', [
                                                    'name'      => 'name',
                                                    'value'     => old('name'),
                                                    'required'  => true,
                                                    'minlength' => 6,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'email',
                                                    'value'     => old('email'),
                                                    'required'  => true,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'type'        => 'password',
                                                    'name'        => 'password',
                                                    'value'       => old('password'),
                                                    'required'    => true,
                                                    'minlength'   => 8,
                                                    'maxlength'   => 255,
                                                    'message'     => $message ?? '',
                                                    'placeholder' => 'Password'
                                                ])

                                                @include('admin.components.form-input', [
                                                    'label'       => 'confirm password',
                                                    'type'        => 'password',
                                                    'name'        => 'confirm_password',
                                                    'value'       => old('confirm_password'),
                                                    'required'    => true,
                                                    'minlength'   => 8,
                                                    'maxlength'   => 255,
                                                    'message'     => $message ?? '',
                                                    'placeholder' => 'Confirm Password'
                                                ])

                                                @include('admin.components.form-select', [
                                                    'name'    => 'status',
                                                    'value'   => old('status'),
                                                    'list'    => \App\Models\User::statusListOptions(),
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'disabled',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('disabled'),
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-button-submit', [
                                                    'label' => 'Save',
                                                    'cancel_url' => route('admin.user.index')
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
