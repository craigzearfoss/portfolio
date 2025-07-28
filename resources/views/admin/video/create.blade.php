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
                        <h3 class="card-header ml-3">Add Video</h3>
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
                                                    <a class="btn btn-sm btn-solid" href="{{ route('admin.video.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div>

                                            <form action="{{ route('admin.video.store') }}" method="POST">
                                                @csrf

                                                <div class="mb-3">
                                                    <label for="title" class="form-label mb-1">title</label>
                                                    <input
                                                        type="text"
                                                        name="title"
                                                        class="form-control @error('title') is-invalid @enderror"
                                                        value="{{ old('title') }}"
                                                        placeholder="title"
                                                        required
                                                    >
                                                    @error('title')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="year" class="form-label mb-1">year</label>
                                                    <input
                                                        type="number"
                                                        name="year"
                                                        class="form-control @error('year') is-invalid @enderror"
                                                        value="{{ old('year') }}"
                                                        placeholder="year"
                                                    >
                                                    @error('year')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="company" class="form-label mb-1">company</label>
                                                    <input
                                                        type="text"
                                                        name="company"
                                                        class="form-control @error('company') is-invalid @enderror"
                                                        value="{{ old('company') }}"
                                                        placeholder="company"
                                                    >
                                                    @error('company')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="credit" class="form-label mb-1">credit</label>
                                                    <input
                                                        type="text"
                                                        name="credit"
                                                        class="form-control @error('credit') is-invalid @enderror"
                                                        value="{{ old('credit') }}"
                                                        placeholder="credit"
                                                    >
                                                    @error('credit')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="location" class="form-label mb-1">location</label>
                                                    <input
                                                        type="text"
                                                        name="location"
                                                        class="form-control @error('location') is-invalid @enderror"
                                                        value="{{ old('location') }}"
                                                        placeholder="location"
                                                    >
                                                    @error('location')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="link" class="form-label mb-1">link</label>
                                                    <input
                                                        type="text"
                                                        name="link"
                                                        class="form-control @error('link') is-invalid @enderror"
                                                        value="{{ old('link') }}"
                                                        placeholder="link"
                                                    >
                                                    @error('link')
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
                                                        required
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
