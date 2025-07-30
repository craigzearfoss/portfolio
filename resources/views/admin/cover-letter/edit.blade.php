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
                        <h3 class="card-header ml-3">Edit Cover Letter</h3>
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
                                                    <a class="btn btn-sm btn-solid" href="{{ route('admin.cover-letter.show', $coverLetter) }}"><i class="fa fa-list"></i> Show</a>
                                                    <a class="btn btn-sm btn-solid" href="{{ route('admin.cover-letter.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div>

                                            <form action="{{ route('admin.cover-letter.update', $coverLetter) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3">
                                                    <label for="inputName" class="form-label mb-1">name</label>
                                                    <input
                                                        type="text"
                                                        name="name"
                                                        id="inputName"
                                                        value="{{ $coverLetter->name }}"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        placeholder=""
                                                        required
                                                    >
                                                    @error('name')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputRecipient" class="form-label mb-1">recipient(s)</label>
                                                    <input
                                                        type="text"
                                                        name="recipient"
                                                        id="inputRecipient"
                                                        value="{{ $coverLetter->recipient }}"
                                                        class="form-control @error('recipient') is-invalid @enderror"
                                                        placeholder=""
                                                        required
                                                    >
                                                    @error('recipient')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputDate" class="form-label mb-1">date</label>
                                                    <input
                                                        type="date"
                                                        name="date"
                                                        id="inputDate"
                                                        value="{{ $coverLetter->date }}"
                                                        class="form-control @error('date') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('date')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputLink" class="form-label mb-1">link</label>
                                                    <input
                                                        type="text"
                                                        name="link"
                                                        id="inputLink"
                                                        value="{{ $coverLetter->link }}"
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
                                                        value="{{ $coverLetter->alt_link }}"
                                                        class="form-control @error('alt_link') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('alt_link')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <input type="hidden" name="primary" value="0">
                                                    <input
                                                        type="checkbox"
                                                        name="primary"
                                                        id="inputPrimary"
                                                        class="form-check-input"
                                                        value="1"
                                                        {{ $coverLetter->primary ? 'checked' : '' }}
                                                    >
                                                    <label for="inputPrimary" class="form-check-label mb-1 font-semibold">primary</label>
                                                    @error('primary')
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
                                                        {{ $coverLetter->disabled ? 'checked' : '' }}
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
