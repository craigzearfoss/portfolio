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
                                                    <label for="inputName" class="form-label mb-1">name</label>
                                                    <input
                                                        type="text"
                                                        name="name"
                                                        id="inputName"
                                                        value="{{ $video->name }}"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('name')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <input type="hidden" name="professional" value="0">
                                                    <input
                                                        type="checkbox"
                                                        name="professional"
                                                        id="inputProfessional"
                                                        class="form-check-input"
                                                        value="1"
                                                        {{ $video->professional ? 'checked' : '' }}
                                                    >
                                                    <label for="inputProfessional" class="form-check-label mb-1 font-semibold">professional</label>
                                                    @error('professional')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <input type="hidden" name="personal" value="0">
                                                    <input
                                                        type="checkbox"
                                                        name="personal"
                                                        id="inputPersonal"
                                                        class="form-check-input"
                                                        value="1"
                                                        {{ $video->personal ? 'checked' : '' }}
                                                    >
                                                    <label for="inputPersonal" class="form-check-label mb-1 font-semibold">personal</label>
                                                    @error('personal')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputDate" class="form-label mb-1">date</label>
                                                    <input
                                                        type="date"
                                                        name="date"
                                                        id="inputDate"
                                                        value="{{ $video->date }}"
                                                        class="form-control @error('date') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('date')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputYear" class="form-label mb-1">year</label>
                                                    <input
                                                        type="number"
                                                        name="year"
                                                        id="inputYear"
                                                        value="{{ $video->year }}"
                                                        class="form-control @error('year') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('year')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputCompany" class="form-label mb-1">company</label>
                                                    <input
                                                        type="text"
                                                        name="company"
                                                        id="inputCompany"
                                                        value="{{ $video->company }}"
                                                        class="form-control @error('company') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('company')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputCredit" class="form-label mb-1">credit</label>
                                                    <textarea
                                                        name="credit"
                                                        id="inputCredit"
                                                        class="form-control"
                                                        rows="3"
                                                        placeholder="">{{ $video->credit }}</textarea>
                                                    @error('credit')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputLocation" class="form-label mb-1">location</label>
                                                    <input
                                                        type="text"
                                                        name="location"
                                                        id="inputLocation"
                                                        value="{{ $video->location }}"
                                                        class="form-control @error('location') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('location')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputLink" class="form-label mb-1">link</label>
                                                    <input
                                                        type="text"
                                                        name="link"
                                                        id="inputLink"
                                                        value="{{ $video->link }}"
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
                                                        id="inputDescription"
                                                        class="form-control"
                                                        rows="3"
                                                        placeholder="">{{ $video->description }}</textarea>
                                                    @error('description')
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
                                                        {{ $video->disabled ? 'checked' : '' }}
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
