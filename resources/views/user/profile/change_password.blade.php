@extends('user.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('user.components.nav-left')

            <div
                class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('user.components.header')

                @include('user.components.popup')

                <div class="page-container relative h-full flex flex-auto flex-col">
                    <div class="h-full">
                        <h3 class="card-header ml-3">Change Password</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] card-shadow" role="presentation">
                                <div class="card-body md:p-5">
                                    <div class="text-center">
                                        <div class="mb-4">

                                            <div class="d-grid gap-2 d-md-flex justify-between">

                                                @if ($errors->any())
                                                    @include('user.components.error-message', ['message'=>'Fix the indicated errors before saving.'])
                                                @else
                                                    <div></div>
                                                @endif

                                                <div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="form-container">

                                            <form action="{{ route('user.change_password_submit') }}" method="POST">
                                                @csrf

                                                @include('user.components.form-input', [
                                                    'type'        => 'password',
                                                    'name'        => 'password',
                                                    'label'       => 'Password',
                                                    'placeholder' => 'New password',
                                                    'value'       => '',
                                                    'required'    => true,
                                                    'maxlength'   => 255,
                                                    'message'     => $message ?? '',
                                                ])

                                                @include('user.components.form-input', [
                                                    'type'        => 'password',
                                                    'name'        => 'confirm_password',
                                                    'label'       => 'Confirm Password',
                                                    'placeholder' => 'Confirm new password',
                                                    'value'       => '',
                                                    'required'    => true,
                                                    'maxlength'   => 255,
                                                    'message'     => $message ?? '',
                                                ])

                                                @include('user.components.form-button-submit', [
                                                    'label'      => 'Save',
                                                    'cancel_url' => route('user.show')
                                                ])

                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('user.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
