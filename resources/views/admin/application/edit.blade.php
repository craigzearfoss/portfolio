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
                        <h3 class="card-header ml-3">Edit Application</h3>
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
                                                    <a class="btn btn-sm btn-solid" href="{{ route('admin.application.show', $application) }}"><i class="fa fa-list"></i> Show</a>
                                                    <a class="btn btn-sm btn-solid" href="{{ route('admin.application.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="form-container">

                                            <form action="{{ route('admin.application.update', $application) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                @include('admin.components.form-input', [
                                                    'name'        => 'role',
                                                    'value'       => old('role') ?? $application->role,
                                                    'required'    => true,
                                                    'maxlength'   => 255,
                                                    'message'     => $message ?? '',
                                                ])

                                                <?php /*
                                                @include('admin.components.form-select', [
                                                    'name'    => 'company',
                                                    'value'   => old('company_id') ?? $application->company(),
                                                    'list'    => \App\Models\Career\Company::listOptions(true),
                                                    'message' => $message ?? '',
                                                ])
                                                */ ?>

                                                @include('admin.components.form-input', [
                                                    'type'        => 'number',
                                                    'name'        => 'rating',
                                                    'value'       => old('rating') ?? $application->rating,
                                                    'placeholder' => "0, 1, 2, 3, or 4",
                                                    'min'         => 1,
                                                    'max'         => 4,
                                                    'message'     => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'active',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('active') ?? $application->active,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'type'    => 'date',
                                                    'label'   => 'post date',
                                                    'name'    => 'post_date',
                                                    'value'   => old('post_date') ?? $application->post_date,
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'type'    => 'date',
                                                    'label'   => 'apply date',
                                                    'name'    => 'apply_date',
                                                    'value'   => old('apply_date') ?? $application->apply_date,
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'type'    => 'date',
                                                    'label'   => 'close date',
                                                    'name'    => 'close_date',
                                                    'value'   => old('close_date') ?? $application->close_date,
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'type'    => 'number',
                                                    'name'    => 'compensation',
                                                    'value'   => old('compensation') ?? $application->compensation,
                                                    'min'     => 0,
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-select', [
                                                    'label'   => 'compensation unit',
                                                    'name'    => 'compensation_unit',
                                                    'value'   => old('compensation_unit') ?? $application->compensation_unit,
                                                    'list'    => \App\Models\Career\Application::compensationUnitListOptions(true, true),
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'duration',
                                                    'value'     => old('duration') ?? $application->duration,
                                                    'maxlength' => 100,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-select', [
                                                    'name'    => 'type',
                                                    'value'   => old('type') ?? $application->type,
                                                    'list'    => \App\Models\Career\Application::typeListOptions(),
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-select', [
                                                    'name'    => 'office',
                                                    'value'   => old('office') ?? $application->office,
                                                    'list'    => \App\Models\Career\Application::officeListOptions(),
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'city',
                                                    'value'     => old('city') ?? $application->city,
                                                    'maxlength' => 100,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-select', [
                                                    'name'    => 'state',
                                                    'value'   => old('state') ?? $application->state,
                                                    'list'    => \App\Models\State::listOptions(true),
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'bonus',
                                                    'value'     => old('bonus') ?? $application->bonus,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'w2',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('w2') ?? $application->w2,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'relocation',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('relocation') ?? $application->relocation,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'benefits',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('benefits') ?? $application->benefits,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'vacation',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('vacation') ?? $application->vacation,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'health',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('health') ?? $application->health,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-select', [
                                                    'label'   => 'source',
                                                    'name'    => 'source',
                                                    'value'   => old('source') ?? $application->source,
                                                    'list'    => \App\Models\Career\JobBoard::listOptions(true, true),
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'link',
                                                    'value'     => old('link') ?? $application->link,
                                                    'maxlength' => 100,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'label'     => 'contact(s)',
                                                    'name'      => 'contacts',
                                                    'value'     => old('contacts') ?? $application->contacts,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'label'     => 'phone(s)',
                                                    'name'      => 'phones',
                                                    'value'     => old('phones') ?? $application->phones,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'label'     => 'email(s)',
                                                    'name'      => 'emails',
                                                    'value'     => old('emails') ?? $application->emails,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'website',
                                                    'value'     => old('website') ?? $application->website,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-textarea', [
                                                    'name'    => 'description',
                                                    'id'      => 'inputEditor',
                                                    'value'   => old('description') ?? $application->description,
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-button-submit', [
                                                    'label'      => 'Save',
                                                    'cancel_url' => route('admin.application.index')
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
