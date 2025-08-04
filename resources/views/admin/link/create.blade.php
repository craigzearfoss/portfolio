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
                        <h3 class="card-header ml-3">Add Link</h3>
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
                                                    <a class="btn btn-sm btn-solid" href="{{ route('admin.link.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="form-container">

                                            <form action="{{ route('admin.link.store') }}" method="POST">
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
                                                        {{ old('professional') ? 'checked' : '' }}
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
                                                        {{ old('personal') ? 'checked' : '' }}
                                                    >
                                                    <label for="inputPersonal" class="form-check-label mb-1 font-semibold">personal</label>
                                                    @error('personal')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputUrl" class="form-label mb-1">url</label>
                                                    <input
                                                        type="text"
                                                        name="url"
                                                        id="inputUrl"
                                                        value="{{ old('url') }}"
                                                        class="form-control @error('url') is-invalid @enderror"
                                                        placeholder=""
                                                        required
                                                    >
                                                    @error('url')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputWebsite" class="form-label mb-1">website</label>
                                                    <input
                                                        type="text"
                                                        name="website"
                                                        id="inputWebsite"
                                                        value="{{ old('website') }}"
                                                        class="form-control @error('website') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('website')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                @include('admin.components.form-textarea', [
                                                    'name'    => 'description',
                                                    'id'      => 'inputEditor',
                                                    'value'   => old('description'),
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'type'        => 'number',
                                                    'name'        => 'sequence',
                                                    'value'       => old('seq'),
                                                    'min'         => 0,
                                                    'message'     => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'hidden',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('hidden'),
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'disabled',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('disabled'),
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-button-submit', [
                                                    'label'      => 'Add Link',
                                                    'cancel_url' => route('admin.link.index')
                                                ])

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
