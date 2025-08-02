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

                                <h2>Contact</h2>

                                <hr class="hr mt-2 mb-1  border-b border-gray-700 dark:border-gray-700" style="padding: 1px;" />

                                <div>

                            </div>
                        </div>
                    </main>

                    @include('front.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
