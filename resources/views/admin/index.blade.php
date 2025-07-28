@extends('admin.layouts.homepage')

@section('content')

    <div class="page-container relative h-full flex flex-auto flex-col">
        <div class="h-full">
            <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0 h-full">
                <div class="card min-w-[320px] md:min-w-[450px] card-shadow" role="presentation">
                    <div class="card-body md:p-10">
                        <div class="text-center">
                            <div class="logo">
                                <img class="mx-auto" src="{{asset('backend/assets/img/logo/logo-light-streamline.png')}}" alt="Elstar logo">
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <h3 class="mb-1">Admin</h3>

                                @include('admin.components.messages', [$errors])

                            </div>
                            <div>
                                <a href="{{route('admin.login')}}" class="form-container vertical">
                                    <button class="btn btn-solid w-full" type="button">Login</button>
                                </a>
                            </div>
                        </div>
                    </div>

                    @include('admin.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
