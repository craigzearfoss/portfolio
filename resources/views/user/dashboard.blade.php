@extends('user.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('user.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('user.components.header')

                @include('user.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between">

                    <main class="h-full">
                        <div class="page-container relative h-full flex flex-auto flex-col px-4 sm:px-6 md:px-8 py-4 sm:py-6">
                            <div class="container mx-auto h-full">
                                <div id="welcome-page-0" class="welcome-page-section h-full flex flex-col items-center justify-center">
                                    <div class="text-center">
                                    <span class="avatar avatar-circle avatat-lg border-2 border-white dark:border-gray-800 shadow-lg" data-avatar-size="60" style="width: 150px; height: 150px; min-width: 60px; line-height: 60px;">
                                        <img class="avatar-img avatar-circle" src="{{asset('frontend/assets/img/avatars/thumb-2.jpg')}}" loading="lazy">
                                    </span>
                                    <!-- <img src="{{asset('frontend/assets/img/others/Laravel.png')}}" alt="Laravel Logo" class="mx-auto mb-8" style="width: 200px;"> -->
                                    <h3 class="mb-2">Welcome on board, {{ Auth::guard('web')->user()->name }}!</h3>
                                    <p class="text-base"> {{ Auth::guard('web')->user()->email }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>

                    @include('user.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
