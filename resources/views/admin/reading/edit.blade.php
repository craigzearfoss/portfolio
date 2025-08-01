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
                        <h3 class="card-header ml-3">Edit Reading</h3>
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
                                                    <a class="btn btn-sm btn-solid" href="{{ route('admin.reading.show', $reading) }}"><i class="fa fa-list"></i> Show</a>
                                                    <a class="btn btn-sm btn-solid" href="{{ route('admin.reading.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div>

                                            <form action="{{ route('admin.reading.update', $reading) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3">
                                                    <label for="inputTitle" class="form-label mb-1">title</label>
                                                    <input
                                                        type="text"
                                                        name="title"
                                                        id="inputTitle"
                                                        value="{{ $reading->title }}"
                                                        class="form-control @error('title') is-invalid @enderror"
                                                        placeholder=""
                                                        required
                                                    >
                                                    @error('title')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputAuthor" class="form-label mb-1">author</label>
                                                    <input
                                                        type="text"
                                                        name="author"
                                                        id="inputAuthor"
                                                        value="{{ $reading->author }}"
                                                        class="form-control @error('author') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('author')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <input type="hidden" name="paper" value="0">
                                                    <input
                                                        type="checkbox"
                                                        name="paper"
                                                        id="inputPaper"
                                                        class="form-check-input"
                                                        value="1"
                                                        {{ $reading->paper ? 'checked' : '' }}
                                                    >
                                                    <label for="inputPaper" class="form-check-label mb-1 font-semibold">paper</label>
                                                    @error('paper')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-4">
                                                    <input type="hidden" name="audio" value="0">
                                                    <input
                                                        type="checkbox"
                                                        name="audio"
                                                        id="inputAudio"
                                                        class="form-check-input"
                                                        value="1"
                                                        {{ $reading->audio ? 'checked' : '' }}
                                                    >
                                                    <label for="inputAudio" class="form-check-label mb-1 font-semibold">audio</label>
                                                    @error('audio')
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
                                                        {{ $reading->disabled ? 'checked' : '' }}
                                                    >
                                                    <label for="inputDisabled" class="form-check-label mb-1 font-semibold">disabled</label>
                                                    @error('disabled')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <button type="submit" class="btn btn-sm btn-solid"><i class="fa-solid fa-floppy-disk"></i> Update</button>

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
