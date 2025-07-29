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
                        <h3 class="card-header ml-3">Create Admin</h3>
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
                                                    <a class="btn btn-sm btn-solid" href="{{ route('admin.admin.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div>

                                            <form action="{{ route('admin.admin.store') }}" method="POST">
                                                @csrf

                                                <div class="mb-3">
                                                    <label for="inputUsername" class="form-label mb-1">user name</label>
                                                    <input
                                                        type="text"
                                                        name="username"
                                                        id="inputUsername"
                                                        value="{{ old('username') }}"
                                                        class="form-control @error('username') is-invalid @enderror"
                                                        placeholder=""
                                                        required
                                                    >
                                                    @error('username')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputEmail" class="form-label mb-1">email</label>
                                                    <input
                                                        type="email"
                                                        name="email"
                                                        id="inputEmail"
                                                        value="{{ old('email') }}"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        placeholder=""
                                                        required
                                                    >
                                                    @error('email')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputPassword" class="form-label mb-1">Password</label>
                                                    <input
                                                        type="password"
                                                        name="password"
                                                        id="inputPassword"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        placeholder="Password"
                                                        required
                                                    >
                                                    @error('password')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputConfirm_password" class="form-label mb-1">Confirm Password</label>
                                                    <input
                                                        type="password"
                                                        name="confirm_password"
                                                        id="inputConfirm_password"
                                                        class="form-control @error('confirm_password') is-invalid @enderror"
                                                        placeholder="Confirm Password"
                                                        required
                                                    >
                                                    @error('confirm_password')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <input type="hidden" name="disabled" value="0">
                                                    <input
                                                        type="checkbox"
                                                        name="disabled"
                                                        id="inputDisabled"
                                                        class="form-check-input"
                                                        value="1"
                                                        {{ old('disabled') ? 'checked' : '' }}
                                                    >
                                                    <label for="inputDisabled" class="form-check-label mb-1 font-semibold">disabled</label>
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
