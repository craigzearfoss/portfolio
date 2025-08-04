@extends('user.layouts.login')

@section('content')

    <div class="page-container relative h-full flex flex-auto flex-col">
        <div class="h-full">
            <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0 h-full">
                <div class="card min-w-[320px] md:min-w-[450px] card-shadow" role="presentation">
                    <div class="card-body md:p-10">
                        <div class="text-center">
                            <div class="logo">
                                <img class="mx-auto" src="{{asset('images/site/logo-thumb-sm.png')}}" alt="site logo">
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <h3 class="mb-1">Forgot Password</h3>
                                <p>Please enter your email address to receive a password reset link.</p>

                                @include('user.components.messages', [$errors])

                            </div>
                            <div>
                                <form action="{{route('forgot_password_submit')}}" method="POST">
                                    @csrf
                                    <div class="form-container vertical">
                                        <div class="form-item vertical">
                                            <input class="input" type="email" name="email" value="{{ old('email') }}" placeholder="Email">
                                        </div>
                                        <button class="btn btn-solid w-full" type="submit">Send Email</button>
                                        <div class="mt-4 text-center">
                                            <span>Back to </span>
                                            <a class="text-primary-600 hover:underline" href="{{route('login')}}">Login</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
