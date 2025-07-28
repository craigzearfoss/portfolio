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

                                                <div class="mb-3">
                                                    <label for="name" class="form-label mb-1">name</label>
                                                    <input
                                                        type="text"
                                                        name="name"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        value="{{ old('name') }}"
                                                        placeholder="name"
                                                    >
                                                    @error('name')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="email" class="form-label mb-1">email</label>
                                                    <input
                                                        type="email"
                                                        name="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        value="{{ old('email') }}"
                                                        placeholder="email"
                                                    >
                                                    @error('email')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="password" class="form-label mb-1">password</label>
                                                    <input
                                                        type="password"
                                                        name="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        placeholder="password"
                                                        required
                                                    >
                                                    @error('password')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-4">
                                                    <label for="confirm_password" class="form-label mb-1">confirm password</label>
                                                    <input
                                                        type="password"
                                                        name="confirm_password"
                                                        class="form-control @error('confirm_password') is-invalid @enderror"
                                                        placeholder="confirm password"
                                                        required
                                                    >
                                                    @error('confirm_password')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>


                                                <div class="mb-4">
                                                    <label for="status" class="form-label mb-1">status</label>
                                                    <input
                                                        type="number"
                                                        name="status"
                                                        value="{{ old('status') ?? '1' }}"
                                                        class="form-control @error('status') is-invalid @enderror"
                                                        placeholder="0-pending, 1-active"
                                                    >
                                                    @error('status')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-4">
                                                    <label for="disabled" class="form-label mb-1">disabled</label>
                                                    <input
                                                        type="number"
                                                        name="disabled"
                                                        value="{{ old('disabled') ?? '0' }}"
                                                        class="form-control @error('disabled') is-invalid @enderror"
                                                        placeholder="0-not disabled, 1-disabled"
                                                    >
                                                    @error('disabled')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <button type="submit" class="btn btn-sm btn-solid"><i class="fa-solid fa-floppy-disk"></i> Submit</button>

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
