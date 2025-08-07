@extends('admin.layouts.homepage')

@section('content')

    <div class="page-container relative h-full flex flex-auto flex-col">
        <div class="h-full">
            <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0 h-full md:p-10">
                <div class="card min-w-[320px] md:min-w-[450px] card-shadow" role="presentation">
                    <div class="card-body md:p-6">
                        <div class="text-center">
                            <div class="logo">
                                <img class="mx-auto" src="{{ asset('images/site/logo-thumb-sm.png') }}" alt="site logo">
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">

                                @include('admin.components.messages', [$errors])

                            </div>
                            <div>
                                <form action="{{ route('admin.login_submit') }}" method="POST">
                                    @csrf
                                    <div class="form-container vertical">
                                        <div class="flex justify-between mb-3">
                                            <a class="btn btn-solid w-full"  href="{{ route('admin.login') }}">
                                                Admin Login
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @include('admin.components.footer')

            </div>
        </div>
    </div>

@endsection
