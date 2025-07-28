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
                        <h3 class="card-header ml-3">Edit Video</h3>
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
                                                    <a class="btn btn-sm btn-solid" href="{{ route('admin.video.show', $video) }}"><i class="fa fa-list"></i> Show</a>
                                                    <a class="btn btn-sm btn-solid" href="{{ route('admin.video.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div>

                                            <form action="{{ route('admin.video.update', $video->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3">
                                                    <label for="inputTitle" class="form-label mb-1">title</label>
                                                    <input
                                                        type="text"
                                                        name="title"
                                                        id="inputTitle"
                                                        value="{{ $video->title }}"
                                                        class="form-control @error('title') is-invalid @enderror"
                                                        placeholder="title"
                                                    >
                                                    @error('title')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-4">
                                                    <label for="inputYear" class="form-label mb-1">year</label>
                                                    <input
                                                        type="number"
                                                        name="year"
                                                        id="inputYear"
                                                        value="{{ $video->year }}"
                                                        class="form-control @error('year') is-invalid @enderror"
                                                        placeholder="year"
                                                    >
                                                    @error('year')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-4">
                                                    <label for="inputCompany" class="form-label mb-1">company</label>
                                                    <input
                                                        type="text"
                                                        name="company"
                                                        id="inputCompany"
                                                        value="{{ $video->company }}"
                                                        class="form-control @error('company') is-invalid @enderror"
                                                        placeholder="company"
                                                    >
                                                    @error('company')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-4">
                                                    <label for="inputCredit" class="form-label mb-1">credit</label>
                                                    <input
                                                        type="text"
                                                        name="credit"
                                                        id="inputCredit"
                                                        value="{{ $video->credit }}"
                                                        class="form-control @error('credit') is-invalid @enderror"
                                                        placeholder="credit"
                                                    >
                                                    @error('credit')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-4">
                                                    <label for="inputLocation" class="form-label mb-1">location</label>
                                                    <input
                                                        type="text"
                                                        name="location"
                                                        id="inputLocation"
                                                        value="{{ $video->location }}"
                                                        class="form-control @error('location') is-invalid @enderror"
                                                        placeholder="location"
                                                    >
                                                    @error('location')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-4">
                                                    <label for="inputLink" class="form-label mb-1">link</label>
                                                    <input
                                                        type="text"
                                                        name="link"
                                                        id="inputLink"
                                                        value="{{ $video->link }}"
                                                        class="form-control @error('link') is-invalid @enderror"
                                                        placeholder="link"
                                                    >
                                                    @error('link')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-4">
                                                    <label for="inputDescription" class="form-label mb-1">description</label>
                                                    <textarea
                                                        name="description"
                                                        id="inputDescription
                                                        "
                                                        class="form-control"
                                                        rows="3">{{ $video->description }}</textarea>
                                                    @error('description')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-4 justify-end">
                                                    <input type="hidden" name="disabled" value="0">
                                                    <input
                                                        type="checkbox"
                                                        name="disabled"
                                                        id="inputDisabled"
                                                        class="form-check-input"
                                                        value="1"
                                                        {{ $video->disabled ? 'checked' : '' }}
                                                    >
                                                    <label for="inputDisabled" class="form-check-label mb-1 font-semibold">disabled</label>
                                                    @error('disabled')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <button type="submit" class="btn btn-sm btn-solid btn-sm"><i class="fa-solid fa-floppy-disk"></i> Update</button>

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
