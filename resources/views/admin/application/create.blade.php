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
                        <h3 class="card-header ml-3">Add Application</h3>
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
                                                    <a class="btn btn-sm btn-solid" href="{{ route('admin.application.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div>

                                            <form action="{{ route('admin.application.store') }}" method="POST">
                                                @csrf

                                                <div class="mb-3">
                                                    <label for="inputRole" class="form-label mb-1">role</label>
                                                    <input
                                                        type="text"
                                                        name="role"
                                                        id="inputRole"
                                                        value="{{ old('role') }}"
                                                        class="form-control @error('role') is-invalid @enderror"
                                                        placeholder=""
                                                        required
                                                    >
                                                    @error('role')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputApplyDate" class="form-label mb-1">apply_date</label>
                                                    <input
                                                        type="date"
                                                        name="apply_date"
                                                        id="inputApplyDate"
                                                        value="{{ old('apply_date') }}"
                                                        class="form-control @error('apply_date') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('apply_date')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputCompensation" class="form-label mb-1">compensation</label>
                                                    <input
                                                        type="text"
                                                        name="compensation"
                                                        id="inputCompensation"
                                                        value="{{ old('compensation') }}"
                                                        class="form-control @error('compensation') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('compensation')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputDuration" class="form-label mb-1">duration</label>
                                                    <input
                                                        type="text"
                                                        name="duration"
                                                        id="inputDuration"
                                                        value="{{ old('duration') }}"
                                                        class="form-control @error('duration') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('duration')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputType" class="form-label mb-1">type</label>
                                                    <select
                                                        name="type"
                                                        id="inputType"
                                                        class="form-select"
                                                        required
                                                    >
                                                        @foreach([0=>'onsite', 1=>'remote', 2=>'hybrid'] as $value=>$label)
                                                            <option
                                                                value="{{ $value }}"
                                                                {{ $value == old('type') ? 'selected' : '' }}
                                                            >{{ $label }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('type')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputLocation" class="form-label mb-1">location</label>
                                                    <input
                                                        type="text"
                                                        name="location"
                                                        id="inputLocation"
                                                        value="{{ old('location') }}"
                                                        class="form-control @error('location') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('location')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputSource" class="form-label mb-1">source</label>
                                                    <input
                                                        type="text"
                                                        name="source"
                                                        id="inputSource"
                                                        value="{{ old('source') }}"
                                                        class="form-control @error('source') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('source')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputRating" class="form-label mb-1">rating</label>
                                                    <input
                                                        type="number"
                                                        name="rating"
                                                        id="inputRating"
                                                        value="{{ old('rating') }}"
                                                        class="form-control @error('rating') is-invalid @enderror"
                                                        placeholder="1, 2, 3, 4, or 5"
                                                    >
                                                    @error('rating')
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
                                                    <label for="inputDescription" class="form-label mb-1">description</label>
                                                    <textarea
                                                        name="description"
                                                        class="form-control"
                                                        id="inputDescription"
                                                        rows="3"
                                                        placeholder=""
                                                    >{{ old('description') }}</textarea>
                                                    @error('description')
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
