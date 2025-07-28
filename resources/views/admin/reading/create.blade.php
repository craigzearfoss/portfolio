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
                        <h3 class="card-header ml-3">Add Reading</h3>
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
                                                    <a class="btn btn-sm btn-solid" href="{{ route('admin.reading.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div>

                                            <form action="{{ route('admin.reading.store') }}" method="POST">
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
                                                    <label for="email" class="form-label mb-1">author</label>
                                                    <input
                                                        type="text"
                                                        name="author"
                                                        class="form-control @error('author') is-invalid @enderror"
                                                        value="{{ old('author') }}"
                                                        placeholder="author"
                                                    >
                                                    @error('author')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-4">
                                                    <label for="paper" class="form-label mb-1">paper</label>
                                                    <input
                                                        type="number"
                                                        name="paper"
                                                        value="{{ old('paper') ?? '1' }}"
                                                        class="form-control @error('paper') is-invalid @enderror"
                                                        placeholder="1"
                                                        required
                                                    >
                                                    @error('paper')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-4">
                                                    <label for="audio" class="form-label mb-1">audio</label>
                                                    <input
                                                        type="number"
                                                        name="audio"
                                                        value="{{ old('audio') ?? '0' }}"
                                                        class="form-control @error('audio') is-invalid @enderror"
                                                        placeholder="0"
                                                        required
                                                    >
                                                    @error('audio')
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
