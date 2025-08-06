@extends('front.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('front.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('front.components.header')

                @include('front.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between">

                    <main class="h-full">
                        <div class="page-container relative h-full flex flex-auto flex-col px-4 sm:px-6 md:px-8 py-4 sm:py-6">
                            <div class="container mx-auto h-full">

                                <h2>Contact Us</h2>

                                @if (session('captcha_success'))
                                    <div class="alert alert-success">
                                        {{ session('captcha_success') }}
                                    </div>
                                @endif
                                @if ($errors->any())
                                    @if ($errors->count() > 1)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <div class="alert alert-danger">
                                            {{ $errors->first() }}
                                        </div>
                                    @endif
                                @endif

                                <hr class="hr mt-2 mb-1  border-b border-gray-700 dark:border-gray-700" style="padding: 1px;" />

                                <div class="container mt-5">
                                    <div class="row justify-content-center">
                                        <div class="col-md-8  max-w-[600px]">
                                            <form action="{{ route('contact-submit') }}" method="POST">
                                                @csrf

                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type=
                                                               "text" class="form-control" id="name" placeholder="Your Name" require>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email address</label>
                                                    <input type="email" class="form-control" id="email" placeholder="name@example.com" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="subject" class="form-label">Subject</label>
                                                    <input type="text" class="form-control" id="subject" placeholder="Subject" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="message" class="form-label">Message</label>
                                                    <textarea class="form-control" id="message" rows="5" placeholder="Your Message" required></textarea>
                                                </div>
                                                <div class="form-group mt-4 mb-4">
                                                    <div class="captcha">
                                                        <span>{!! App\Http\Controllers\CaptchaController::generateCaptcha(config('captcha.default.type')) !!}</span>
                                                        <button type="button" class="btn btn-danger reload" id="reload">↻</button>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                                                </div>
                                                <div class="d-grid gap-2">
                                                    <button
                                                        type="submit"
                                                        class="btn btn-solid btn-sm"
                                                        style="width:  120px;"
                                                    ><i class="fa fa-envelope"></i> Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </main>

                    @include('front.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
