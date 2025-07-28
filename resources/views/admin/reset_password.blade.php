@extends('admin.layouts.login')

@section('content')

    <div class="page-container relative h-full flex flex-auto flex-col">
        <div class="h-full">
            <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0 h-full">
                <div class="card min-w-[320px] md:min-w-[450px] card-shadow" role="presentation">
                    <div class="card-body md:p-10">
                        <div class="text-center">
                            <div class="logo">
                                <img class="mx-auto" src="{{ asset('backend/assets/img/logo/logo-light-streamline.png') }}" alt="Elstar logo">
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <h3 class="mb-1">Set new password</h3>
                                <p>Your new password must be different from previous password.</p>

                                @include('admin.components.messages', [$errors])

                            </div>
                            <div>
                                <form action="{{ route('admin.reset_password_submit', [$token, $email]) }}" method="POST">
                                    @csrf
                                    <div class="form-container vertical">
                                        <div class="form-item vertical">
                                            <label class="form-label mb-2">New Password</label>
                                            <div>
                                                <span class="input-wrapper">
                                                    <input class="input pr-8" type="password" name="password" placeholder="New Password">
                                                    <div class="input-suffix-end">
                                                        <span class="cursor-pointer text-xl">
                                                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-item vertical">
                                            <label class="form-label mb-2">Confirm New Password</label>
                                            <div>
                                                <span class="input-wrapper">
                                                    <input class="input pr-8" type="password" name="confirm_password" placeholder="Confirm New Password">
                                                    <div class="input-suffix-end">
                                                        <span class="cursor-pointer text-xl">
                                                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                        <button class="btn btn-solid w-full" type="submit">Submit</button>
                                        <div class="mt-4 text-center">
                                            <span>Back to</span>
                                            <a class="text-primary-600 hover:underline" href="{{ route('admin.login') }}">Login</a>
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
