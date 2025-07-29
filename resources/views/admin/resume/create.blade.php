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
                        <h3 class="card-header ml-3">Add Resume</h3>
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
                                                    <a class="btn btn-sm btn-solid" href="{{ route('admin.resume.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div>

                                            <form action="{{ route('admin.resume.store') }}" method="POST">
                                                @csrf

                                                <div class="mb-3">
                                                    <label for="inputName" class="form-label mb-1">name</label>
                                                    <input
                                                        type="text"
                                                        name="name"
                                                        id="inputName"
                                                        value="{{ old('name') }}"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        placeholder=""
                                                        required
                                                    >
                                                    @error('name')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputLink" class="form-label mb-1">link</label>
                                                    <input
                                                        type="text"
                                                        name="link"
                                                        id="inputLink"
                                                        value="{{ old('link') }}"
                                                        class="form-control @error('link') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('link')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputAltLink" class="form-label mb-1">alt link</label>
                                                    <input
                                                        type="text"
                                                        name="alt_link"
                                                        id="inputAltLink"
                                                        value="{{ old('alt_link') }}"
                                                        class="form-control @error('alt_link') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('alt_link')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputDescription" class="form-label mb-1">description</label>
                                                    <input
                                                        type="text"
                                                        name="description"
                                                        id="inputDescription"
                                                        value="{{ old('description') }}"
                                                        class="form-control @error('description') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('description')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-4">
                                                    <input type="hidden" name="primary" value="0">
                                                    <input
                                                        type="checkbox"
                                                        name="primary"
                                                        id="inputPrimary"
                                                        class="form-check-input"
                                                        value="1"
                                                        {{ old('primary') ? 'checked' : '' }}
                                                    >
                                                    <label for="inputPrimary" class="form-check-label mb-1 font-semibold">primary</label>
                                                    @error('primary')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-4">
                                                    <input type="hidden" name="public" value="0">
                                                    <input
                                                        type="checkbox"
                                                        name="public"
                                                        id="inputPublic"
                                                        class="form-check-input"
                                                        value="1"
                                                        {{ old('public') ? 'checked' : '' }}
                                                    >
                                                    <label for="inputPublic" class="form-check-label mb-1 font-semibold">public</label>
                                                    @error('public')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-4">
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
