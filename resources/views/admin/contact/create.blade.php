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
                        <h3 class="card-header ml-3">Add Contact</h3>
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
                                                    <a class="btn btn-sm btn-solid" href="{{ route('admin.contact.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div>

                                            <form action="{{ route('admin.contact.store') }}" method="POST">
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
                                                    <label for="inputStreet" class="form-label mb-1">street</label>
                                                    <input
                                                        type="text"
                                                        name="street"
                                                        id="inputStreet"
                                                        value="{{ old('street') }}"
                                                        class="form-control @error('street') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('street')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputStreet2" class="form-label mb-1">street 2</label>
                                                    <input
                                                        type="text"
                                                        name="street2"
                                                        id="inputStreet2"
                                                        value="{{ old('street2') }}"
                                                        class="form-control @error('street2') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('street2')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputCity" class="form-label mb-1">city</label>
                                                    <input
                                                        type="text"
                                                        name="city"
                                                        id="inputCity"
                                                        value="{{ old('city') }}"
                                                        class="form-control @error('city') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('city')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputState" class="form-label mb-1">state</label>
                                                    <input
                                                        type="text"
                                                        name="state"
                                                        id="inputState"
                                                        value="{{ old('state') }}"
                                                        class="form-control @error('state') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('state')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputZip" class="form-label mb-1">zip</label>
                                                    <input
                                                        type="text"
                                                        name="zip"
                                                        id="inputZip"
                                                        value="{{ old('zip') }}"
                                                        class="form-control @error('zip') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('zip')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputPhone" class="form-label mb-1">phone</label>
                                                    <input
                                                        type="text"
                                                        name="phone"
                                                        id="inputPhone"
                                                        value="{{ old('phone') }}"
                                                        class="form-control @error('phone') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('phone')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputPhoneLabel" class="form-label mb-1">phone label</label>
                                                    <input
                                                        type="text"
                                                        name="phone_label"
                                                        id="input"
                                                        value="{{ old('phone_label') }}"
                                                        class="form-control @error('phone_label') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('phone_label')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputAltPhone" class="form-label mb-1">alt phone</label>
                                                    <input
                                                        type="text"
                                                        name="alt_phone"
                                                        id="inputAltPhone"
                                                        value="{{ old('alt_phone') }}"
                                                        class="form-control @error('alt_phone') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('alt_phone')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputAltPhoneLabel" class="form-label mb-1">alt phone label</label>
                                                    <input
                                                        type="text"
                                                        name="inputAltPhoneLabel"
                                                        id="input"
                                                        value="{{ old('alt_phone_label') }}"
                                                        class="form-control @error('alt_phone_label') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('alt_phone_label')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputEmail" class="form-label mb-1">email</label>
                                                    <input
                                                        type="text"
                                                        name="email"
                                                        id="inputEmail"
                                                        value="{{ old('email') }}"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('email')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputEmailLabel" class="form-label mb-1">email label</label>
                                                    <input
                                                        type="text"
                                                        name="email_label"
                                                        id="input"
                                                        value="{{ old('email_label') }}"
                                                        class="form-control @error('email_label') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('email_label')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputAltEmail" class="form-label mb-1">alt email</label>
                                                    <input
                                                        type="text"
                                                        name="alt_email"
                                                        id="inputAltEmail"
                                                        value="{{ old('alt_email') }}"
                                                        class="form-control @error('alt_email') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('alt_email')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputAltEmailLabel" class="form-label mb-1">alt email label</label>
                                                    <input
                                                        type="text"
                                                        name="inputAltEmailLabel"
                                                        id="input"
                                                        value="{{ old('alt_email_label') }}"
                                                        class="form-control @error('alt_email_label') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('alt_email_label')
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
                                                    @error('email')
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
                                                        {{ $contact->disabled ? 'checked' : '' }}
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
