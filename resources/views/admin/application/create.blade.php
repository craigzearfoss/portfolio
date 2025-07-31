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
                                                    <label for="inputRating" class="form-label mb-1">rating</label>
                                                    <input
                                                        type="number"
                                                        name="rating"
                                                        id="inputRating"
                                                        value="{{ old('rating') }}"
                                                        class="form-control @error('rating') is-invalid @enderror"
                                                        placeholder="0, 1, 2, 3, or 4"
                                                    >
                                                    @error('rating')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <input type="hidden" name="active" value="0">
                                                    <input
                                                        type="checkbox"
                                                        name="active"
                                                        id="inputActive"
                                                        class="form-check-input"
                                                        value="1"
                                                        {{ old('active') ? 'checked' : '' }}
                                                    >
                                                    <label for="inputActive" class="form-check-label mb-1 font-semibold">active</label>
                                                    @error('active')
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
                                                        type="number"
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
                                                    <label for="inputCompensationUnit" class="form-label mb-1">compensation unit</label>
                                                    <select
                                                        name="compensation_unit"
                                                        id="inputCompensationUnit"
                                                        class="form-select"
                                                        required
                                                    >
                                                        @foreach(['', 'hour', 'year', 'month', 'week', 'day', 'project'] as $unit)
                                                            <option
                                                                value="{{ $unit }}"
                                                                {{ $unit == old('compensation_unit') ? 'selected' : '' }}
                                                            >{{ $unit }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('compensation_unit')
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
                                                        @foreach([0=>'permanent', 1>'contract', 2=>'contract-to-hire',3=>'project'] as $value=>$label)
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
                                                    <label for="inputOffice" class="form-label mb-1">office</label>
                                                    <select
                                                        name="office"
                                                        id="inputOffice"
                                                        class="form-select"
                                                        required
                                                    >
                                                        @foreach([0=>'onsite', 1=>'remote', 2=>'hybrid'] as $value=>$label)
                                                            <option
                                                                value="{{ $value }}"
                                                                {{ $value == old('office') ? 'selected' : '' }}
                                                            >{{ $label }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('office')
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
                                                    <select
                                                        name="state"
                                                        id="inputState"
                                                        class="form-select"
                                                        required
                                                    >
                                                        @foreach(['', 'AL','AK','AR','AZ','CA','CO','CT','DC','DE','FL','GA','HI','IA','ID','IL','IN','KS','KY','LA','MA','MD','ME','MI','MN','MS','MT','NC','ND','NE','NJ','NM','NV','NY','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','WA','WI','WY'] as $state)
                                                            <option
                                                                value="{{ $state }}"
                                                                {{ $state == old('state') ? 'selected' : '' }}
                                                            >{{ $state }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('state')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputBonus" class="form-label mb-1">bonus</label>
                                                    <input
                                                        type="text"
                                                        name="bonus"
                                                        id="inputBonus"
                                                        value="{{ old('bonus') }}"
                                                        class="form-control @error('bonus') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('bonus')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <input type="hidden" name="w2" value="0">
                                                    <input
                                                        type="checkbox"
                                                        name="w2"
                                                        id="inputW2"
                                                        class="form-check-input"
                                                        value="1"
                                                        {{ old('w2') ? 'checked' : '' }}
                                                    >
                                                    <label for="inputW2" class="form-check-label mb-1 font-semibold">w2</label>
                                                    @error('w2')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <input type="hidden" name="relocation" value="0">
                                                    <input
                                                        type="checkbox"
                                                        name="relocation"
                                                        id="inputBenefits"
                                                        class="form-check-input"
                                                        value="1"
                                                        {{ old('relocation') ? 'checked' : '' }}
                                                    >
                                                    <label for="inputBenefits" class="form-check-label mb-1 font-semibold">relocation</label>
                                                    @error('relocation')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <input type="hidden" name="benefits" value="0">
                                                    <input
                                                        type="checkbox"
                                                        name="benefits"
                                                        id="inputBenefits"
                                                        class="form-check-input"
                                                        value="1"
                                                        {{ old('benefits') ? 'checked' : '' }}
                                                    >
                                                    <label for="inputBenefits" class="form-check-label mb-1 font-semibold">benefits</label>
                                                    @error('benefits')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <input type="hidden" name="inputVacation" value="0">
                                                    <input
                                                        type="checkbox"
                                                        name="vacation"
                                                        id="inputVacation"
                                                        class="form-check-input"
                                                        value="1"
                                                        {{ old('vacation') ? 'checked' : '' }}
                                                    >
                                                    <label for="inputDisabled" class="form-check-label mb-1 font-semibold">vacation</label>
                                                    @error('vacation')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <input type="hidden" name="health" value="0">
                                                    <input
                                                        type="checkbox"
                                                        name="health"
                                                        id="inputHealth"
                                                        class="form-check-input"
                                                        value="1"
                                                        {{ old('health') ? 'checked' : '' }}
                                                    >
                                                    <label for="inputHealth" class="form-check-label mb-1 font-semibold">health</label>
                                                    @error('health')
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
                                                    <label for="inputContacts" class="form-label mb-1">contact(s)</label>
                                                    <input
                                                        type="text"
                                                        name="contacts"
                                                        id="inputContacts"
                                                        value="{{ old('contacts') }}"
                                                        class="form-control @error('contacts') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('contacts')
                                                    <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputPhones" class="form-label mb-1">phone(s)</label>
                                                    <input
                                                        type="text"
                                                        name="phones"
                                                        id="inputPhones"
                                                        value="{{ old('phones') }}"
                                                        class="form-control @error('phones') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('phones')
                                                    <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputEmails" class="form-label mb-1">email(s)</label>
                                                    <input
                                                        type="text"
                                                        name="emails"
                                                        id="inputEmails"
                                                        value="{{ old('emails') }}"
                                                        class="form-control @error('emails') is-invalid @enderror"
                                                        placeholder=""
                                                    >
                                                    @error('emails')
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
