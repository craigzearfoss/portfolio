@extends('user.layouts.login')

@section('content')

    <div class="page-container relative h-full flex flex-auto flex-col">
        <div class="h-full">
            <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0 h-full">
                <div class="card min-w-[320px] md:min-w-[450px] card-shadow" role="presentation">
                    <div class="card-body md:p-10">
                        <div class="text-center">
                            <div class="logo">
                                <img class="mx-auto" src="{{ asset('images/site/logo-thumb-sm.png') }}" alt="site logo">
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <h3 class="mb-1">Register New User</h3>

                                <?php /*
                                @include('user.components.messages', [$errors])
                                */ ?>

                                @if (!empty($errors))
                                    @include('user.components.message-info', ['message' => 'Please fix the indicated problems.'])
                                @endif


                                <div class="form-container">

                                    @if (!config('app.open_enrollment'))

                                        <h4>We are not currently accepting new users.</h4>
                                        <p class="p-4">
                                            <a class="btn btn-sm btn-solid" href="{{ route('front.homepage') }}"><i
                                                    class="fa fa-house"></i> Home</a>
                                        </p>

                                    @else

                                        <form action="{{ route('user.register_submit') }}" method="POST">
                                            @csrf

                                            @include('user.components.form-input', [
                                                'name'      => 'name',
                                                'label'     => 'Name',
                                                'value'     => old('name'),
                                                'required'  => true,
                                                'minlength' => 6,
                                                'maxlength' => 255,
                                                'message'   => $message ?? '',
                                            ])

                                            @include('user.components.form-input', [
                                                'type'      => 'email',
                                                'name'      => 'email',
                                                'label'     => 'Email',
                                                'value'     => old('email'),
                                                'required'  => true,
                                                'maxlength' => 255,
                                                'message'   => $message ?? '',
                                            ])

                                            @include('user.components.form-input', [
                                                'type'      => 'password',
                                                'name'      => 'password',
                                                'label'     => 'Password',
                                                'value'     => '',
                                                'required'  => true,
                                                'maxlength' => 255,
                                                'message'   => $message ?? '',
                                            ])

                                            @include('user.components.form-input', [
                                                'type'      => 'password',
                                                'name'      => 'confirm_password',
                                                'label'     => 'Confirm Password',
                                                'value'     => '',
                                                'required'  => true,
                                                'maxlength' => 255,
                                                'message'   => $message ?? '',
                                            ])

                                            @include('user.components.form-button-submit', [
                                                'label' => 'Submit',
                                            ])

                                            <div class="mt-3 text-center">
                                                <span>Already have an account?</span>
                                                <a class="text-primary-600 hover:underline" href="{{ route('user.login') }}">Login</a>
                                            </div>

                                        </form>

                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
